import type {IListApi} from "gold-entity/interfaces";
import handleFetch from "gold/handle-fetch";

export default class Api implements IListApi {

	constructor(private apiBase: string) {}

	getOptions(): Promise<any> { return fetch(this.apiBase + '/list/options', {method: "POST"});}
	get(pagesize: number, page: number, view: string | null, sorting: string | null, quicksearch:string, filter:any): Promise<any> {
		return fetch(this.apiBase + '/list/get', {method: "POST", body: JSON.stringify({pagesize, page, sorting, view, quicksearch, filter})}).then(handleFetch);
	}
}