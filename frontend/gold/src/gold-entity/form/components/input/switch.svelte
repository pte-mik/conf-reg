<script lang="ts">
	import {Switch} from "svelma"
	import type EntityPage from "../../../form/form-page";
	export let page: EntityPage;
	import type SwitchInput from "./switch";
	export let control:SwitchInput;
	export let item;
	export let onChange: Function;
</script>
<Switch type="is-info" size="is-small" on:click={onChange} bind:checked={$item[control.field]}/>
<!--<input type="checkbox" size="is-small" bind:checked={$item[control.field]} value="1" on:change={onChange} />-->


<!--<script lang="ts">-->
<!--	import {onMount} from "svelte";-->

<!--	export let value = false;-->
<!--	export const name = '';-->

<!--	$: value = value??false;-->

<!--</script>-->

<!--<input type="checkbox" bind:checked={value}>-->

<!--<style lang="scss">-->
<!--	@import "../../../../style/mixins";-->

<!--	input {-->
<!--		-moz-appearance: none;-->
<!--		-webkit-appearance: none;-->
<!--		-o-appearance: none;-->
<!--		outline: none;-->
<!--		content: none;-->
<!--		cursor: pointer;-->
<!--		text-shadow: 0 0 6px black;-->
<!--	}-->

<!--	input:before {-->
<!--		font-family: "Font Awesome 5 Pro";-->
<!--		content: "\f204";-->
<!--		font-size: 16px;-->
<!--		color: $highlight-color;-->
<!--		opacity: .6;-->
<!--		transition: all .3s;-->
<!--		font-weight: 100;-->
<!--	}-->

<!--	input:checked:before {-->
<!--		opacity: 1;-->
<!--		content: "\f205";-->
<!--	}-->


<!--</style>-->