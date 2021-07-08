<script lang="ts">
	import Author from "./author.svelte";
	import Authors from "./authors.svelte";
	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"
	import Icon from "svelma/src/components/Icon.svelte"
	import Switch from "svelma/src/components/Switch.svelte"
	import Tooltip from "svelma/src/components/Tooltip.svelte"
	import Tag from "svelma/src/components/Tag/Tag.svelte"
	import Taglist from "svelma/src/components/Tag/Taglist.svelte"
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

	function removeKeyword(index){
		submission.keywords.splice(index,1);
		submission.keywords = [...new Set(submission.keywords)];
	}

	function addKeyword(keyword){
		keyword = keyword.trim().toLocaleUpperCase();
		if(keyword.length === 0) return;
		if(keyword.length < 3){
			toast.danger("Keyword must be at least 3 characters long")
		}else{
		submission.keywords.push(keyword);
		submission.keywords = [...new Set(submission.keywords)];
		}
	}

	function save() {
		loading = true
		api.saveAbstract(submission)
			.then(handleFetch)
			.then(() => toast.success("Saved"))
			.finally(() => {
				loading = false;
			})
	}

	function preview() {

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
				<div class="divider my-2">Keywords</div>
				<Taglist>
					{#each submission.keywords as keyword, index}
						<Tag type="is-info" closable on:close={()=>{removeKeyword(index)}}>{keyword}</Tag>
					{/each}
				</Taglist>
				<Input icon="plus" on:keypress = {e => {if (e.charCode === 13){ addKeyword(e.target.value); e.target.value = ''}}}/>

				<div class="divider">Authors</div>
				<Authors bind:authors={submission.authors}/>

			</div>
			<div class="card-content has-text-white has-text-centered">
				<Button iconPack="fas" iconLeft="times" class="is-danger" loading={loading} on:click={deleteSubmission}>Delete</Button>
				<Button iconPack="fad" iconLeft="eye" class="is-info" loading={loading} on:click={preview}>Preview</Button>
				<Button iconPack="fad" iconLeft="save" class="is-info" loading={loading} on:click={submitToReview}>Submit to review</Button>
				<Button iconPack="fas" iconLeft="save" class="is-primary" loading={loading} on:click={save}>Save changes</Button>
			</div>
		</div>
	</div>
{/if}