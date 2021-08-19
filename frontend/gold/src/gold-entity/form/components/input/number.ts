import AbstractInput, {component, layout} from "gold-entity/form/abstract-input";
import CNumber from "./number.svelte"

@component(CNumber)
@layout("row")
export default class NumberInput extends AbstractInput {
	public min:number|null = 0;
	public max:number|null = null;
	public step:number = 1;

	Step(step:number):this{
		this.step = step;
		return this;
	}

	Min(min:number=0):this{
		this.min = min;
		return this;
	}
	Max(max:number=0):this{
		this.max = max;
		return this;
	}
}