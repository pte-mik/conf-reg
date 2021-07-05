import {user} from "../stores";
import User from "../entities/user";
import type Submission from "../entities/submission";

function post(url: string, data: any) {
	return fetch(url, {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data)})
}

class Api {
	public whoAmI() { return fetch('/api/auth').then(res => res.json()).then(data => user.update(() => data));}
	public signUp(name: string, email: string, password: string) { return post('/api/auth/sign-up', {name, email, password});}
	public signIn(email: string, password: string) { return post('/api/auth/sign-in', {email, password});}
	public signOut() { return fetch('/api/auth/sign-out').then(res => this.whoAmI())}
	public forgotPassword(email: string) { return post('/api/auth/forgot-password', {email});}
	public newAbstract(title: string, category: string) { return post('/api/submission/create', {title, category});}
	public getAbstracts() { return fetch('/api/submission/get').then(res => res.json())}
	public getAbstract(id: number) { return fetch('/api/submission/get/' + id)}
	public saveAbstract(abstract: Submission) { return post('/api/submission/', abstract)}
}

let api: Api = new Api();
export default api;