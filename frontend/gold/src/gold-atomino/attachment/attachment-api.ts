import handleFetch from "gold/handle-fetch";
import type {IAttachmentApi} from "../interfaces";

export default class AttachmentApi implements IAttachmentApi {

	constructor(protected apibase: string) {}

	get(id: number): Promise<Array<any>> {
		return fetch(this.apibase + '/attachment/get/' + id, {method: "POST", body: JSON.stringify({id})}).then(handleFetch)
	}

	removeFile(id: number, collection: string, filename: string): Promise<any> {
		return fetch(this.apibase + '/attachment/remove-file/' + id, {method: "POST", body: JSON.stringify({id, filename, collection})}).then(handleFetch)
	}

	saveFileDetails(id: number, filename: string, data: any): Promise<any> {
		return fetch(this.apibase + '/attachment/save-file-details/' + id, {method: "POST", body: JSON.stringify({id, filename, data})}).then(handleFetch)
	}

	upload(id: number, collection: string, files: FileList): Promise<any> {
		let jobs: Array<Promise<any>> = [];
		// @ts-ignore
		[...files].forEach((file) => {
			console.log(file)
			let data = new FormData()
			data.append('file', file)
			data.append('collection', collection)
			data.append('id', id.toString())
			jobs.push(fetch(this.apibase + '/attachment/upload/' + id, {method: "POST", body: data}));
		})
		return Promise.all(jobs);
	}
	moveFile(id: number, filename: string, source: string, target: string, position: number, copy: boolean): Promise<any> {
		return fetch(this.apibase + '/attachment/move-file/' + id, {method: "POST", body: JSON.stringify({id, filename, source, target, position, copy})}).then(handleFetch)
	}
}
