<script lang="ts">
	import Author from "./author.svelte";
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


	import {flip} from 'svelte/animate';

	let hovering = false;

	export let params;

	let submission: Submission;
	let loading = false;

	api.getAbstract(params.id)
		.then(handleFetch)
		.then(res => submission = res)
		.catch(e => replace('/'))

	function save() {
		loading = true
		api.saveAbstract(submission)
			.then(handleFetch)
			.then(() => toast.success("Saved"))
			.finally(() => {
				loading = false;
			})
	}

	function changePresenter(index) {
		for (let author of submission.authors) {
			author.presenter = false;
		}
		submission.authors[index].presenter = true;
		submission.authors = [...submission.authors];
	}

	const drop = (event, target) => {
		event.dataTransfer.dropEffect = 'move';
		const start = parseInt(event.dataTransfer.getData("text/plain"));
		const newTracklist = submission.authors;

		if (start < target) {
			newTracklist.splice(target + 1, 0, newTracklist[start]);
			newTracklist.splice(start, 1);
		} else {
			newTracklist.splice(target, 0, newTracklist[start]);
			newTracklist.splice(start + 1, 1);
		}
		submission.authors = newTracklist
		hovering = false;
	}

	const dragstart = (event, i) => {
		event.dataTransfer.effectAllowed = 'move';
		event.dataTransfer.dropEffect = 'move';
		const start = i;
		event.dataTransfer.setData('text/plain', start);
	}

	function addNewAuthor() {
		submission.authors.push({name: {first: '', last: '', title: ''}, presenter: (!submission.authors.length), institute: ""});
		submission.authors = [...submission.authors]
	}

	function deleteAuthor(index) {
		if (confirm('Are you sure?')) {
			let author = submission.authors.splice(index, 1)[0];
			if (author.presenter && submission.authors.length > 0) {
				submission.authors[0].presenter = true;
			}
			submission.authors = [...submission.authors]
		}
	}
	function deleteSubmission() {

	}

	function submitToReview() {

	}
</script>

{#if (submission)}

	<div class="columns is-centered">
		<div class="form column is-half card is-paddingless has-background-black-ter">
			<div class="card-content has-text-white">
				<h1 class="is-size-5 has-text-weight-bold">Abstract <span class="is-size-7">({submission.status})</span>
				</h1>
				<div class="is-size-7">{submission.title}</div>
			</div>
			<div class="card-content has-background-white-bis">
				<Field label="title">
					<Input bind:value={submission.title}/>
				</Field>
				<Field label="category">
					<div class="select is-fullwidth">
						<select bind:value={submission.category}>
							{#each $event.categories as item}
								<option value="{item}">{item}</option>
							{/each}
						</select>
					</div>
				</Field>
				<Field label="abstract text">
					<Input type="textarea" bind:value={submission.text}/>
				</Field>
				<div class="divider">Authors</div>
				{#each submission.authors as author, index (index)}
					<div class="box is-fullwidth my-5 is-paddingless"
						 animate:flip={{duration:300}}
						 draggable={true}
						 on:dragstart={event => dragstart(event, index)}
						 on:drop|preventDefault={event => drop(event, index)}
						 ondragover="return false"
						 on:dragenter={() => hovering = index}
						 class:is-active={hovering === index}>
						<Author author={author} index={index} on:deleteAuthor={()=>deleteAuthor(index)} on:changePresenter={()=>changePresenter(index)}/>
					</div>
				{/each}
				<div class="has-text-centered">
					<Button iconPack="fas" iconLeft="plus" class="is-primary is-small" rounded on:click={addNewAuthor}>Author</Button>
				</div>

			</div>
			<div class="card-content has-text-white has-text-centered">
				<Button iconPack="fas" iconLeft="times" class="is-danger" loading={loading} on:click={deleteSubmission}>Delete</Button>
				<Button iconPack="fas" iconLeft="save" class="is-info" loading={loading} on:click={submitToReview}>Submit to review</Button>
				<Button iconPack="fas" iconLeft="save" class="is-primary" loading={loading} on:click={save}>Save changes</Button>
				<div class="is-size-7 mt-4 has-text-primary">Saving the changes will set the status of the submission to draft</div>
			</div>
		</div>
	</div>
{/if}