import Abstracts from "./components/abstracts.svelte"
import Abstract from "./components/abstract.svelte"
import AbstractNew from "./components/abstract-new.svelte"
import SignIn from "./components/sign-in.svelte";
import SignUp from "./components/sign-up.svelte";
import ForgotPassword from "./components/forgot-password.svelte";

const routes = {
	admin: {

	},
	app: {
		'/abstract/new': AbstractNew,
		'/abstract/:id': Abstract,
		'/': Abstracts,
		'/*': Abstracts,
	},
	auth: {
		'/sign-in': SignIn,
		'/sign-up': SignUp,
		'/forgot-password': ForgotPassword,
		'/': SignIn,
		'/*': SignIn
	}
}

routes.admin = Object.assign(routes.admin, routes.app);

export default routes;