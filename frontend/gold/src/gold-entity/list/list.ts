import FaIcon from "gold/fa-icon";
import handleFetch from "gold/handle-fetch";
import GoldList from "gold/list";
import type ListManager from "gold/list-manager";
import type {SvelteComponent} from "svelte";
import {get, writable, Writable} from "svelte/store";
import type Form from "../form/form";
import FormPage from "../form/form-page";
import type {IListApi, IListOptions} from "../interfaces";
import CCard from "./components/card.svelte";
import CList from "./components/list.svelte";
import ListButton from "./list-button";
import options from "gold-entity/options";

export default abstract class List extends GoldList {

	cardifyItem(item: any) {return item;}

	constructor() {
		super();
		for (let button of (this.constructor as typeof List).buttons) {
			this.addButton(new ListButton(button.icon, () => button.action(this)))
		}
	}

	static get id(): string {return this.name;}
	static icon: FaIcon;
	static title: string;
	static api: IListApi;
	static form: () => typeof Form;
	static buttons: Array<{ icon: FaIcon, action: (list: List) => void }> = [];

	get id(): string {
		// @ts-ignore
		return this.constructor.id;
	}

	public options: IListOptions = {
		quicksearch: false,
		views: false,
		sortings: false,
		pagesize: 5
	}

	// @ts-ignore
	public $items: Writable<Array<any>> = writable([]);
	public $count: Writable<number> = writable(0);
	public $page: Writable<number> = writable(1);

	public view: string | null = null;
	public sorting: string | null = null;
	public quicksearch: string = "";
	public filter: any;
	public buttons: Array<ListButton> = [];

	get icon(): FaIcon { return (this.constructor as typeof List).icon;}
	get title(): string { return (this.constructor as typeof List).title;}
	get api(): IListApi {return (this.constructor as typeof List).api;}
	get form(): typeof Form {return (this.constructor as typeof List).form();}

	get component(): typeof SvelteComponent { return CList;}
	get card(): typeof SvelteComponent { return CCard;}

	public addButton(button: ListButton) {
		this.buttons.push(button);
	}

	public open(item: any) {
		// @ts-ignore
		this.listManager!.pageManager!.add(new FormPage(new this.form(item.id)));
	}

	async attached(listManager: ListManager): Promise<any> {
		await super.attached(listManager);
		await this.setOptions();
		if (this.options.sortings !== null) this.sorting = '+' + Object.keys(this.options.sortings)[0];
		if (this.options.views !== null) this.view = Object.keys(this.options.views)[0];
		await this.reload();
	}

	async setOptions(): Promise<any> {
		const res = await this.api.getOptions();
		this.options = Object.assign(this.options, await handleFetch(res));
	}

	async reload() {
		const data = await this.api!.get(this.options.pagesize, get(this.$page), this.view, this.sorting, this.quicksearch, this.filter);
		this.$items.set(data.items);
		this.$count.set(data.count);
		this.$page.set(data.page);
	}

	addNew() {
		// @ts-ignore
		this.listManager!.pageManager!.add(new FormPage(new this.form()));
	}
}


export let buttons: Record<"new", { icon: FaIcon, action: (form: List) => void }> = {
	new: {
		icon: options.list.new.icon,
		action: (list: List) => list.addNew()
	}
}

export function button(icon: FaIcon | { icon: FaIcon, action: (list: List) => void }, action: ((list: List) => void) | null = null) {
	return function (constructor: typeof List) {
		if (icon instanceof FaIcon && action !== null) constructor.buttons.push({icon, action})
		else if (!(icon instanceof FaIcon)) constructor.buttons.push(icon);
	}
}

export function list(title: string, icon: FaIcon, api: IListApi, form: () => typeof Form) {
	return function (constructor: typeof List) {
		constructor.icon = icon;
		constructor.title = title;
		constructor.api = api;
		constructor.form = form;
	}
}