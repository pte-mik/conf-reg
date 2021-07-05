import {readable, Readable, writable, Writable} from "svelte/store";
import Event from "./entities/event";
import {EventDTO, EventShadow} from "./entities/shadow/event";


let siteDataString: string | undefined | null = document.head.querySelector('meta[name="data"]')?.getAttribute('content');
let siteData: SiteData | null = typeof siteDataString === "string" ? JSON.parse(atob(siteDataString)) : null;

export const event: Event = Event.create(siteData?.event || new Event());
export const user: Writable<object | null> = writable(null);

interface SiteData {
	event: EventDTO;
}