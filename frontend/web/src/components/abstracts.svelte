<script lang="ts">
	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"
	import Icon from "svelma/src/components/Icon.svelte"
	import Tooltip from "svelma/src/components/Tooltip.svelte"
	import {replace} from "svelte-spa-router";
	import api from "../services/api.ts";
	import type Submission from "../entities/submission.ts";

	let abstracts: Array<Submission> = [];
	api.getAbstracts().then(res => abstracts = res);

	let icons = {
		draft: {type: "info", icon: "edit"},
		"in-review": {type: "info", icon: "file-search"},
		accepted: {type: "success", icon: "check"},
		declined: {type: "danger", icon: "times"},
	}

</script>

<div class="columns is-centered">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Abstracts</h1>
		</div>
		<div class="card-content has-background-white-bis is-size-7 is-paddingless">
			<div class="table-container">
				<table class="table is-fullwidth">
					<thead>
					<tr>
						<th>status</th>
						<th>title</th>
						<th>category</th>
						<th style="text-align: right">edit</th>
					</tr>
					</thead>
					{#each abstracts as abstract}
						<tr>
							<td>
								<Tooltip label="{abstract.status}" position="is-right" type={"is-"+icons[abstract.status].type}><span class="icon is-size-7"><i class={"fal fa-" + icons[abstract.status].icon + " has-text-" +icons[abstract.status].type}/></span></Tooltip>
							</td>
							<td class="has-text-weight-bold">{abstract.title}</td>
							<td>{abstract.category}</td>
							<td style="text-align: right">
								<Button class="is-primary is-small" rounded on:click={()=>replace("/abstract/"+abstract.id)}>
									<Icon pack="fas" icon="pen"/>
								</Button>
							</td>
						</tr>
					{/each}
				</table>
			</div>
		</div>
		<div class="card-content has-background-white-bis has-text-centered">
			<Button iconPack="fas" iconLeft="plus" class="is-primary" on:click={()=>replace('/abstract/new')}>Add new abstract</Button>
		</div>
	</div>
</div>