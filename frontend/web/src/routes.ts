import Submissions from "./components/submissions.svelte"
import Submission from "./components/submission.svelte"
import SubmissionNew from "./components/submission-new.svelte"
import SignIn from "./components/sign-in.svelte";
import SignUp from "./components/sign-up.svelte";
import ForgotPassword from "./components/forgot-password.svelte";

const routes = {
	admin: {

	},
	app: {
		'/abstract/new': SubmissionNew,
		'/abstract/:id': Submission,
		'/': Submissions,
		'/*': Submissions,
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