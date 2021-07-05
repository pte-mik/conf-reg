// import {UserShadow} from "./shadow/user";
// import {event} from "../stores";
// import Presentation from "./presentation";
//
// export default class User extends UserShadow {
//  	protected relationStore: any = {};
// 	get presentations(): Array<Presentation> | null { return Presentation.find(this, event); }
// }


export default interface Event{
	title:string;
	website:string;
	deadline:string;
	categories:Array<string>;
}