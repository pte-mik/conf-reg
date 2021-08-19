import type {IOptions} from "gold-entity/interfaces";
import FaIcon from "gold/fa-icon";
import {writable} from "svelte/store";
import type {Writable} from "svelte/store";

let options: Writable<IOptions> = writable({
	icon:{
		loading:FaIcon.s("spinner-third").spin(),
		form:{
			button:{
				attachments: FaIcon.s("folder-upload"),
				filter: FaIcon.s("filter"),
				delete: FaIcon.s("trash-alt"),
				reload: FaIcon.s("sync-alt"),
				save: FaIcon.s("save")
			}
		},
		list:{
			new: FaIcon.s("plus"),
			filter: FaIcon.s("filter"),
			info:FaIcon.s("info-circle"),
			sort:FaIcon.s("sort"),
			pager:{
				right: FaIcon.s("chevron-right"),
				left: FaIcon.s("chevron-left"),
			}
		},
		input:{
			number:{
				down: FaIcon.s("chevron-down"),
				up: FaIcon.s("chevron-up"),
			},
			selector:{
				add:FaIcon.s("plus"),
				search:FaIcon.s("filter"),
			}
		}
	}
});

export function setOptions(setter: (options: IOptions) => void) {
	options.update((options: IOptions) => {
		setter(options);
		return options;
	})
}
export default options;
