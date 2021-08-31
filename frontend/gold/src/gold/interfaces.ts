import type FaIcon from "gold/fa-icon";
import type {Writable} from "svelte/store";

export interface IAuthApi{
	login(login:string, password:string):Promise<any>;
	logout():Promise<any>;
	get():Promise<any>;
}

export interface IOptions {
	logout: { icon: FaIcon }
	title: string
	background: {
		color: string
		imageUrl: string
	}
	logo: {
		imageUrl: string
	}
	tab: {
		close: { icon: FaIcon }
		changed: { icon: FaIcon }
		loading: { icon: FaIcon }
	},
	login:{
		title:string,
		input:{
			login:{
				icon: FaIcon,
				placeholder: string,
			},
			password:{
				icon: FaIcon,
				placeholder: string,
			},
		},
		button:{
			login:{
				text: string
			}
		}
	}
}

export interface IUser {
	name: string
	roles: Array<string>
}