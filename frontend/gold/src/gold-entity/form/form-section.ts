import type AbstractInput from "./abstract-input";
import type FaIcon from "gold/fa-icon";

export default class FormSection {

	public controls: Array<AbstractInput> = [];
	public role:Array<string>|null = null;

	constructor(public title: string | null = null, public icon: FaIcon | null = null, public sizes:Array<string> = ['is-full']) {}

	addControl(control:AbstractInput){
		this.controls.push(control);
		return this;
	}

	public setRole(role:string|Array<string>):this{
		this.role = typeof role === "string" ? [role] : role;
		return this;
	}
}