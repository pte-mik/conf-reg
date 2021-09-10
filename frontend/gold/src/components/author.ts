import AbstractInput, {component, layout} from "gold-entity/lib/form/abstract-input";
import CAuthor from "./author.svelte"

@component(CAuthor)
@layout("row")
export default class AuthorInput extends AbstractInput {
}
