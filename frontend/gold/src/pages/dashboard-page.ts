import FaIcon from "gold/fa-icon";
import Page from "gold/page";
import type {SvelteComponent} from "svelte";
import DashboardComponent from "src/components/dashboard-page.svelte";
import {writable} from "svelte/store";
import type {Writable} from "svelte/store";

export default class DashboardPage extends Page {
	public closeable:boolean = false;
	get $title(): Writable<string> {return writable('');}
	get $icon(): Writable<FaIcon> {return writable(FaIcon.s('dice-d6')) ;}
	get component(): typeof SvelteComponent { return DashboardComponent;}
}

