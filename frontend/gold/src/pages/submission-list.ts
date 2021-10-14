import List, {button, list, buttons} from "gold-admin/list/list";
import FaIcon from "gold-admin/fa-icon";
import ListApi from "gold-admin/list/list-api";
import SubmissionForm from "src/pages/submission-form";

@list(
	"Submissions",
	FaIcon.s("scroll"),
	new ListApi("/gold/submission"),
	() => SubmissionForm,
	true
)
@button(buttons.new)
export default class SubmissionList extends List {
	cardifyItem(item: any) {
		return {
			id: item.id,
			title: item.title,
			active: true,
			properties:[
				{label:'user', value: item.userName},
				{label:'status', value: item.status},
				{label:'category', value: item.category}
			],
			click: () => this.open(item),
		}
	}
}
