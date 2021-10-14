import FaIcon from "gold-admin/fa-icon";
import AuthorControl from "src/components/author-input/control";
import ListControl from "src/components/list-input/control";
import AttachmentApi from "gold-admin/form-attachment/attachment-api";
import attachmentButton from "gold-admin/form-attachment/form-button";
import controls from "gold-admin/form-input/controls";
import Form, {button, buttons, form} from "gold-admin/form/form";
import FormApi from "gold-admin/form/form-api";
import EventForm from "src/pages/event-form";
import SubmissionList from "src/pages/submission-list";
import UserForm from "src/pages/user-form";

@form(
	FaIcon.s("scroll"),
	new FormApi("/gold/submission"),
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
			.addControl(new controls.combobox("userId", "user").Api('/gold/user').Form(UserForm))
			.addControl(new controls.combobox("eventId", "event").Api('/gold/event').Form(EventForm))
			.addControl(new controls.select("status").Options([{label:'draft',value:'draft'},{label:'underReview',value:'underReview'},{label:'declined',value:'declined'},{label:'accepted',value:'accepted'}]))
			.addControl(new controls.string("title"))
			.addControl(new controls.string("category"))
			.addControl(new controls.string("imageCaption"))
			.addControl(new ListControl("keywords"))
			.addControl(new AuthorControl("authors"))
			.addControl(new controls.text("text"))
	}

}
