import "./options";
import App from "gold-admin/app.svelte"
import ListManager from "gold-admin/app/list-manager";
import MenuItem from "gold-admin/app/menu-item";
import PageManager from "gold-admin/app/page-manager";
import AuthApi from "gold-admin/auth/auth-api";
import FaIcon from "gold-admin/fa-icon";
import EventList from "src/pages/event-list";
import SubmissionList from "src/pages/submission-list";
import UserList from "./pages/user-list";

let pageManager = new PageManager();
let listManager = new ListManager();

let authApi = new AuthApi('/gold/auth', () => {
	listManager.add(new UserList());
});

let menu = [
	new MenuItem("Users", FaIcon.s("users"), () => {listManager.add(new UserList())}),
	new MenuItem("Events", FaIcon.s("calendar-alt"), () => {listManager.add(new EventList())}),
	new MenuItem("Submissions", FaIcon.s("scroll"), () => {listManager.add(new SubmissionList())}),
]


window.addEventListener('load', () => new App({target: document.body, props: {pageManager, listManager, menu, authApi}}));
