import type FaIcon from "gold/fa-icon";

export default class FormButton {
	constructor(public icon: FaIcon, public action: Function, public onlyIfExists:boolean = false) {}
}