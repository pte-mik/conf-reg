import type AbstractInput from "./abstract-input";
import type FaIcon from "gold/fa-icon";

export default class FormSection {

	public controls: Array<AbstractInput> = [];

	constructor(public title: string | null = null, public icon: FaIcon | null = null, public sizes:Array<string> = ['is-full']) {}

	addControl(control:AbstractInput){
		this.controls.push(control);
		return this;
	}
}