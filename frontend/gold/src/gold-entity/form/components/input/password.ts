import CPassword from "src/gold-entity/form/components/input/password.svelte"
import AbstractInput, {component, layout} from "../../abstract-input";

@component(CPassword)
@layout("row")
export default class PasswordInput extends AbstractInput {
}

