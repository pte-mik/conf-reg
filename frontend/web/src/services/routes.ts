import SubmissionList from "src/components/routes/submission-list.svelte";
import SubmissionEdit from "src/components/routes/submission-edit.svelte";
import SubmissionPreview from "src/components/presentation/submission-preview.svelte";
import SubmissionNew from "src/components/routes/submission-new.svelte";
import SignIn from "src/components/routes/sign-in.svelte";
import SignUp from "src/components/routes/sign-up.svelte";
import ForgotPassword from "src/components/routes/forgot-password.svelte";
import Root from "src/components/routes/root.svelte";

let routes = {
	authenticated: {
		'/submission/list': SubmissionList,
		'/submission/new': SubmissionNew,
		'/submission/:id/preview': SubmissionPreview,
		'/submission/:id/edit': SubmissionEdit,
		'*': Root,
	},
	unatuhenticated: {
		'/sign-in': SignIn,
		'/sign-up': SignUp,
		'/forgot-password': ForgotPassword,
		'*': Root
	}
}


export default routes;



