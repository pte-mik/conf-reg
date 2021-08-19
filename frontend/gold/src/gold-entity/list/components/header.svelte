<script lang="ts">
	import List from "../list";
	import {Input, Select} from "svelma";
	import options from "../../options";

	export let list: List;
	let count = list.$count;
	let page = list.$page;
</script>

<div class="header box p-3 m-0 has-background-black has-text-white-bis  is-size-7">

	<span class="icon">	<i class={list.icon}/></span>
	<span class="has-text-weight-bold">{list.title}</span>

	<!-- region: BUTTONS -->
	<div class="is-pulled-right is-size-7">
		{#each list.buttons as button}
			<i class="{button.icon} is-clickable pl-2" on:click={()=>button.action()}></i>
		{/each}
	</div>
	<!-- endregion -->

	<!-- region: QUICKSEARCH -->
	{#if list.options.quicksearch}
		<Input iconPack="fas" icon="search" size="is-small" placeholder="quick search" bind:value={list.quicksearch} on:keyup={()=>list.reload()}/>
	{/if}
	<!-- endregion -->

	<!-- region: VIEWS -->
	{#if list.options.views}
		<div class="control has-icons-left is-size-7 my-1">
			<div class="select is-fullwidth">
				<select class="has-background-black-bis has-text-white-bis border-0" bind:value={list.view} on:change={()=>list.reload()}>
					{#if list.options.views instanceof Array}
						{#each list.options.views as view}
							<option value={view}>{view}</option>
						{/each}
					{:else}
						{#each Object.entries(list.options.views) as [key, value]}
							<option value={key}>{value}</option>
						{/each}
					{/if}
				</select>
			</div>
			<div class="icon is-small is-left">
				<i class={$options.icon.list.filter}></i>
			</div>
		</div>
	{/if}
	<!-- endregion -->

	<!-- region: SORTINGS -->
	{#if list.options.sortings}
		<div class="control has-icons-left is-size-7  my-1">
			<div class="select is-fullwidth">
				<select class="has-background-black-bis has-text-white-bis border-0" bind:value={list.sorting} on:change={()=>list.reload()}>
					{#if list.options.sortings instanceof Array}
						{#each list.options.sortings as sorting}
							<option value="+{sorting}">▼ {sorting}</option>
							<option value="-{sorting}">▲ {sorting}</option>
						{/each}
					{:else}
						{#each Object.entries(list.options.sortings) as [key, value]}
							<option value="+{key}">▼ {value}</option>
							<option value="-{key}">▲ {value}</option>
						{/each}
					{/if}
				</select>
			</div>
			<div class="icon is-small is-left">
				<i class={$options.icon.list.sort}></i>
			</div>
		</div>
	{/if}
	<!-- endregion -->

	<!-- region: PAGING -->
	<div class="field is-fullwidth is-grouped">
		<div class="control ">
			<button disabled class="button is-small ">
				<i class={$options.icon.list.info}></i>&nbsp;
				<b>{$count}</b>&nbsp;items on&nbsp; <b>{Math.ceil($count / list.options.pagesize)}</b>&nbsp;pages
			</button>
		</div>
		<div class="control">
			<a class="button is-info is-small" on:click={()=>{if($page>1){$page--;list.reload()}}}>
				<i class={$options.icon.list.pager.left}></i>
			</a>
		</div>
		<Input class="has-text-centered" size="is-small" expanded readonly placeholder="page" bind:value={$page} on:keyup={()=>list.reload()}/>
		<div class="control">
			<a class="button is-info is-small" on:click={()=>{$page++;list.reload()}}>
				<i class={$options.icon.list.pager.right}></i>
			</a>
		</div>
	</div>
	<!-- endregion -->

</div>