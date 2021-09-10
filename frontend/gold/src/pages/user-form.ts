
import AttachmentApi from "gold-attachment/lib/attachment-api";
import attachmentButton from "gold-attachment/lib/form-button";
import ItemApi from "gold-entity/lib/form/api";
import CheckboxesInput from "gold-entity/lib/form/input/checkboxes";
import ComboboxInput from "gold-entity/lib/form/input/combobox";
import PasswordInput from "gold-entity/lib/form/input/password";
import RadioInput from "gold-entity/lib/form/input/radio";
import SelectInput from "gold-entity/lib/form/input/select";
import StringInput from "gold-entity/lib/form/input/string";
import SwitchInput from "gold-entity/lib/form/input/switch";
import TextInput from "gold-entity/lib/form/input/text";
import Form, {button, buttons, form} from "gold-entity/lib/form/form";
import FaIcon from "gold/lib/fa-icon";
import UserList from "./user-list";

@form(
	FaIcon.s("user"),
	new ItemApi("/gold/user"),
	() => UserList
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
export default class UserForm extends Form {

	setTitle(item: any) { this.title = this.id === null ? "new user" : item.name;}

	build() {
		this.addSection()
			.setRole("edit")
			.addControl(new StringInput("name"))
			.addControl(new StringInput("email"))
			.addControl(new StringInput("phone"))
			.addControl(new PasswordInput('password'))
	}

}
