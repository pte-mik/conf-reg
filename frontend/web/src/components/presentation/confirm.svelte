<script lang="ts">
	import {Modal} from "svelma"

	export let active: boolean = false;
	export let title: string = "Please confirm!";
	export let ok: string = "OK";
	export let cancel: string = "Cancel";
	export let okStyle: string = "is-success";
	export let cancelStyle: string = "is-white";
	import {createEventDispatcher} from 'svelte';

	const dispatch = createEventDispatcher();
</script>


<Modal bind:active={active} title={title}>
	<div class="modal-card">
		<header class="modal-card-head p-4">
			<p class="modal-card-title is-size-6 has-text-weight-bold">{title}</p>
			<button class="delete" aria-label="close" on:click={()=>active=false}></button>
		</header>
		<section class="modal-card-body">
			<slot/>
		</section>
		<footer class="modal-card-foot is-justify-content-center">
			<button class={"button "+cancelStyle} on:click={()=>active=false}>{cancel}</button>
			<button class={"button "+okStyle} on:click={()=>{dispatch('ok');active=false}}>{ok}</button>
		</footer>
	</div>
</Modal>
