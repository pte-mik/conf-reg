import type FaIcon from "gold/fa-icon";


export interface IOptions {
	attachment: {
		button: { icon: FaIcon }
		modal:{
			upload:{ icon: FaIcon }
		}
	}
}

export interface IAttachmentApi{
	removeFile(id:number, filename:string, collection:string):Promise<any>
	saveFileDetails(id:number, filename:string, data:any):Promise<any>
	get(id:number):Promise<Array<any>>
	upload(id:number, collection:string, files:FileList):Promise<any>
	moveFile(id:number, filename: string, source: string, target: string, position: number, copy: boolean):Promise<any>
}