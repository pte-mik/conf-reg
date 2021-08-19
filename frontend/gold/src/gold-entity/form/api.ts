import type {IFormApi} from "../interfaces";
import handleFetch from "gold/handle-fetch";

export default class Api implements IFormApi {

	constructor(private apiBase: string) {}

	getOptions(): Promise<any> {
		return fetch(this.apiBase + "/get-options", {method: "POST"});
	}
	get(id: number): Promise<any> {
		return fetch(this.apiBase + "/get", {method: "POST", body: JSON.stringify({id})}).then(handleFetch);
	}
	blank(): Promise<any> {
		return fetch(this.apiBase + "/blank", {method: "POST"}).then(handleFetch);
	}
	create(item: any): Promise<false | null | number> {
		return fetch(this.apiBase + "/create", {method: "POST", body: JSON.stringify({item})}).then(handleFetch);
	}
	update(item: any): Promise<false | null | number> {
		return fetch(this.apiBase + "/update", {method: "POST", body: JSON.stringify({item})}).then(handleFetch);
	}
	delete(id: number): Promise<boolean> {
		return fetch(this.apiBase + "/delete", {method: "POST", body: JSON.stringify({id})}).then(handleFetch).then(() => true);
	}

}