import Api from "gold-entity/lib/list/api";
import List, {button, list, buttons} from "gold-entity/lib/list/list";
import FaIcon from "gold/lib/fa-icon";
import EventForm from "src/pages/event-form";
import UserForm from "./user-form";

@list(
	"Events",
	FaIcon.s("calendar-alt"),
	new Api("/gold/event"),
	() => EventForm
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
