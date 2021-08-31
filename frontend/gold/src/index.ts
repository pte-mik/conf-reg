// @ts-ignore
import "./options";
import FormPage from "gold-entity/form/form-page";
import AuthApi from "gold/auth-api";
import App from "gold/components/app.svelte";
import FaIcon from "gold/fa-icon";
import ListManager from "gold/list-manager";
import MenuItem from "gold/menu-item";
import PageManager from "gold/page-manager";
import UserForm from "src/pages/user-form";
import UserList from "src/pages/user-list";
import DashboardPage from "src/pages/dashboard-page";


let pageManager = new PageManager();
let listManager = new ListManager();
let authApi = new AuthApi();

pageManager.add(new DashboardPage());
listManager.add(new UserList());
pageManager.add(new FormPage(new UserForm(1)))

let menu = [
	new MenuItem("Dashboard", FaIcon.s("dice-d6"), () => {pageManager.add(new DashboardPage())}),
	new MenuItem("User list", FaIcon.s("users"), () => {listManager.add(new UserList())}),
	new MenuItem("User", FaIcon.s("users"), [
		new MenuItem("New user", FaIcon.s("user-plus"), () => {pageManager.add(new FormPage(new UserForm()))}),
		new MenuItem("User 1", FaIcon.s("user"), () => {pageManager.add(new FormPage(new UserForm(1)))}),
		new MenuItem("User non exists", FaIcon.s("user"), () => {pageManager.add(new FormPage(new UserForm(100)))})
	], "editrrrt"),
]

window.addEventListener('load', () => new App({target: document.body, props: {pageManager, listManager, menu, authApi}}));

