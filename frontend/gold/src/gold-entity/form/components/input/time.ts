import CTime from "src/gold-entity/form/components/input/time.svelte"
import AbstractInput, {component, layout} from "../../abstract-input";

@component(CTime)
@layout("row")
export default class TimeInput extends AbstractInput {
}
