<script lang="ts">
	import api from "src/services/api.ts";

	import toast from "src/services/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"
	import {event} from "src/services/stores";
	import handleFetch from "src/services/handle-fetch.ts";
	import {fade} from 'svelte/transition'
	import route from "src/services/route";
	let title: string;
	let category: string;

	function addPresentation() {
		loading = true;
		api.submission.create(title, category)
			.then(handleFetch)
			.then(res => {
				toast.success("Submission created")
				route.submission.edit(res)
			})
			.catch(() => {})
			.finally(() => loading = false)
	}

	var loading: boolean = false;

</script>

<div class="columns is-centered" in:fade="{{duration: 500}}">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">New Submission</h1>
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
