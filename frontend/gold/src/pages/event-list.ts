import List, {button, list, buttons} from "gold-admin/list/list";
import FaIcon from "gold-admin/fa-icon";
import ListApi from "gold-admin/list/list-api";
import EventForm from "src/pages/event-form";

@list(
	"Events",
	FaIcon.s("calendar-alt"),
	new ListApi("/gold/event"),
	() => EventForm,
	true
)
@button(buttons.new)
export default class EventList extends List {
	cardifyItem(item: any) {
		return {
			id: item.id,
			title: item.title,
			active: true,
			subtitle: item.website,
			click: () => this.open(item),
		}
	}
}
