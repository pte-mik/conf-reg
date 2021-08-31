<script lang="ts">
	import type TimeInput from "./time";
	import type EntityPage from "../../../form/form-page";
	export let page: EntityPage;
	export let control: TimeInput;
	export let item;
	export let onChange: Function;
</script>

<input class="input is-small" type="time" bind:value={$item[control.field]} on:change={onChange}>

<style lang="scss">
	input::-webkit-calendar-picker-indicator {
		cursor: pointer;
		padding: 0;
		width: 20px;
		height: 20px;
		-webkit-text-fill-color: blue;
		filter: invert(1);
	}
</style>