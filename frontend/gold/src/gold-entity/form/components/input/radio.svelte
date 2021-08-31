<script lang="ts">
	import type RadioInput from "./radio";
	import type EntityPage from "../../../form/form-page";
	export let page: EntityPage;

	export let control: RadioInput;
	export let item;
	export let onChange: Function;

	let name = control.field + Math.random();
</script>

<div class="control is-size-7">
	{#each control.options as option}
		<label class="radio m-0 mr-2">
			<input type="radio" class="mr-1" on:change={onChange} name={name} value={option.value} bind:group={$item[control.field]}>
			{option.label}
		</label>
	{/each}
</div>

<style lang="scss">
	label{
		display: inline-flex;
		align-items: center;
	}
</style>