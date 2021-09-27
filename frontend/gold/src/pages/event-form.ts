
import AttachmentApi from "gold-attachment/lib/attachment-api";
import attachmentButton from "gold-attachment/lib/form-button";
import ItemApi from "gold-entity/lib/form/api";
import CheckboxesInput from "gold-entity/lib/form/input/checkboxes";
import ComboboxInput from "gold-entity/lib/form/input/combobox";
import DateInput from "gold-entity/lib/form/input/date";
import DateTimeInput from "gold-entity/lib/form/input/datetime";
import PasswordInput from "gold-entity/lib/form/input/password";
import RadioInput from "gold-entity/lib/form/input/radio";
import SelectInput from "gold-entity/lib/form/input/select";
import StringInput from "gold-entity/lib/form/input/string";
import SwitchInput from "gold-entity/lib/form/input/switch";
import TextInput from "gold-entity/lib/form/input/text";
import Form, {button, buttons, form} from "gold-entity/lib/form/form";
import FaIcon from "gold/lib/fa-icon";
import ListInput from "src/components/list";
import EventList from "src/pages/event-list";
import UserList from "./user-list";

@form(
	FaIcon.s("calendar-alt"),
	new ItemApi("/gold/event"),
	() => EventList
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
@button(FaIcon.s('file-download'), (form:Form)=>{
	window.open('/gold/event/download/' + form.id);
})
export default class EventForm extends Form {

	setTitle(item: any) { this.title = this.id === null ? "new" : item.title;}

	build() {
		this.addSection()
			.setRole("edit")
			.addControl(new StringInput("title"))
			.addControl(new StringInput("website"))
			.addControl(new StringInput("url"))
			.addControl(new ListInput("categories"))
			.addControl(new DateTimeInput("deadline"))
			.addControl(new DateTimeInput("regOpening"))
			.addControl(new ComboboxInput("organizerId", "organizer").Api('/gold/user'))
			.addControl(new TextInput("abstractTemplate", "template").Code())
	}

}
