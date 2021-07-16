<script lang="ts">
	import AuthorTag from "src/components/presentation/author.svelte";
	import Button from "svelma/src/components/Button.svelte"
	import {event} from "src/services/stores.ts";
	import type Author from "src/entities/author.ts";


	export let authors: Array<Author>;

	function changePresenter(index) {
		for (let author of authors) author.presenter = false;
		authors[index].presenter = true;
	}

	const drop = (event, target) => {
		event.dataTransfer.dropEffect = 'move';
		const start = parseInt(event.dataTransfer.getData("text/plain"));
		const newlist = authors;
		if (start < target) {
			newlist.splice(target + 1, 0, newlist[start]);
			newlist.splice(start, 1);
		} else {
			newlist.splice(target, 0, newlist[start]);
			newlist.splice(start + 1, 1);
		}
		authors = newlist
	}

	const dragstart = (event, i) => {
		event.dataTransfer.effectAllowed = 'move';
		event.dataTransfer.dropEffect = 'move';
		event.dataTransfer.setData('text/plain', i);
	}

	function addNewAuthor() {
		authors.push({name: {first: '', last: '', title: ''}, presenter: (!authors.length), institute: ""});
		authors = [...authors]
	}

	function deleteAuthor(index) {
		let author = authors.splice(index, 1)[0];
		if (author.presenter && authors.length > 0) authors[0].presenter = true;
		authors = [...authors]
	}
</script>
{#each authors as author, index }
	<div class="box is-fullwidth my-5 is-paddingless"
		 draggable={true}
		 on:dragstart={event => dragstart(event, index)}
		 on:drop|preventDefault={event => drop(event, index)}
		 ondragover="return false">
		<div>
			<AuthorTag author={author} index={index} onDeleteAuthor={deleteAuthor} onChangePresenter={changePresenter}/>
		</div>
	</div>
{/each}
<div class="has-text-centered">
	<Button iconPack="fas" iconLeft="plus" class="is-primary is-small" rounded on:click={addNewAuthor}>Author</Button>
</div>