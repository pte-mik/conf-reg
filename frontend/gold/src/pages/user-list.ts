import Api from "gold-entity/lib/list/api";
import List, {button, list, buttons} from "gold-entity/lib/list/list";
import FaIcon from "gold/lib/fa-icon";
import UserForm from "./user-form";

@list(
	"Users",
	FaIcon.s("users"),
	new Api("/gold/user"),
	() => UserForm
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
