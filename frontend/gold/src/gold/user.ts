import {writable} from "svelte/store";
import type {Writable} from "svelte/store";
import type {IUser} from "./interfaces";

let user:Writable<IUser|null> = writable(null);

export default user;