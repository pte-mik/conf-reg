import type FaIcon from "gold/fa-icon";

export default class MenuItem{
	constructor(public label:string, public icon:FaIcon|null, public action:Function|Array<MenuItem>) {}
}