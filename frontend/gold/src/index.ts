// @ts-ignore
import "./options";
import FormPage from "gold-entity/lib/form/form-page";
import AuthApi from "gold/lib/auth-api";
import App from "gold/components/app.svelte";
import FaIcon from "gold/lib/fa-icon";
import ListManager from "gold/lib/list-manager";
import MenuItem from "gold/lib/menu-item";
import PageManager from "gold/lib/page-manager";
import EventList from "src/pages/event-list";
import SubmissionList from "src/pages/submission-list";
import UserForm from "./pages/user-form";
import UserList from "./pages/user-list";
import DashboardPage from "./pages/dashboard-page";


let pageManager = new PageManager();
let listManager = new ListManager();
let authApi = new AuthApi();

pageManager.add(new DashboardPage());
listManager.add(new UserList());

let menu = [
//	new MenuItem("Dashboard", FaIcon.s("dice-d6"), () => {pageManager.add(new DashboardPage())}),
	new MenuItem("Users", FaIcon.s("users"), () => {listManager.add(new UserList())}),
	new MenuItem("Events", FaIcon.s("calendar-alt"), () => {listManager.add(new EventList())}),
	new MenuItem("Submissions", FaIcon.s("scroll"), () => {listManager.add(new SubmissionList())}),

]

window.addEventListener('load', () => new App({target: document.body, props: {pageManager, listManager, menu, authApi}}));
