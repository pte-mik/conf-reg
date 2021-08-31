import handleFetch from "./handle-fetch";
import type {IAuthApi} from "./interfaces";
import user from "./user";

export default class AuthApi implements IAuthApi {

	constructor(private apibase: string = "/gold/auth") {}

	get(): Promise<any> {
		return fetch(this.apibase + '/get', {method: "POST"}).then(handleFetch).then(res => user.set(res));
	}

	login(login: string, password: string): Promise<any> {
		return fetch(this.apibase + '/login', {method: "POST", body: JSON.stringify({login, password})}).then(handleFetch).then(res => this.get());
	}

	logout(): Promise<any> {
		return fetch(this.apibase + '/logout', {method: "POST"}).then(handleFetch).then(res => this.get());
	}

}