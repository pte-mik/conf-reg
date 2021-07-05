import {PresentationShadow} from "./shadow/presentation";
import Event from "./event";
import User from "./user";

export default class Presentation extends PresentationShadow{
	static find(user:User, event:Event):Array<Presentation>{
		let presentations:Array<Presentation> = [];
		return presentations;
	}
}
