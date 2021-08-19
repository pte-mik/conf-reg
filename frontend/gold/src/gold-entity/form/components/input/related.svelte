<!--<script lang="ts">-->
<!--	import {beforeUpdate, onMount, tick} from "svelte";-->
<!--	import FormDoc from "../doc.ts";-->

<!--	export let value: string | Array<number> = '';-->
<!--	export let api: string = '';-->
<!--	export const name = '';-->
<!--	export let Form: typeof FormDoc | null = null;-->

<!--	let values: Array<{ id: number, value: string }> = [];-->
<!--	let storedValue: string | Array<number> = '';-->


<!--	beforeUpdate(() => {-->
<!--		if (value !== storedValue) {-->
<!--			if (value.length === 0) values = [];-->
<!--			else fetch(api + '/get/' + value).then(res => res.json().then(res => values = res))-->
<!--			storedValue = value;-->
<!--		}-->
<!--	})-->

<!--	function open(id) {-->
<!--		Form.open(id);-->
<!--	}-->


<!--</script>-->

<!--<main>-->
<!--	<div class="values">-->
<!--		{#if values}-->
<!--			{#each values as item}-->
<!--				<span on:click={()=>open(item.id)}>{item.value} <i>({item.id})</i> <i class="open fas fa-external-link"></i> </span>-->
<!--			{/each}-->
<!--		{/if}-->
<!--	</div>-->
<!--</main>-->

<!--<style lang="scss">-->
<!--	@import "../../../../style/mixins";-->
<!--	main {-->
<!--		flex-grow: 1;-->
<!--		display: flex;-->
<!--		flex-direction: column;-->

<!--		div.values {-->
<!--			margin-top: 1px;-->
<!--			span {-->
<!--				@include semi-transparent-dark-button;-->
<!--				display: block;-->
<!--				padding: 0 10px 0 10px;-->
<!--				line-height: 24px;-->
<!--				margin: 1px;-->
<!--				font-weight: bold;-->
<!--				font-size: 10px;-->
<!--				i {-->
<!--					font-weight: normal;-->
<!--					font-style: normal;-->
<!--				}-->
<!--				i.open {-->
<!--					font-size: 12px;-->
<!--					line-height: 24px;-->
<!--					float: right;-->
<!--					cursor: pointer;-->
<!--					color: $highlight-color;-->
<!--					margin: 0 0 0 10px;-->
<!--				}-->
<!--			}-->
<!--		}-->
<!--	}-->
<!--</style>-->