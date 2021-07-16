<script lang="ts">
	import type Submission from "src/entities/submission.ts";
	import api from "src/services/api.ts";
	import handleFetch from "src/services/handle-fetch.ts";
	import route from "src/services/route";
	import {fade} from 'svelte/transition'


	let submission: Submission;
	export let params;

	let promise = api.submission.get(params.id)
		.then(handleFetch)
		.then(res => submission = res)
		.catch(e => route.root())

	function displayName(first, last) {
		first = first.replace(/\s\s+/g, ' ').trim();
		let firstname = first.split(' ')
		let displayname = '';
		if (first.length > 0) for (let i in firstname) {
			displayname += firstname[i][0].toUpperCase() + '. ';
		}
		displayname += last;
		return displayname;
	}
</script>
{#await promise then result}
	<div class="columns is-centered" in:fade="{{duration: 500}}">
		<div class="form column is-two-thirds card p-6">
			<h1 class="is-size-3 has-text-weight-bold">{submission.title}</h1>
			<div class="block">
				{#each submission.authors as author, index }
					<span class="has-text-weight-bold">{displayName(author.name.first, author.name.last)}</span>
					{#if author.presenter}<sup>*</sup>{/if}
					<sup>{index + 1}</sup>
					{#if (index !== submission.authors.length - 1)},&nbsp;{/if}
				{/each}
				{#each submission.authors as author, index }
					<div class="is-size-7">
						<sup>{index + 1}</sup>
						<span class="is-italic">{author.institute}</span>
					</div>
				{/each}
			</div>
			<div class="block is-size-7">
				<b>Keywords</b>:
				{#each submission.keywords as keyword, index }
					{keyword}
					{#if (index !== submission.keywords.length - 1)};&nbsp;{/if}
				{/each}
			</div>
			<div class="block">
				{@html submission.text.replace(/(?:\r\n|\r|\n)/g, '<br>')}
			</div>
			{#if submission.originalImage}
				<div class="block has-text-centered">
					<img src={submission.originalImage} alt="submission image">
					<div class="has-text-centered is-italic">{submission.imageCaption}</div>
				</div>
			{/if}
		</div>
	</div>
{/await}

