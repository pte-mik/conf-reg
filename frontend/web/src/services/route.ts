import {push} from "svelte-spa-router";

let route = {
	root: () => push('/'),
	profile: () => push('/profile'),
	submission: {
		list: () => push(`/submission/list`),
		new: () => push(`/submission/new`),
		edit: (id: number) => push(`/submission/${id}/edit`),
		preview: (id: number) => push(`/submission/${id}/preview`),
	},
	auth: {
		signIn: () => push('/sign-in'),
		signUp: () => push('/sign-up'),
		forgotPassword: () => push('/forgot-password'),
	}
}

export default route;