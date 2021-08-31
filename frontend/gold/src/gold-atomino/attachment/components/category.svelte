<svelte:options accessors/>
<script lang="ts">
	import options from "../../options";
	import File from "./file.svelte";
	//	import FormDoc from "../form/doc.ts";
	import type {Writable} from "svelte/store";
	import {get, writable} from "svelte/store";
	//	import File from "frontend/gold/src/gold-atomino/attachment/attachment/attachment-file.svelte";

	export let files;
	export let collection;


	console.log(files, collection)

	export let name: string = '';
	export let label: string = '';
	//	export let doc: FormDoc = null;
	export let reload: Function = null;
	let input;


	function upload() {
		// let jobs = [];
		// [...input.files].forEach((file) => {
		// 	//jobs.push(doc.class.fetcher.attachment.upload(name, file, doc.id));
		// });
		// Promise.all(jobs)
		// 	.then(result => get())
		// 	.then(() => input.value = '')
	}
	//
	//
	// export let get = () => {
	// 	//doc.class.fetcher.attachment.get(doc.id, name).then(res => $files = res ?? [])
	// }
	// get();

	 let over = false;
	//
	function dragover(event) {
		if (event.dataTransfer.types[0] === 'attachment') {
			if (event.dataTransfer.types[1] !== name) {
				over = true;
			}
		}
	}

	function drop(event) {
		if (over) {
			//doc.class.fetcher.attachment.add(doc.id, name, event.dataTransfer.getData('file'), event.shiftKey ? null : event.dataTransfer.getData('collection')).then(reload);
		}
		over = false;
	}

</script>
<div class="card p3 mb-2" on:dragover={dragover} class:over on:drop={drop} on:dragleave={()=>over = false} on:dragover|preventDefault={()=>{}}>
	<header class="card-header">
		<p class="card-header-title has-text-weight-normal">
			<b>{label}</b><span class="pl-1 is-size-7">({name})</span>
		</p>
		<input bind:this={input} multiple type="file" style="display: none" on:change={upload}>
		<button class="card-header-icon" on:click={()=>input.click()}>
			{@html options.attachment.modal.upload.icon.Icon}
		</button>
	</header>
	<div class="card-content p-3">
		<div class="content">
			{#each collection as file (file)}
				<File file={files[file]}/>
			{/each}
		</div>
	</div>
</div>

