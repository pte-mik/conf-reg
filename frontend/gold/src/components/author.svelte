<script lang="ts">
	import AuthorInput from "./author";

	export let control: AuthorInput;
	export let item;
	export let onChange: Function;

	function name(first, last) {
		first = first.replace(/\s\s+/g, ' ').trim();
		let firstname = first.split(' ')
		let displayname = '';
		if (first.length > 0) for (let i in firstname) {
			displayname += firstname[i][0].toUpperCase() + '. ';
		}
		displayname += last;
		return displayname;
	}

</script>

{#if $item[control.field] instanceof Array}
	{#each $item[control.field] as author}
		<div class="card is-size-7 mb-1">
			<div class="card-content p-2">
				<div class="content mb-0">
					<i class="fas fa-user" class:has-text-success={author.presenter}></i> <b class="has-text-white">{name(author.name.first, author.name.last)}</b> ({author.name.title} | {author.name.first} | {author.name.last})
				</div>
				<div class="content">
					<b>{author.institute}</b>
				</div>
			</div>
		</div>
	{/each}
{/if}


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
