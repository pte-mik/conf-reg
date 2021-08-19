import CDate from "src/gold-entity/form/components/input/date.svelte"
import AbstractInput, {component, layout} from "../../abstract-input";

@component(CDate)
@layout("row")
export default class DateInput extends AbstractInput {
}
