import "./options";
import App from "gold-admin/app.svelte"
import Page from "gold-admin/app/abstract-page";
import ListManager from "gold-admin/app/list-manager";
import MenuItem from "gold-admin/app/menu-item";
import PageManager from "gold-admin/app/page-manager";
import AuthApi from "gold-admin/auth/auth-api";
import FaIcon from "gold-admin/fa-icon";
import Form from "gold-admin/form/form";
import EventList from "src/pages/event-list";
import SubmissionForm from "src/pages/submission-form";
import SubmissionList from "src/pages/submission-list";
import UserList from "./pages/user-list";
import FormPage from "gold-admin/form/form-page"

let pageManager = new PageManager();
let listManager = new ListManager();

let authApi = new AuthApi('/gold/auth', () => {
	listManager.add(new UserList());
	pageManager.add(new FormPage(new SubmissionForm(14)))
});

let menu = [
	new MenuItem("Users", FaIcon.s("users"), () => {listManager.add(new UserList())}),
	new MenuItem("Events", FaIcon.s("calendar-alt"), () => {listManager.add(new EventList())}),
	new MenuItem("Submissions", FaIcon.s("scroll"), () => {listManager.add(new SubmissionList())}),
]


window.addEventListener('load', () => new App({target: document.body, props: {pageManager, listManager, menu, authApi}}));
