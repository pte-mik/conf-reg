<script lang="ts">
	import {get} from "svelte/store";
	import type {Writable} from "svelte/store";
	import ListManager from "../list-manager";

	export let listManager: ListManager;

	let active = listManager.$active;
	let lists = listManager.$lists;
</script>

{#if $active !== null}
	{#each $lists as list (list.id)}
		<div class="column is-one-third-desktop is-one-quarter-fullhd is-half-tablet p-0 m-1 sticky-grid" class:is-hidden={list.id !== $active.id}>
			<div class="box m-0 p-0">
				<svelte:component this={list.component} list={list}/>
			</div>
		</div>
	{/each}
{/if}