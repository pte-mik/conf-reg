<script lang="ts">
	import type ListInput from "list";

	export let control: ListInput;
	export let item;
	export let onChange: Function;

	let value = '';

	item.subscribe(item => {
		let newValue = item[control.field];
		if (value !== newValue) {
			value = newValue?.join('\n');
		}
	});
	function keydown(event) {
		let input = event.target;
		if (event.keyCode === 9) {
			let v = input.value;
			let s = input.selectionStart
			let e = input.selectionEnd;
			input.value = v.substring(0, s) + "\t" + v.substring(e);
			input.selectionStart = input.selectionEnd = s + 1;
			event.preventDefault();
		}
	}

	function localchange(event) {
		item.update(item=>{
			item[control.field] = event.target.value.split('\n');
			item[control.field] = item[control.field].filter(item=>item.trim() !== '');
			return item;
		})
		onChange();
	}
</script>

<div class="is-size-7 growing code" data-replicated-value={value}>
	<textarea class="textarea is-size-7 has-fixed-size code" bind:value={value} on:keydown={keydown} on:change={(event)=>localchange(event)}></textarea>
</div>


<style lang="scss">
	div.growing {
		display: grid;
		white-space: pre-wrap;
		width: 100%;
		min-height: 140px;
		&::after {
			content: attr(data-replicated-value) " ";
			white-space: pre-wrap;
			border: 1px;
			padding: calc(0.75em - 1px);
			visibility: hidden;
		}
	}
	textarea.textarea.code,
	div.growing.code::after {
		font-family: "Courier New", monospace !important;
		tab-size: 3;
		font-weight: 600;
		font-size: 13px !important;
	}
	div.growing::after,
	textarea {
		grid-area: 1 / 1 / 2 / 2;
		line-height: 20px;
		font-weight: 400;
		min-height: 100% !important;
	}
</style>
