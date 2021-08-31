<svelte:options accessors/>
<script lang="ts">
	import options from "../../options";
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
			{#each Array(100) as a,i}
				<div class="card is-inline-block m-1 is-unselectable has-background-grey">
					<div class="card-image">
						{#if i < 50}
							<figure class="image m-0 is-4by3">
								<img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
							</figure>
						{:else }
							<div class="py-5 has-text-centered">
								<i class="fas fa-file-powerpoint is-size-1"></i>
							</div>
						{/if}
					</div>
					<header class="card-header has-background-white-ter">
						<p class="card-header-title px-2 py-1 has-text-weight-normal is-size-7 has-text-black-bis ">filename</p>
					</header>
				</div>
			{/each}
		</div>
	</div>
</div>

<style lang="scss">
	.card-image {
		width: 120px;
		height: 90px;
	}
</style>