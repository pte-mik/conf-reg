<script lang="ts">
	import type FormSection from "../form-section";
	import type {Writable} from "svelte/store";

	import Control from "./form-control.svelte"

	export let section: FormSection;
	export let item: Writable<any>;
	export let onChange: Function;
	export let errors: Writable<Array<any>>;
	let sizes = section.sizes.join(" ")
</script>

<div class="column p-1 {sizes}">
	<div class="card p-0">
		{#if section.title}
			<header class="card-header  has-background-black">
				<p class="card-header-title mb-0 is-size-7 p-2 pl-3">
					{#if section.icon}
						<span class="mr-2"><i class={section.icon}></i></span>
					{/if}
					{section.title}
				</p>
			</header>
		{/if}
		<div class="content py-2 px-3">
			{#each section.controls as control}
				<Control item={item} control={control} onChange={onChange} errors={errors}/>
			{/each}
		</div>
	</div>
</div>

<style lang="scss">
	.card {background-color: #000c}
</style>