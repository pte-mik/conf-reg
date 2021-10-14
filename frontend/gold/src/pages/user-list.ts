import List, {button, list, buttons} from "gold-admin/list/list";
import FaIcon from "gold-admin/fa-icon";
import ListApi from "gold-admin/list/list-api";
import UserForm from "./user-form";

@list(
	"Users",
	FaIcon.s("users"),
	new ListApi("/gold/user"),
	() => UserForm,
	true
)
@button(buttons.new)
export default class UserList extends List {
	cardifyItem(item: any) {
		return {
			id: item.id,
			title: item.name,
			active: true,
			subtitle: item.email,
			click: () => this.open(item),
		}
	}
}
