<script lang="ts">
	import MenuItem from "../menu-item";
	import ListManager from "../list-manager";
	import PageManager from "../page-manager";
	import {get} from "svelte/store";
	import Frame from "./frame.svelte";
	import goldOptions from "../options";

	export let pageManager: PageManager;
	export let listManager: ListManager;
	export let menu: Array<MenuItem>;

	pageManager.listManager = listManager;
	listManager.pageManager = pageManager;

	let options = get(goldOptions);

	window.document.title = options.title;
	document.body.style.backgroundColor = options.backgroundColor;
	document.body.style.backgroundImage = 'url("' + options.backgroundImageUrl + '")';

</script>

<Frame pageManager={pageManager} listManager={listManager} menu={menu}/>


<style lang="scss" global>
	@import "@creativebulma/bulma-divider/dist/bulma-divider.css";
	@import "@fortawesome/fontawesome-pro/scss/variables";
	$fa-font-path: "/~fonts/fontawesome-pro";
	@import "@fortawesome/fontawesome-pro/scss/brands";
	@import "@fortawesome/fontawesome-pro/scss/regular";
	@import "@fortawesome/fontawesome-pro/scss/solid";
	@import "@fortawesome/fontawesome-pro/scss/light";
	@import "@fortawesome/fontawesome-pro/scss/duotone";
	@import "@fortawesome/fontawesome-pro/scss/fontawesome";
	//@import "bulma/css/bulma.min.css";
	//@import "bulmaswatch/superhero/variables";
	@import "bulma/bulma";
	@import "bulma-prefers-dark/bulma-prefers-dark.sass";
	//@import "bulmaswatch/superhero/overrides";
	@import "font-awesome-animation/css/font-awesome-animation.css";

	* {
		font-smoothing: antialiased;
	}

	body {
		background-image: url();
		background-size: cover;
		background-attachment: fixed;
	}
	html {
		height: 100%
	}
	html, body {
		min-height: 100%;
	}
	.border-0{border:0!important;}
	.sticky-grid { height: calc(100vh - 72px);
		> .box {
			background-color: #0006; display: grid; height: 100%;
			grid-template-rows: auto 1fr;
			> .header {
				border-bottom-right-radius: 0;
				border-bottom-left-radius: 0;
				z-index: 2;
			}
			> .content {
				overflow: auto;
				z-index: 1;
				backdrop-filter: blur(3px);
			}
		}
	}
	article.notification {
		padding: 8px 30px 8px 8px;
		font-size: 12px;

		font-weight: bold;
	}
</style>