<script lang="ts">
	import cbytes from "cbytes";
	import Details from "frontend/gold/src/gold-atomino/attachment/attachment/attachment-details.svelte";
	import modalManager from "../../../elements/modal-manager.ts";
	import {getClassNameForExtension} from "font-awesome-filetypes";
	import FormDoc from "../form/doc.ts";


	export let file: Object = {};
	export let doc: FormDoc = null;
	export let index: number = null;
	export let reload: Function = null;
	export let collection: string = null;

	let left = false;
	let right = false;

	function details() { modalManager.show(Details, {file, doc, reload, collection});}

	$: icon = "far " + getClassNameForExtension(file.name.split('.').pop())

	function dragover(event) {
		if (event.dataTransfer.types[0] === 'attachment' && collection === event.dataTransfer.types[1]) {
			if ((event.target.clientWidth / 2) < event.offsetX) {
				right = true;
				left = false;
			} else {
				left = true;
				right = false;
			}
			event.stopPropagation();
			event.preventDefault();
		}
	}

	function dragleave(event) {
		left = false;
		right = false;
	}

	function dragstart(event) {
		event.dataTransfer.setData('attachment', '1');
		event.dataTransfer.setData(collection, '1');
		event.dataTransfer.setData('file', file.name);
		event.dataTransfer.setData('collection', collection);
	}

	function drop(event) {
		if (event.dataTransfer.types[0] === 'attachment' && collection === event.dataTransfer.types[1]) {
			doc.class.fetcher.attachment.order(doc.id, collection, event.dataTransfer.getData('file'), index + (right ? 1 : 0)).then(reload)
			left = false;
			right = false;
		}
	}

</script>

<section class="file" class:right class:left on:click={details} on:dragleave={dragleave} draggable="true" on:drop={drop} on:dragstart={dragstart} on:dragover={dragover}>
	<div class="preview">
		{#if (file.isImage)}
			<img alt="" src="{file.thumbnail}" width="100" height="100" draggable="false">
			<div class="dimensions">{file.width}x{file.height}</div>
		{:else }
			<i class={icon}></i>
		{/if}
	</div>
	<span class="name">
	{file.name}
	</span>
	<span class="data">
		{cbytes(file.size, {separator: '', decimals: 0})}
	</span>
</section>

<style lang="scss">
	@import "../../../style/mixins";

	section.file {
		float: left;
		margin: 5px;
		padding: 5px;
		border: 1px solid #ddd;
		background-color: #f9f9f9;
		box-shadow: 0 13px 10px -10px rgb(0 0 0 / 30%);
		position: relative;

		&:before, &:after {
			content: '';
			height: 100%;
			width: 4px;
			position: absolute;
			top: 0;
			display: none;
			background-color: $highlight-color;
		}
		&:before { left: -8px;}
		&:after {right: -8px }
		&.left:before, &.right:after {display: block; }

		span.name {
			display: block;
			font-size: 10px;
			font-weight: bold;
			text-align: center;
			width: 100px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		span.data {
			text-align: center;
			display: block;
			font-size: 9px;
		}
		div.preview {
			width: 100px;
			height: 100px;
			text-align: center;
			position: relative;
			div.dimensions {
				position: absolute;
				bottom: 0;
				left: 0;
				width: 100px;
				background-color: #0008;
				color: white;
				font-size: 11px;
				font-weight: bold;
				line-height: 20px;
				opacity: 0;
				backdrop-filter: blur(4px);
				transition: all .3s;
			}
			&:hover div.dimensions {
				opacity: 1;
			}

			i {
				line-height: 100px;
				font-size: 64px;
			}
		}
	}
</style>