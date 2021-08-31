import CText from "src/gold-entity/form/components/input/text.svelte"
import AbstractInput, {component, layout} from "../../abstract-input";

@component(CText)
@layout("column")
export default class TextInput extends AbstractInput {

	public code:boolean = false;
	public markdown: boolean = false;

	Code():this{
		this.code = true;
		return this;
	}

	Markdown():this{
		this.code = true;
		this.markdown = true;
		return this;
	}
}

