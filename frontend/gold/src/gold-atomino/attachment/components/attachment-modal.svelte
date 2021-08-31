<script lang="ts">
	import type {IAttachmentApi} from "../../interfaces";
	import type Form from "gold-entity/form/form";
	import Modal from "gold/components/modal.svelte"
	import {get, writable} from "svelte/store";
	import Category from "./category.svelte"

	export let modal;
	export let api: IAttachmentApi;
	export let categories: {};
	export let form: Form;

	let files=writable({});
	let collections=writable({});
	let fetch;

	function load(){
		fetch = api.get(get(form.$item).id).then(res =>{
			$files = res.files;
			$collections = res.collections;
			console.log($collections)
		})
	}
	load();
</script>


<Modal full={true}>
	<div class="modal-card">
		<header class="modal-card-head p-3 px-4">
			<p class="modal-card-title is-size-6 has-text-weight-bold">Attachments</p>
			<button class="delete" aria-label="close" on:click={()=>modal.close()}></button>
		</header>
		<section class="modal-card-body has-background-black-bis m-0 p-2">
			{#await fetch}{:then r}
				{#each Object.entries(categories) as [name, label]}
					<Category label={label} name={name} files={$files} collection={$collections[name]}/>
				{/each}
			{/await}
		</section>
	</div>
</Modal>
