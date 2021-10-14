<script lang="ts">
	import toast from "gold-admin/toast";
	import Control from "./control";
	import modalManager, {Modal} from "gold-admin/app/modal-manager";
	import JsonEditorModal from "./json-editor.svelte"

	export let control: Control;
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

	function validate(data) {
		let presenters = 0;
		for (let user of data) if (user.presenter) presenters++;
		if (presenters === 0) return ("No presenter has been set")
		if (presenters > 1) return ("Only one presenter allowed")
		return true;
	}

	function jsonSave(data) {
		let dataValidation = validate(data)
		if (dataValidation !== true) return dataValidation;
		item.update(item => {
			item[control.field] = data;
			return item;
		});
		onChange()
		return true;
	}

	function openJsonEditor(data) {
		modalManager.add(new Modal(JsonEditorModal, {
			data, onSave: jsonSave, schema: {
				"type": "array",
				"items": {
					"type": "object",
					"properties": {
						"name": {
							"type": "object",
							"properties": {
								"last": {
									"type": "string"
								},
								"first": {
									"type": "string"
								},
								"title": {
									"type": "string"
								}
							},
							"required": [
								"last",
								"first",
								"title"
							]
						},
						"institute": {
							"type": "string"
						},
						"presenter": {
							"type": "boolean"
						}
					},
					"required": [
						"name",
						"institute",
						"presenter"
					]
				}
			}
		}));
	}

</script>

<button class="button is-size-7 mb-3" on:click={()=>openJsonEditor($item[control.field])}>Edit</button>
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
