<script lang="ts">
	import Modal from "../../../elements/modal.svelte";
	import toastManager from "../../../elements/toast-manager.ts";
	import cbytes from "cbytes";
	import FormDoc from "../form/doc.ts";
	import ImageModal from "frontend/gold/src/gold-atomino/attachment/attachment/attachment-image.svelte";

	import {getClassNameForExtension} from "font-awesome-filetypes";
	import {beforeUpdate, onMount} from "svelte";
	import {writable} from "svelte/store";
	import modalManager from "../../../elements/modal-manager.ts";

	export let collection: string = null;
	export let close;
	export let doc: FormDoc;
	export let file: Object = {};
	export let reload: Function = null;
	let modal: Modal;

	let filename;
	let title;
	let properties = writable([]);

	$: icon = "inverse far " + getClassNameForExtension(file.name.split('.').pop());
	onMount(() => {
		$properties = ((typeof file.properties === "object") && !(file.properties instanceof Array)) ? [...Object.entries(file.properties)] : [];
		filename = file.name;
		title = file.title;
	});
	function removeProperty(index) {
		properties.update(
			(properties) => {
				properties.splice(index, 1);
				return properties;
			}
		);
	}

	function addProperty() {
		properties.update(properties => [...properties, ['', '']]);
	}

	function save() {
		properties.update(properties => properties.map(item => [item[0].trim(), item[1].trim()]))
		properties.update(properties => [...Object.entries(Object.fromEntries(properties))])

		let data = {
			newname: filename,
			title: title,
			properties: Object.fromEntries($properties)
		}

		doc.class.fetcher.attachment.modify(doc.id, file.name, data).then(close).then(reload)

	}

	function remove() {
		if (confirm('Remove file: ' + file.name + "\nAre you sure?")) doc.class.fetcher.attachment.remove(collection, doc.id, file.name).then(close).then(reload);
	}


</script>

<Modal bind:this={modal} icon={icon} title="File details">
	<nav slot="nav">
		{#if (file.isImage)}
			<button on:click={()=>{ modalManager.show(ImageModal, {file, doc, reload}); }}><i class="fas fa-image"></i></button>
		{/if}
		<button on:click={remove}><i class="fas fa-trash-alt"></i></button>
		<button on:click={close}><i class="fas fa-times"></i></button>
	</nav>
	<main>
		<div>
			<input placeholder="filename" type="text" bind:value={filename}>
		</div>
		<div>
			<input placeholder="title" type="text" bind:value={title}>
		</div>
		<div class="url" on:click={()=>{navigator.clipboard.writeText(file.url);toastManager.info("URL copied to clipboard")}}>url: {file.url}</div>
		<div>file size: {cbytes(file.size, {separator: '', decimals: 1})} ({file.size.toLocaleString()})</div>
		{#if (file.isImage)}
			<div>dimensions: {file.width} x {file.height}</div>
		{/if}
		<div class="properties">properties:<i class="fas fa-plus-circle" on:click={()=>addProperty()}></i></div>
		{#each $properties as [key, value], index}
			<div class="property">
				<input class="key" bind:value={key} placeholder="key">
				<input class="value" bind:value={value} placeholder="value">
				<i class="fas fa-minus-circle" on:click={()=>removeProperty(index)}></i>
			</div>
		{/each}
	</main>
	<footer slot="footer">
		<button class="primary" on:click={save}>Save changes</button>
	</footer>
</Modal>

<style lang="scss">
	@import "../../../style/mixins";
	main {
		display: flex;
		flex-direction: column;
		min-height: 100%;
		&:not(:last-child) { border-bottom: 1px solid #eee;}
		background-color: #ffffff;
		color: #666;
		text-align: left;
		& > div {
			&.url { cursor: pointer;}
			line-height: 30px;
			padding: 0 10px;
			height: 30px;
			border-bottom: 1px solid #eee;
			font-size: 11px;
			input {
				color: $highlight-color;
				border: 0;
				width: 100%;
				&::placeholder {
					color: $input--placeholder-color;
				}
			}
			&.properties {
				font-weight: bold;
				padding-right: 0;
				i {
					float: right;
					line-height: 30px;
					padding: 0 10px;
					color: limegreen;
					cursor: pointer;
					border-left: 1px solid #eee;
				}
			}
			&.property {
				display: flex;
				padding-right: 0;
				input {
					flex-grow: 1;
					font-size: 11px;
					&.value {
						flex-grow: 2;
						padding-left: 10px;
						border-left: 1px solid #eee;
					}
				}
				i {
					border-left: 1px solid #eee;
					line-height: 30px;
					padding: 0 10px;
					color: orangered;
					cursor: pointer;
				}
			}
		}
	}
</style>