<script lang="ts">
	import cbytes from "cbytes";
	import {getClassNameForExtension} from "font-awesome-filetypes";
	import {Modal} from "gold/modal-manager";
	import Details from "./details-modal.svelte"

	export let file;

	$: icon = "far " + getClassNameForExtension(file.name.split('.').pop())

	function details(){
		console.log(file);
		let modal = new Modal(Details, {file});
		modal.open();
	}
</script>

<div title="{file.name}" on:click={details} class="card is-inline-block m-1 is-unselectable has-background-grey" draggable="true">
	<div class="card-image">
		{#if file.isImage}
			<figure class="image m-0 is-4by3" draggable="false">
				<img src={file.thumbnail} alt="Placeholder image" draggable="false">
			</figure>
		{:else }
			<div class="py-5 has-text-centered">
				<i class="fas {icon} is-size-1"></i>
			</div>
		{/if}
	</div>
	<header class="card-header has-background-white-ter is-flex-direction-column">
		<div class="card-header-title px-2 pt-1 has-text-weight-normal has-text-black-bis has-text-centered pb-0">{file.name}</div>
		<div class="card-header-title subtitle px-2 pt-0 pb-1 has-text-weight-normal has-text-grey has-text-centered">
			{#if file.isImage}
				{file.width} x {file.height}
			{:else }
				{cbytes(file.size, {separator: '', decimals: 0})}
			{/if}
		</div>
	</header>
</div>

<style lang="scss">
	.card-image {
		width: 120px;
		height: 90px;
	}
	.card-header-title {
		display: block;
		font-size: 11px;
		width: 120px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		&.subtitle {
			font-size: 10px;
		}
	}
</style>