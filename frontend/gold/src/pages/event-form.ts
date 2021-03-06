import ListControl from "src/components/list-input/control";
import FaIcon from "gold-admin/fa-icon";
import controls from "gold-admin/form-input/controls";
import Form, {button, buttons, form} from "gold-admin/form/form";
import FormApi from "gold-admin/form/form-api";
import EventList from "src/pages/event-list";
import XLSX from "xlsx";
@form(
	FaIcon.s("calendar-alt"),
	new FormApi("/gold/event"),
	() => EventList
)
@button(buttons.save)
@button(buttons.delete)
@button(buttons.reload)
@button(FaIcon.s('file-download'), (form: Form) => {
	window.open('/gold/event/download/' + form.id);
})
@button(FaIcon.s('id-card'), (form: Form) => {

	fetch('/gold/event/users/'+form.id)
		.then(res=>res.json())
		.then((rows:Array<{name:string, email:string}>)=>{
			let data:Array<any> = [];

			rows.forEach(row => {
				let rowData = [row.name, row.email];
				data.push(rowData);
			});

			let book = XLSX.utils.book_new();
			let sheet = XLSX.utils.aoa_to_sheet(data);
			XLSX.utils.book_append_sheet(book, sheet, 'export');
			XLSX.writeFile(book, 'users.xlsx');
		})
})
export default class EventForm extends Form {

	setTitle(item: any) { this.title = this.id === null ? "new" : item.title;}

	build() {
		this.addSection()
			.setRole("edit")
			.addControl(new controls.string("title"))
			.addControl(new controls.string("website"))
			.addControl(new controls.string("url"))
			.addControl(new ListControl("categories"))
			.addControl(new controls.datetime("deadline"))
			.addControl(new controls.datetime("regOpening"))
			.addControl(new controls.combobox("organizerId", "organizer").Api('/gold/user'))
			.addControl(new controls.text("abstractTemplate", "template").Code())
	}

}
