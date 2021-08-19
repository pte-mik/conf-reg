<script lang="ts">
	import Form from "../form";
	import Modal from "gold/components/modal.svelte"
	import {SvelteComponent} from "svelte";

	export let title: string = "Please confirm!";

	export let ok: string = "OK";
	export let cancel: string = "Cancle";
	export let okStyle: string = "is-success";
	export let cancelStyle: string = "is-white";
	export let okAction: Function | null = null;
	export let cancelAction: Function | null = null;

	export let buttons: Array<{ style: string, label: string, action: Function }> = [];

	export let content: string | typeof SvelteComponent = "question";
	export let props;
	export let full = false;
	export let close = false;

	if (cancelAction === null) cancelAction = () => form.closeModal();
	if (okAction === null) okAction = () => form.closeModal();

	export let form: Form;
</script>


<Modal full={full} title={title}>
	<div class="modal-card">
		<header class="modal-card-head p-3 px-4">
			<p class="modal-card-title is-size-6 has-text-weight-bold">{title}</p>
			{#if close}
				<button class="delete" aria-label="close" on:click={()=>form.closeModal()}></button>
			{/if}
		</header>
		<section class="modal-card-body has-background-black-bis">
			{#if typeof content === "string"}
				{content}
			{:else }
				<svelte:component this={content} {...props} form={form}/>
			{/if}
		</section>
		<footer class="modal-card-foot is-justify-content-center p-2">
			{#each buttons as button}
				<button class="button {button.style}" on:click={()=>button.action()}>{button.label}</button>
			{/each}
		</footer>
	</div>
</Modal>
