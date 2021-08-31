<script lang="ts">
	import Page from "../page";
	import type {Writable} from "svelte/store";

	export let pages: Array<Page>;
	export let active: Page;
	let loading: Writable<boolean>;
</script>

{#each $pages as page (page.id)}
	<div class:is-hidden={ page.id !== $active?.id}>
		<svelte:component this={page.component} page={page}/>
	</div>
{/each}
