import ItemApi from "gold-entity/form/api";
import CheckboxesInput from "gold-entity/form/components/input/checkboxes";
import ColorInput from "gold-entity/form/components/input/color";
import DateInput from "gold-entity/form/components/input/date";
import DateTimeInput from "gold-entity/form/components/input/datetime";
import NumberInput from "gold-entity/form/components/input/number";
import RadioInput from "gold-entity/form/components/input/radio";
import SelectInput from "gold-entity/form/components/input/select";
import StringInput from "gold-entity/form/components/input/string";
import SwitchInput from "gold-entity/form/components/input/switch";
import TextInput from "gold-entity/form/components/input/text";
import TimeInput from "gold-entity/form/components/input/time";
import Form, {button, buttons, form} from "gold-entity/form/form";
import FaIcon from "gold/fa-icon";
import UserList from "src/pages/user-list";

@form(
	FaIcon.l("user"),
	new ItemApi("/gold/user"),
	() => UserList
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
@button(buttons.attachments)

export default class UserForm extends Form {

	setTitle(item: any) { this.title = this.id === null ? "new user" : item.name;}

	build() {
		this.addSection("adatok", FaIcon.s('users'))
			.addControl(new StringInput("name", "név").Layout("column"))
			.addControl(new StringInput("email", "e-mail"))
			.addControl(new SwitchInput("kapcs", "e-mail"))
			//.addControl(new SelectorInput("thing", "thing").Api('/gold/user').Form(UserForm))
		this.addSection("adatok", FaIcon.s('users'), ["is-full", "is-half-desktop"])
			.addControl(new StringInput("guid", "azonosít gu-id"))
			.addControl(new TextInput("guid", "azonosít gu-id"))
			.addControl(new TextInput("guid", "azonosít gu-id").Code())
			.addControl(new TimeInput("test", "idő"))
		this.addSection("adatok", FaIcon.s('users'), ["is-full", "is-half-desktop"])
			.addControl(new SelectInput("testw", "idő").Options([{value: 1, label: "Első"}, {value: 2, label: "Második"}]))
			.addControl(new RadioInput("testq", "idő").Options([{value: 1, label: "Első"}, {value: 2, label: "Második"}]))
			.addControl(new CheckboxesInput("testz", "csekkbox").Options([{value: 1, label: "Első"}, {value: 2, label: "Második"}]))
			.addControl(new NumberInput("teste", "idő").Step(12))
			.addControl(new DateTimeInput("created", "idő"))
			.addControl(new DateInput("updated", "idő"))
			.addControl(new ColorInput("color", "idő"))
	}

}

