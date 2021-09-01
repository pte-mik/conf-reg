import attachmentButton from "gold-atomino/attachment/form-button";
import ItemApi from "gold-entity/form/api";
import CheckboxesInput from "gold-entity/form/components/input/checkboxes";
import ColorInput from "gold-entity/form/components/input/color";
import ComboboxInput from "gold-entity/form/components/input/combobox";
import DateInput from "gold-entity/form/components/input/date";
import DateTimeInput from "gold-entity/form/components/input/datetime";
import NumberInput from "gold-entity/form/components/input/number";
import PasswordInput from "gold-entity/form/components/input/password";
import RadioInput from "gold-entity/form/components/input/radio";
import SelectInput from "gold-entity/form/components/input/select";
import StringInput from "gold-entity/form/components/input/string";
import SwitchInput from "gold-entity/form/components/input/switch";
import TextInput from "gold-entity/form/components/input/text";
import TimeInput from "gold-entity/form/components/input/time";
import Form, {button, buttons, form} from "gold-entity/form/form";
import FaIcon from "gold/fa-icon";
import UserList from "src/pages/user-list";
import AttachmentApi from "gold-atomino/attachment/attachment-api";
@form(
	FaIcon.l("user"),
	new ItemApi("/gold/user"),
	() => UserList
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
@button(attachmentButton(new AttachmentApi('/gold/user'), {"avatar":"Avatar", images:"Képek"}))

export default class UserForm extends Form {

	setTitle(item: any) { this.title = this.id === null ? "new user" : item.name;}

	build() {
		this.addSection("adatok", FaIcon.s('users'))
			.setRole("edit")
			.addControl(new StringInput("name", "név").Layout("column"))
			.addControl(new StringInput("email", "e-mail"))
			.addControl(new SwitchInput("switch", "kapcs"))
			.addControl(new PasswordInput('password'))
			.addControl(new ComboboxInput("bossId", "boss").Api('/gold/user'))
			.addControl(new ComboboxInput("workerIds", "workers").Multi(3).Api('/gold/user').Form(UserForm))
			.addControl(new TextInput('text').Markdown())
			.addControl(new TextInput('text').Code())
			.addControl(new TextInput('text'))

		this.addSection("adatok", FaIcon.s('users'), ["is-full", "is-half-desktop"])
			.addControl(new StringInput("guid", "azonosít gu-id"))
			// .addControl(new TextInput("guid", "azonosít gu-id"))
			// .addControl(new TextInput("guid", "azonosít gu-id").Code())
			// .addControl(new TimeInput("test", "idő"))
		this.addSection("adatok", FaIcon.s('users'), ["is-full", "is-half-desktop"])
			.addControl(new SelectInput("group", ).Options([{value:null, label:"-"},{value: 'admin', label: "admin"}, {value: 'moderator', label: "moderator"}, {value:"visitor", label:'visitor'}]))
			.addControl(new RadioInput("group", ).Options([{value:null, label:"-"},{value: 'admin', label: "admin"}, {value: 'moderator', label: "moderator"}, {value:"visitor", label:'visitor'}]))
			.addControl(new CheckboxesInput("test", "csekkbox").Options([{value: 'alfa', label: "Alfa"}, {value: "beta", label: "beta"}, {value:'gamma', label:"game"}]))
			// .addControl(new NumberInput("teste", "idő").Step(12))
			// .addControl(new DateTimeInput("created", "idő"))
			// .addControl(new DateInput("updated", "idő"))
			// .addControl(new ColorInput("color", "idő"))
	}

}

