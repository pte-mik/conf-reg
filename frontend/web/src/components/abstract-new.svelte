<script lang="ts">
	import {replace} from "svelte-spa-router";
	import api from "../services/api.ts";

	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"
	import {event} from "../stores.ts";
	import handleFetch from "../services/handle-fetch.ts";

	let title: string;
	let category: string;

	function addPresentation() {
		loading = true;
		api.newAbstract(title, category)
			.then(handleFetch)
			.then(res => {
				toast.success("Abstract submission created")
				replace('/abstract/' + res)
			})
			.catch(() => {})
			.finally(() => loading = false)
	}

	var loading: boolean = false;

</script>

<div class="columns is-centered">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Add new abstract</h1>
		</div>
		<div class="card-content has-background-white-bis is-clearfix">
			<Field label="title" message="min 10 characters">
				<Input bind:value={title}/>
			</Field>
			<Field label="category" message="pick a category">
				<div class="select is-fullwidth">
					<select bind:value={category}>
						{#each $event.categories as item}
							<option value="{item}">{item}</option>
						{/each}
					</select>
				</div>
			</Field>
			<Button class="is-primary is-fullwidth" loading={loading} on:click={addPresentation}>Next</Button>
		</div>
	</div>
</div>
