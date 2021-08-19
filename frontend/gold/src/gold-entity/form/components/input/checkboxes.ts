import AbstractInput, {component, layout} from "gold-entity/form/abstract-input";
import CCheckboxes from "./checkboxes.svelte"

interface IOption {
	label: string,
	value: any
}

@component(CCheckboxes)
@layout("row")
export default class CheckboxesInput extends AbstractInput {

	public options: Array<IOption> = [];

	Options(options: Array<IOption>): this {
		this.options = options;
		return this;
	}
}