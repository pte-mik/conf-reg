import type PageManager from "gold/page-manager";
import type List from "./list";
import {writable} from "svelte/store";
import type {Writable} from "svelte/store";


export default class ListManager {

	public pageManager:PageManager|null = null;
	protected lists: Array<List> = [];
	protected active: List | null = null;

	public $lists: Writable<Array<List>> = writable(this.lists);
	public $active: Writable<List | null> = writable(this.active);

	private getIndex(id: string) { return this.lists.findIndex(item => item.id === id);}
	public getList(id: string) { return this.lists[this.getIndex(id)];}

	public update() {
		this.$lists.update(() => this.lists);
		this.$active.update(() => this.active);
	}

	public add(list: List) {
		let index = this.getIndex(list.id);
		if (index === -1) {
			this.lists.push(list);
			this.active = list;
			list.attached(this).then(()=>this.update());
		} else if (this.lists[index].id !== this.active?.id) {
			this.active = this.lists[index];
			this.update();
		}
	}
}
