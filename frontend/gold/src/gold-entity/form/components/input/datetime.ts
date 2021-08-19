import CDateTime from "src/gold-entity/form/components/input/datetime.svelte"
import AbstractInput, {component, layout} from "../../abstract-input";

@component(CDateTime)
@layout("row")
export default class DateTimeInput extends AbstractInput {
}
