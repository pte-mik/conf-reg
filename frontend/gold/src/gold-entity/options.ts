import type {IOptions} from "./interfaces";
import FaIcon from "gold/fa-icon";

let options: IOptions = {
	form: {
		loading: {icon: FaIcon.s("spinner-third").spin() },
		button: {
			attachments: {icon: FaIcon.s("folder-upload")},
			delete: {icon: FaIcon.s("trash-alt")},
			reload: {icon: FaIcon.s("sync-alt")},
			save: {icon: FaIcon.s("save")}
		}
	},
	list: {
		new:{icon: FaIcon.s("plus")},
		filter:{icon: FaIcon.s("filter")},
		info:{icon: FaIcon.s("info-circle")},
		sort:{icon: FaIcon.s("sort")},
		pager: {
			right:{icon: FaIcon.s("chevron-right")},
			left:{icon: FaIcon.s("chevron-left")},
		}
	},
	input: {
		number: {
			down:{icon: FaIcon.s("chevron-down")},
			up:{icon: FaIcon.s("chevron-up")},
		},
		combobox: {
			add:{icon: FaIcon.s("plus")},
			search:{icon: FaIcon.s("search")},
			remove:{icon: FaIcon.s("times")},
			link:{icon: FaIcon.s("arrow-right")},
		}
	}
};

export default options;
