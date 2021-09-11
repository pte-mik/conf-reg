<script lang="ts">
	import Authors from "src/components/presentation/authors.svelte";
	import Confirm from "src/components/presentation/confirm.svelte";
	import FileUpload from "src/components/presentation/file-upload.svelte";
	import type Submission from "src/entities/submission.ts";
	import {status} from "src/entities/submission.ts";
	import api from "src/services/api";
	import handleFetch from "src/services/handle-fetch.ts";
	import route from "src/services/route";
	import {event} from "src/services/stores";
	import toast from "src/services/toast.ts";
	import {Button, Field, Input, Tag, Taglist} from "svelma"
	import {createEventDispatcher} from 'svelte';
	import {fade} from 'svelte/transition';

	const dispatch = createEventDispatcher();

	let showDeleteConfirm = false;
	let showDeleteImageConfirm = false;
	let submission: Submission;
	let loading = false;

	export let params;
	let promise = load();


	function load() {
		return api.submission.get(params.id)
			.then(handleFetch)
			.then(res => submission = res)
			.catch(e => route.root())
	}

	function removeKeyword(index) {
		submission.keywords.splice(index, 1);
		submission.keywords = [...new Set(submission.keywords)];
	}

	function addKeyword(keyword) {
		keyword = keyword.trim().toLocaleUpperCase();
		if (keyword.length === 0) return;
		if (keyword.length < 3) {
			toast.danger("Keyword must be at least 3 characters long")
		} else {
			submission.keywords.push(keyword);
			submission.keywords = [...new Set(submission.keywords)];
		}
	}

	function save() {
		loading = true
		api.submission.save(submission)
			.then(handleFetch)
			.then(() => toast.success("Saved"))
			.finally(() => {
				loading = false;
				route.submission.list();
			})
	}

	function uploadImage(file: File) {
		api.submission.image.add(submission.id, file).then(load)
	}

	function deleteImage() {
		api.submission.image.remove(submission.id).then(load)
	}

</script>

{#await promise then result}
	<div class="columns is-centered" in:fade={{duration:500}}>
		<div class="form column is-half card is-paddingless has-background-black-ter">
			<div class="card-content has-text-white">
				<h1 class="is-size-5 has-text-weight-bold">Submission </h1>
				<div class="is-size-7">({status[submission.status].label})</div>
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
				<div class="divider my-2">Image</div>
				<div class="has-text-centered">
					{#if submission.image}
						<div class="card">
							<div class="card-image">
								<figure class="image">
									<img src={submission.image} alt="submission image">
								</figure>
							</div>
							<div class="card-content p-2">
								<Field>
									<Input placeholder="image caption" type="text" bind:value={submission.imageCaption} expanded/>
									<p class="control">
										<Button iconPack="fas" iconLeft="times" type="is-danger" on:click={()=>showDeleteImageConfirm = true}>Delete</Button>
									</p>
								</Field>

							</div>
						</div>
					{:else}
						<p class="is-size-7">optional upload one image for the abstract (max: 512Kb, png, jpg)</p>
						<FileUpload onFileSelect={uploadImage}/>
					{/if}
				</div>


				<div class="divider my-2">Keywords</div>
				<Taglist>
					{#each submission.keywords as keyword, index}
						<Tag type="is-info" closable on:close={()=>{removeKeyword(index)}}>{keyword}</Tag>
					{/each}
				</Taglist>
				<Input icon="plus" on:keypress={e => {if (e.charCode === 13){ addKeyword(e.target.value); e.target.value = ''}}}/>

				<div class="divider">Authors</div>
				<Authors bind:authors={submission.authors}/>

			</div>
			<div class="card-content has-text-white has-text-centered">
				<Button iconPack="fas" iconLeft="save" class="is-primary" loading={loading} on:click={save}> Save Changes</Button>
			</div>
		</div>
	</div>

	<Confirm bind:active={showDeleteImageConfirm} ok="Delete" okStyle="is-danger" on:ok={deleteImage}>
		<p class="has-text-centered">Are you sure, you want to delete the image?</p>
	</Confirm>
{/await}
