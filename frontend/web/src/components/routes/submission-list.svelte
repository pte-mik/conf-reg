<script lang="ts">
	import {Button} from "svelma"
	import api from "src/services/api.ts";
	import type Submission from "src/entities/submission.ts";
	import SubmissionLine from "src/components/presentation/submission-line.svelte"
	import route from "src/services/route";
	import {fade} from 'svelte/transition'

	let submissions: Array<Submission> = [];
	let promise;

	function load() {
		promise = api.submission.collect().then(res => submissions = res);
	}

	function onDelete(submission) { api.submission.delete(submission).then(load);}
	function onSubmit(submission) { api.submission.submit(submission).then(load);}

	load()
</script>

{#await promise then result}
	<div class="columns is-centered" in:fade="{{duration: 500}}">
		<div class="form column is-half card is-paddingless has-background-black-ter">
			<div class="card-content has-text-white">
				<h1 class="is-size-5 has-text-weight-bold">Submissions</h1>
			</div>
			<div class="card-content has-background-white-bis is-size-7 is-paddingless">
				<div class="table-container">
					<table class="table is-fullwidth">
						<thead>
						<tr>
							<th class="is-narrow"></th>
							<th>title</th>
							<th class="is-narrow">category</th>
							<th class="is-narrow"></th>
						</tr>
						</thead>
						{#each submissions as submission}
							<SubmissionLine submission={submission} onDelete={()=>onDelete(submission)} onSubmit={()=>onSubmit(submission)}/>
						{/each}
					</table>
				</div>
			</div>
			<div class="card-content has-background-white-bis has-text-centered">
				<Button iconPack="fas" iconLeft="plus" class="is-primary" on:click={route.submission.new}>Add new submission</Button>
			</div>
		</div>
	</div>
{/await}
