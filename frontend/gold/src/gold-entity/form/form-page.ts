import type FaIcon from "gold/fa-icon";
import Page from "gold/page";
import type PageManager from "gold/page-manager";
import type {SvelteComponent} from "svelte";
import type {Writable} from "svelte/store";
import CFormPage from "./components/form-page.svelte";
import type Form from "./form";

export default class FormPage extends Page {

	constructor(public form: Form) { super(); }
	get id(): string { return this.constructor.name + "-" + this.form.pageId; }
	get $title(): Writable<string> {return this.form.$title;}
	get $icon(): Writable<FaIcon> {return this.form.$icon;}
	get $isChanged(): Writable<boolean> {return this.form.$isChanged;}
	get component(): typeof SvelteComponent { return CFormPage;}

	attached(pageManager: PageManager) {
		super.attached(pageManager);
		this.form.attached(this);
	}
}