import Confirm from "gold-entity/form/components/confirm.svelte";
import type {IFormApi} from "gold-entity/interfaces";
import options from "gold-entity/options";
import FaIcon from "gold/fa-icon";
import {Modal} from "gold/modal-manager";
import type Page from "gold/page";
import toast from "gold/toast";
import type {SvelteComponent} from "svelte";
import type {Writable} from "svelte/store";
import {get, writable} from "svelte/store";
import type List from "../list/list";
import FormButton from "./form-button";
import FormSection from "./form-section";

export default abstract class Form {

	static buttons: Array<{ icon: FaIcon, action: (form: Form) => void, onlyIfExists: boolean }> = [];
	static icon: FaIcon;
	static api: IFormApi;
	static list: (() => typeof List | Array<typeof List>) | null;
	public list: typeof List | Array<typeof List> | null;
	public api: IFormApi | null = null;
	public buttons: Array<FormButton> = [];

	constructor(id: number | string | null = null) {
		if (typeof id === "string") id = parseInt(id);
		this.id = id;
		let list = (this.constructor as typeof Form).list;
		this.list = list === null ? null : list();
		this.api = (this.constructor as typeof Form).api;
		this.icon = (this.constructor as typeof Form).icon;
		for (let button of (this.constructor as typeof Form).buttons) {
			this.addButton(new FormButton(button.icon, () => button.action(this), button.onlyIfExists))
		}
		this.build();
	}

	abstract build(): void;

	// public $modal: Writable<{ component: typeof SvelteComponent, props: any } | null> = writable(null);
	// public openModal(component: typeof SvelteComponent, props: {} = {}) { this.$modal.set({component, props});}
	// public closeModal() { this.$modal.set(null);}

	public sections: Array<FormSection> = [];
	public page: Page | null = null;

	public $icon: Writable<FaIcon> = writable(FaIcon.l("star"));
	public $id: Writable<number | null> = writable(null);
	public $title: Writable<string> = writable('...');
	public $isChanged: Writable<boolean> = writable(false);

	public $item: Writable<any> = writable({});

	public set title(title: string) {this.$title.set(title) }
	public set icon(icon: FaIcon) {this.$icon.set(icon) }
	public set id(id: number | null) {this.$id.set(id) }
	public get id(): number | null {return get(this.$id) }
	public set changed(state: boolean) {
		this.$isChanged.set(state);
		this.setTitle(get(this.$item));
	}
	public $errors: Writable<Array<any>> = writable([]);
	public set errors(errors: Array<any> | null) {
		if (errors === null) errors = [];
		this.$errors.set(errors);
	}

	get pageId(): string { return 'entity-' + this.constructor.name + (get(this.$id) === null ? '' : '-' + get(this.$id));}
	set loading(loading: boolean) {this.page && (this.page.loading = false);}

	public addButton(button: FormButton) {this.buttons.push(button);}

	public addSection(title: string | null = null, icon: FaIcon | null = null, sizes: Array<string> = ["is-full"]) {
		let section = new FormSection(title, icon, sizes);
		this.sections.push(section);
		return section;
	}

	public setTitle(item: any) { this.title = this.id === null ? "new" : this.id.toString(); }

	public async attached(page: Page) {
		this.page = page;
		await this.loadItem();
	}

	public async loadItem(): Promise<any> {
		this.page!.loading = true;
		try {
			let data = await (this.id === null ? this.api!.blank() : this.api!.get(this.id));
			this.$item.set(data);
			this.setTitle(data);
			this.page!.loading = false;
			this.changed = false;
			this.errors = null;
		} catch (e) {
			this.page?.pageManager?.remove(this.page);
		}
	}

	public async saveItem(): Promise<any> {
		this.page!.loading = true;
		let item = get(this.$item);
		try {
			let id1 = await (this.id === null ? this.api!.create(item) : this.api!.update(item));
			if (typeof id1 === "number") this.id = id1;
			toast.success("Item saved");
			this.reloadList();
			return this.loadItem();
		} catch (e) {
			if (e.code === 422) this.errors = e.messages;
		} finally {
			this.page!.loading = false;
		}
	}

	public async deleteItem(): Promise<boolean> {

		let modal = new Modal(Confirm, {
			title: "Are you sure?",
			content: "Do you really want to delete this item?",
			form: this,
			buttons: [
				{
					label: "Cancel",
					style: "is-primary",
					action: () => {modal.close()}
				},
				{
					label: "Delete",
					style: "is-danger",
					action: async () => {
						modal.close();
						this.page!.loading = true;
						if (typeof this.id !== 'number') throw "ERROR";
						await this.api!.delete(this.id);
						this.reloadList();
						this.page!.loading = false;
						this.page?.pageManager?.remove(this.page);
					}
				}
			]
		});
		modal.open();
		return true;
	}

	protected reloadList() {
		let list: typeof List | Array<typeof List> | null = this.list;
		if (list === null) return;
		if (list instanceof Array) {
			for (let l of list) {
				(this.page!.pageManager!.listManager!.getList(l.id) as List)?.reload();
			}
		} else {
			(this.page!.pageManager!.listManager!.getList(list.id) as List)?.reload();
		}
	}

}

export function form(icon: FaIcon, api: IFormApi, list: (() => typeof List | Array<typeof List>) | null = null) {
	return function (constructor: typeof Form) {
		constructor.icon = icon;
		constructor.list = list;
		constructor.api = api;
	}
}

export function button(icon: FaIcon | { icon: FaIcon, action: (form: Form) => void, onlyIfExists: boolean }, action: ((form: Form) => void) | null = null, onlyIfExists: boolean = false) {
	return function (constructor: typeof Form) {
		if (icon instanceof FaIcon && action !== null) constructor.buttons.push({icon, action, onlyIfExists});
		if (!(icon instanceof FaIcon)) constructor.buttons.push(icon);
	}
}


export let buttons: Record<"save" | "reload" | "delete", { icon: FaIcon, action: (form: Form) => void, onlyIfExists: boolean }> = {
	save: {
		icon: options.form.button.save.icon,
		action: (form: Form) => form.saveItem(),
		onlyIfExists: false
	},
	reload: {
		icon: options.form.button.reload.icon,
		action: (form: Form) => form.loadItem(),
		onlyIfExists: true
	},
	delete: {
		icon: options.form.button.delete.icon,
		action: (form: Form) => form.deleteItem(),
		onlyIfExists: true
	}
}