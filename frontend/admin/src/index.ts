// @ts-ignore
import App from "magic/src/components/app.svelte";
// @ts-ignore
import {settings} from "magic/src/modules/store";
import menu from "./config/menu";
import {userList} from "./config/user";

// @ts-ignore
window.addEventListener('load', ()=>{
	settings.update((settings:any)=>({
		...settings,
		menu: menu,
		lists: [userList]
	}));
	// @ts-ignore
	const app = new App({target: document.body});
});
