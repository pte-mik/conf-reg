// import {UserShadow} from "./shadow/user";
// import {event} from "../stores";
// import Presentation from "./presentation";
//
// export default class User extends UserShadow {
//  	protected relationStore: any = {};
// 	get presentations(): Array<Presentation> | null { return Presentation.find(this, event); }
// }

import type Author from "./author";

export let status = {
	draft: {type: "info", icon: "edit", label: "Draft"},
	underReview: {type: "info", icon: "file-search", label: "Under Review"},
	accepted: {type: "success", icon: "check", label: "Accepted"},
	declined: {type: "danger", icon: "times", label: "Declined"},
}


export default interface Submission{
	id:number;
	title:string;
	text:string;
	category:string;
	status:string;
	authors:Array<Author>;
	keywords: Array<string>;
	image: null|string,
	originalImage: null|string,
	imageCaption: string
}
