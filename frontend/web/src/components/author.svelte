<script lang="ts">
	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"
	import Icon from "svelma/src/components/Icon.svelte"
	import Switch from "svelma/src/components/Switch.svelte"
	import Tooltip from "svelma/src/components/Tooltip.svelte"
	import {replace} from "svelte-spa-router";
	import api from "../services/api.ts";
	import type Submission from "../entities/submission.ts";
	import handleFetch from "../services/handle-fetch.ts";
	import {event} from "../stores.ts";
	import type Author from "../entities/author.ts";

	import {createEventDispatcher} from 'svelte';

	const dispatch = createEventDispatcher();

	function changePresenter() { !author.presenter && dispatch('changePresenter');}
	function deleteAuthor() { dispatch('deleteAuthor');}

	export let index;
	export let author: Author;
	$: displayname = ((first, last) => {
		first = first.replace(/\s\s+/g, ' ').trim();
		let firstname = first.split(' ')
		let displayname = '';
		if (first.length > 0) for (let i in firstname) {
			displayname += firstname[i][0].toUpperCase() + '. ';
		}
		displayname += last;
		return displayname;
	})(author.name.first, author.name.last);


</script>
<div class="card-content has-text-white has-background-grey-dark p-3 mb-4 is-vcentered is-clearfix">
	<Tooltip label="You can drag and drop the authors" type="is-dark" rounded>
		<Icon pack="fas" type="is-warning" icon="grip-vertical"/>
	</Tooltip>
	<span class=" has-text-weight-bold"> {displayname}</span>
	<Field class="is-pulled-right">
		<div class="control">
			<Tooltip label="Presenter" rounded>
				<Button type={author.presenter ? "is-success" : "is-dark"} size="is-small" on:click={changePresenter}>
					<Icon pack="fas" icon="comment-alt-smile"/>
				</Button>
			</Tooltip>
		</div>
		<div class="control">
			<Tooltip label="Remove author" type="is-danger" rounded>
				<Button type="is-danger" size="is-small" on:click={deleteAuthor}>
					<Icon pack="fas" icon="times"/>
				</Button>
			</Tooltip>
		</div>
	</Field>
</div>
<div class="columns is-variable is-1 is-vcentered mb-0 pr-4">
	<div class="column is-1 has-text-centered">
		<Icon pack="fal" icon="user"/>
	</div>
	<div class="column is-2"><Input placeholder="title" class="is-size-7" bind:value={author.name.title}/></div>
	<div class="column"><Input placeholder="first name" class="is-size-7" bind:value={author.name.first}/></div>
	<div class="column"><Input placeholder="last name" class="is-size-7" bind:value={author.name.last}/></div>

</div>

<div class="columns is-paddingless is-variable is-1 is-vcentered pr-4">
	<div class="column is-1 has-text-centered">
		<Icon pack="fal" icon="university"/>
	</div>
	<div class="column"><Input placeholder="institue(s)" class="is-size-7" bind:value={author.institute}/></div>
</div>

