<script lang="ts">
	import MenuItem from "../menu-item";
	import type ListManager from "../list-manager";
	import type PageManager from "../page-manager";
	import Header from "./header.svelte";
	import ListContainer from "./list-container.svelte";
	import Tabs from "./tabs.svelte";
	import Pages from "./pages.svelte"

	export let pageManager:PageManager;
	export let listManager:ListManager;
	export let menu: Array<MenuItem>;

</script>

<Header menu={menu}/>

<div class="columns m-1">
	<ListContainer listManager={listManager}/>

	<div class="column p-0 m-1 sticky-grid">
		<div class="box p-0">
			<div class="header box p-0 mb-0 is-clipped">
				<Tabs pages={pageManager.$pages} active={pageManager.$active} onSelect={(page)=>pageManager.add(page)} onClose={(page)=>pageManager.remove(page)}/>
			</div>
			<div class="content p-1">
				<Pages pages={pageManager.$pages} active={pageManager.$active}/>
			</div>
		</div>
	</div>
</div>

