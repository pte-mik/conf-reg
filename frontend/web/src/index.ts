import App from './components/app.svelte';

window.addEventListener('load', ()=>{
	const app = new App({target: document.body});
});
