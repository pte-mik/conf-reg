import CString from "src/gold-entity/form/components/input/string.svelte"
import AbstractInput, {component, layout} from "../../abstract-input";

@component(CString)
@layout("row")
export default class StringInput extends AbstractInput {
}

