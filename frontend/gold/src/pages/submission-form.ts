
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
import AuthorInput from "src/components/author";
import ListInput from "src/components/list";
import EventForm from "src/pages/event-form";
import SubmissionList from "src/pages/submission-list";
import UserForm from "src/pages/user-form";
import UserList from "./user-list";

@form(
	FaIcon.s("scroll"),
	new ItemApi("/gold/submission"),
	() => SubmissionList
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
@button(attachmentButton(new AttachmentApi('/gold/submission'), {"image":"Kép"}))
export default class SubmissionForm extends Form {

	setTitle(item: any) { this.title = this.id === null ? "new" : item.title;}

	build() {
		this.addSection()
			.setRole("edit")
			.addControl(new ComboboxInput("userId", "user").Api('/gold/user').Form(UserForm))
			.addControl(new ComboboxInput("eventId", "event").Api('/gold/event').Form(EventForm))
			.addControl(new SelectInput("status").Options([{label:'draft',value:'draft'},{label:'underReview',value:'underReview'},{label:'declined',value:'declined'},{label:'accepted',value:'accepted'}]))
			.addControl(new StringInput("title"))
			.addControl(new StringInput("category"))
			.addControl(new StringInput("imageCaption"))
			.addControl(new ListInput("keywords"))
			.addControl(new AuthorInput("authors"))
			.addControl(new TextInput("text"))
	}

}
