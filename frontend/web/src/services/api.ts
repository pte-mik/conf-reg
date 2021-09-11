import handleFetch from "src/services/handle-fetch";
import {user} from "src/services/stores";
import User from "../entities/user";
import type Submission from "../entities/submission";

function post(url: string, data: any) {
	return fetch(url, {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data)})
}

class Api {
	public whoAmI() { return fetch('/api/auth').then(res => res.json()).then(data => user.update(() => data));}
	public signUp(name: string, email: string, password: string, phone: string) { return post('/api/auth/sign-up', {name, email, password, phone});}
	public signIn(email: string, password: string) { return post('/api/auth/sign-in', {email, password});}
	public signOut() { return fetch('/api/auth/sign-out').then(res => this.whoAmI())}
	public forgotPassword(email: string) { return post('/api/auth/forgot-password', {email});}

	public submission = {
		collect: () => fetch('/api/submission/get').then(res => res.json()),
		get: (id: number) => fetch('/api/submission/get/' + id),
		save: (submission: Submission) => post('/api/submission', submission),
		submit: (submission: Submission) => post('/api/submission/submit', submission),
		delete: (submission: Submission) => post('/api/submission/delete', submission),
		create: (title: string, category: string) => post('/api/submission/create', {title, category}),
		image: {
			add: (id: number, file: File) => {
				let data = new FormData()
				data.append('file', file)
				return fetch('/api/submission/' + id + '/image/add', {
					method: 'POST',
					body: data
				}).then(handleFetch);
			},
			remove: (id: number) => {
				return post('/api/submission/' + id + '/image/delete', null);
			}
		}
	}
}


let api: Api = new Api();

api.whoAmI();

export default api;
