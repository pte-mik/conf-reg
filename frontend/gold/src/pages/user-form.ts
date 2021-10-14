import controls from "gold-admin/form-input/controls";
import Form, {button, buttons, form} from "gold-admin/form/form";
import FaIcon from "gold-admin/fa-icon";
import FormApi from "gold-admin/form/form-api";
import UserList from "./user-list";

@form(
	FaIcon.s("user"),
	new FormApi("/gold/user"),
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
			.addControl(new controls.string("name"))
			.addControl(new controls.string("email"))
			.addControl(new controls.string("phone"))
			.addControl(new controls.password('password'))
	}

}
