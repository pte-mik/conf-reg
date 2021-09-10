import Api from "gold-entity/lib/list/api";
import List, {button, list, buttons} from "gold-entity/lib/list/list";
import FaIcon from "gold/lib/fa-icon";
import EventForm from "src/pages/event-form";
import SubmissionForm from "src/pages/submission-form";
import UserForm from "./user-form";

@list(
	"Submissions",
	FaIcon.s("scroll"),
	new Api("/gold/submission"),
	() => SubmissionForm
)
@button(buttons.new)
export default class SubmissionList extends List {
	cardifyItem(item: any) {
		return {
			id: item.id,
			title: item.title,
			active: true,
			subtitle: item.status,
			properties:[
				{label:'user', value: item.userName}
			],
			click: () => this.open(item),
		}
	}
}
