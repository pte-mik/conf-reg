import AbstractInput, {component, layout} from "gold-entity/lib/form/abstract-input";
import CList from "./list.svelte"

@component(CList)
@layout("row")
export default class ListInput extends AbstractInput {
}
