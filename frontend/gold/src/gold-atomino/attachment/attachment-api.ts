import handleFetch from "gold/handle-fetch";
import type {IAttachmentApi} from "../interfaces";

export default class AttachmentApi implements IAttachmentApi{

	constructor(protected apibase:string) {}

	get(id:number):Promise<Array<any>>{
		return fetch(this.apibase +'/attachment/get', {method:"POST", body:JSON.stringify({id})}).then(handleFetch)
	}
}