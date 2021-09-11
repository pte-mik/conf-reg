<script lang="ts">
	import Confirm from "src/components/presentation/confirm.svelte";
	import type Submission from "src/entities/submission.ts";
	import {status} from "src/entities/submission.ts";
	import route from "src/services/route";
	import {Button, Icon, Tooltip} from "svelma"

	let showDeleteConfirm: boolean = false;
	let showSubmitToReview: boolean = false;
	export let submission: Submission;
	export let onDelete: Function;
	export let onSubmit: Function;
</script>

<tr>
	<td>
		<Tooltip label="{status[submission.status].label}" position="is-right" size="is-small" type="is-dark">
			<Icon pack="fal" type={"is-" +status[submission.status].type} icon={status[submission.status].icon}/>
		</Tooltip>
	</td>
	<td class="has-text-weight-bold">{submission.title}</td>
	<td>{submission.category}</td>
	<td>
		<div class="field has-addons has-addons-right">
			{#if submission.status === "draft"}
				<p class="control">
					<Tooltip label="edit" animate={false} position="is-left" size="is-small" type="is-dark">
						<Button class="is-small is-white has-text-info" on:click={()=>route.submission.edit(submission.id)}>
							<Icon pack="fas" icon="pen"/>
						</Button>
					</Tooltip>
				</p>
				<p class="control">
					<Tooltip label="delete" animate={false} position="is-left" size="is-small" type="is-dark">
						<Button class="is-small is-white has-text-danger" on:click={()=>showDeleteConfirm = true}>
							<Icon pack="fas" icon="times"/>
						</Button>
					</Tooltip>
				</p>
				<p class="control">
					<Tooltip label="submit to review" animate={false} position="is-left" size="is-small" type="is-dark">
						<Button class="is-small is-white has-text-info" on:click={()=>showSubmitToReview = true}>
							<Icon pack="fas" icon="envelope"/>
						</Button>
					</Tooltip>
				</p>
			{/if}
			<p class="control">
				<Tooltip label="preview" animate={false} position="is-left" size="is-small" type="is-dark">
					<Button class="is-small is-white has-text-info" on:click={()=>route.submission.preview(submission.id)}>
						<Icon pack="fas" icon="eye"/>
					</Button>
				</Tooltip>
			</p>
		</div>

		<Confirm bind:active={showDeleteConfirm} ok="Delete" okStyle="is-danger" on:ok={onDelete} title="Delete">
			<p class="has-text-centered">Are you sure, you want to delete the submission?</p>
			<p class="has-text-centered has-text-weight-bold">{submission.title}</p>
		</Confirm>

		<Confirm bind:active={showSubmitToReview} ok="Submit" on:ok={onSubmit} title="Submit to review">
			<p class="has-text-centered">Are you sure, you want to submit it to review?</p>
			<p class="has-text-centered has-text-weight-bold">{submission.title}</p>
			<p class="has-text-centered">After submiting the abstract to rewiew you can not delete or modify it.</p>
		</Confirm>
	</td>
</tr>
