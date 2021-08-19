<script lang="ts">
	// import {component} from "gold-entity/form/abstract-input";
	// import {beforeUpdate} from "svelte";
	//
	// import type SelectorInput from "./selector";
	// export let control:SelectorInput;
	// export let item;
	// export let onChange: Function;
	//
	//
	//
	// let value: Array<number> = typeof item[control.field] === "object" ? [item.control.field] : item[control.field];
	//
	// export let api: string = '';
	// export const name = '';
	// export let Form = null;
	// export let multi: boolean = false;
	//
	// let values: Array<{ id: number, value: string }> = [];
	// let storedValue: number | Array<number> = [];
	// let options = [];
	//
	// async function input(event) {
	// 	let search = event.target.value.trim();
	// 	if (search.length >= control.minChar) {
	// 		options = await control.api!.search(event.target.value)
	// 	} else{
	// 		options = [];
	// 	}
	// }
	//
	// function add(id: number) {
	// 	if (multi) {
	// 		if (!(value instanceof Array)) value = [];
	// 		value = [...new Set([...value, id])];
	// 	} else value = id;
	// }
	//
	// function remove(id: any) {
	// 	if (multi) {
	// 		let index = value.indexOf(id);
	// 		if (index !== -1) value.splice(index, 1);
	// 		value = [...value];
	// 	} else value = '';
	// }
	//
	// function open(id) { Form.open(id)}
	//
	// beforeUpdate(() => {
	// 	if (value === null) value = [];
	// 	if (value !== storedValue) {
	// 		if (value.length === 0) values = [];
	// 		else{
	// 			control.api!.get(value).then(res => res = values)
	// 		}
	// 		// else fetch(api + '/get/' + value).then(res => res.json().then(res => values = res))
	// 		storedValue = value;
	// 	}
	// })
	//

	import {Input} from "svelma"
	import {get} from "svelte/store";
	import type SelectorInput from "./selector";

	export let control: SelectorInput;
	export let item;
	export let onChange: Function;

	let options: Array<{id:number, value:string}> = [];
	let value = get(item)[control.field];

	if(control.multi && !(value instanceof Array)) value = [];

	async function input(event) {
		let search = event.target.value.trim();
		if (search.length >= control.minChar) {
			options = await control.api!.search(search)
		} else {
			options = [];
		}
	}

	function add(id: number) {
		if (control.multi) {
			if (!(value instanceof Array)) value = [];
			value = [...new Set([...value, id])];
		} else value = id;
	}

	function remove(id: any) {
		if (control.multi) {
			let index = value.indexOf(id);
			if (index !== -1) value.splice(index, 1);
			value = [...value];
		} else value = '';
	}
</script>

<main>
	<Input type="text" on:input={input} placeholder="search"/>

	<div class="options">
		{#each options as option}
			<div on:click={()=>add(option.id)}>{option.value}</div>
		{/each}
	</div>

		<div class="values">
			{#if values !== null}
				{#each values as item}
				<span>
					<i on:click={()=>remove(item.id)} class="remove fas fa-times"></i>
					<span>{item.value} ({item.id})</span>
					{#if Form}<i on:click={()=>open(item.id)} class="open fas fa-external-link-alt"></i>{/if}
				</span>
				{/each}
			{/if}
		</div>
</main>

<style lang="scss">
	//@import "../../../../style/mixins";
	//main {
	//	flex-grow: 1;
	//	display: flex;
	//	flex-direction: column;
	//	input {
	//		@include input;
	//	}
	//	div.options {
	//		margin-top: 2px;
	//		max-height: 100px;
	//		overflow: auto;
	//		div {
	//			@include semi-transparent-dark-button;
	//			margin-bottom: 1px;
	//			line-height: 24px;
	//			padding: 0;
	//			cursor: pointer;
	//
	//			color: $highlight-color;
	//
	//			&:before {
	//				font-family: "Font Awesome 5 Free";
	//				content: '\f0fe';
	//				font-weight: bold;
	//				padding: 0 10px;
	//			}
	//		}
	//	}
	//	div.values {
	//		margin-top: 1px;
	//		> span {
	//			@include semi-transparent-button;
	//			padding: 4px;
	//			line-height: 24px;
	//			margin: 1px;
	//			cursor: default;
	//			font-weight: bold;
	//			font-size: 10px;
	//			display: inline-flex;
	//			align-items: center;
	//			> * { line-height: 12px;}
	//			i {}
	//
	//			i.remove {
	//				font-size: 12px;
	//				cursor: pointer;
	//				color: orangered;
	//				margin: 0 5px;
	//				transition: all .3s;
	//				&:hover {
	//					transform: rotate(180deg);
	//				}
	//			}
	//			i.open {
	//				font-size: 12px;
	//				cursor: pointer;
	//				color: $highlight-color;
	//				margin: 0 0 0 5px;
	//			}
	//		}
	//	}
	//}


</style>