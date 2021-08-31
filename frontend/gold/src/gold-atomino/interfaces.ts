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
	get(id:number):Promise<Array<any>>
}