import {readable, Readable, writable, Writable} from "svelte/store";
import type Event from "./entities/event"
import type User from "./entities/user"

let siteDataString: string | undefined | null = document.head.querySelector('meta[name="data"]')?.getAttribute('content');

let siteData: SiteData = typeof siteDataString === "string" ? JSON.parse(atob(siteDataString)) : null;

export const user: Writable<User | null> = writable(null);
export const event: Readable<Event> = readable(siteData.event);

interface SiteData {event: Event;}