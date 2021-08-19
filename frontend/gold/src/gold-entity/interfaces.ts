import type FaIcon from "gold/fa-icon";

export interface IOptions {
	// iconSave: FaIcon;
	// iconReload: FaIcon;
	// iconDelete: FaIcon;
	// iconAttachments: FaIcon;
	// iconLoading: FaIcon;
	// iconFilter: FaIcon;
	// iconSort: FaIcon;
	// iconRight: FaIcon;
	// iconLeft: FaIcon;
	// iconInfo: FaIcon;
	// iconNewItem: FaIcon;

	icon: {
		loading: FaIcon,
		list: {
			filter: FaIcon,
			sort: FaIcon,
			info: FaIcon,
			new: FaIcon,
			pager: {
				right: FaIcon,
				left: FaIcon
			}
		},
		form: {
			button: {
				save: FaIcon,
				reload: FaIcon,
				delete: FaIcon,
				attachments: FaIcon,
			}
		},
		input:{
			selector:{
				search: FaIcon,
				add: FaIcon
			},
			number:{
				up:FaIcon,
				down:FaIcon
			}
		}
	}
}

export interface IListOptions {
	quicksearch: boolean;
	views: Array<string> | false;
	sortings: Array<string> | false;
	pagesize: number;
}

export interface IListApi {
	getOptions(): Promise<any>;

	get(pagesize: number, page: number, view: string | null, sorting: string | null, quicksearch: string): Promise<any>;
}

export interface IFormApi {
	getOptions(): Promise<any>;

	get(id: number): Promise<any>;

	blank(): Promise<any>;

	create(item: Object): Promise<false | null | number>;

	update(item: Object): Promise<false | null | number>;

	delete(id: number): Promise<boolean>;
}