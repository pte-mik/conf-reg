// @ts-ignore
import type ListManager from "gold/list-manager";
import type Page from "./page";
import {get, writable} from "svelte/store";
import type {Writable} from "svelte/store";

export default class PageManager {

	public listManager: ListManager | null = null;
	protected pages: Array<Page> = [];
	protected active: Page | null = null;

	public $pages: Writable<Array<Page>> = writable(this.pages);
	public $active: Writable<Page | null> = writable(this.active);

	private getIndex(page: Page) { return this.pages.findIndex(item => item.id === page.id);}
	public update() {
		this.$pages.set( this.pages);
		this.$active.set( this.active);
	}

	public remove(page: Page) {
		let index = this.getIndex(page);
		if (index !== -1) {
			if (this.active?.id === page.id) {
				if (index === 0) {
					if (this.pages.length > 2) {
						this.active = this.pages[1];
					} else {
						this.active = null;
					}
				} else {
					this.active = this.pages[index - 1];
				}
			}
			this.pages.splice(index, 1);
			this.update();
			page.detached();
		}
	}

	public add(page: Page) {
		let index = this.getIndex(page);
		if (index === -1) {
			this.pages.push(page);
			this.active = page;
			this.update();
			page.attached(this);
		} else if (this.pages[index].id !== this.active?.id) {
			this.active = this.pages[index];
			this.update();
		}
	}
}
