<script lang="ts">
	import type {IAttachmentApi} from "../../interfaces";
	import type Form from "gold-entity/form/form";
	import Modal from "gold/components/modal.svelte"
	import {get, writable} from "svelte/store";
	import Collection from "./collection.svelte"

	export let modal;
	export let api: IAttachmentApi;
	export let visibleCollections: {};
	export let id: number;

	let files = writable({});
	let collections = writable({});
	let fetch;

	function load() {
		fetch = api.get(id).then(res => {
			$files = res.files;
			$collections = res.collections;
			console.log($collections)
		})
	}

	function saveFileDetails(filename: string, data: any) { return api.saveFileDetails(id, filename, data).then(load); }
	function removeFile(collection: string, filename: string) { return api.removeFile(id, collection, filename).then(load); }
	function upload(collection: string, files: FileList) {return api.upload(id, collection, files).then(load);}
	function moveFile(filename: string, source: string, target: string, position: number, copy: boolean) {return api.moveFile(id, filename, source, target, position, copy).then(load)}

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
				{#each Object.entries(visibleCollections) as [name, label]}
					<Collection label={label} name={name} files={$files} collection={$collections[name]} saveFileDetails={saveFileDetails} removeFile={removeFile} upload={upload} moveFile={moveFile}/>
				{/each}
			{/await}
		</section>
	</div>
</Modal>
