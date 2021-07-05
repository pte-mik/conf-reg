import {user} from "../stores";
import User from "../entities/user";

function post(url: string, data: any) {
	return fetch(url, {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data)})
}

class Api {
	public whoAmI() { return fetch('/api/auth').then(res => res.json()).then(data => user.update(() => data ? User.create(data) : null));}
	public signUp(name: string, email: string, password: string) { return post('/api/auth/sign-up', {name, email, password});}
	public signIn(email: string, password: string) { return post('/api/auth/sign-in', {email, password});}
	public signOut() { return fetch('/api/auth/sign-out').then(res => this.whoAmI())}
	public forgotPassword(email: string) { return post('/api/auth/forgot-password', {email});}
}

let api: Api = new Api();
export default api;