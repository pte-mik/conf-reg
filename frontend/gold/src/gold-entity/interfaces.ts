import type FaIcon from "gold/fa-icon";


export interface IOptions {
	list: {
		filter: { icon: FaIcon; }
		sort: { icon: FaIcon }
		info: { icon: FaIcon }
		new: { icon: FaIcon }
		pager: {
			right: { icon: FaIcon }
			left: { icon: FaIcon }
		}
	}
	form: {
		loading: {icon: FaIcon}
		button: {
			save: { icon: FaIcon }
			reload: { icon: FaIcon }
			delete: { icon: FaIcon }
			attachments: { icon: FaIcon }
		}
	}

	input: {
		combobox: {
			search: { icon: FaIcon }
			add: { icon: FaIcon }
			link: { icon: FaIcon }
			remove: { icon: FaIcon }
		}
		number: {
			up: { icon: FaIcon }
			down: { icon: FaIcon }
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
	get(pagesize: number, page: number, view: string | null, sorting: string | null, quicksearch: string, filter:any): Promise<any>;
}

export interface IFormApi {
	get(id: number): Promise<any>;
	blank(): Promise<any>;
	create(item: Object): Promise<false | null | number>;
	update(item: Object): Promise<false | null | number>;
	delete(id: number): Promise<boolean>;
}
