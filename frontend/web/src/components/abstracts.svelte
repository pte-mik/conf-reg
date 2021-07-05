<script lang="ts">
	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"
	import {replace} from "svelte-spa-router";

</script>

<div class="columns is-centered">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Abstracts</h1>
		</div>
		<div class="card-content has-background-white-bis has-text-centered">
			<Button iconPack="fas" iconLeft="plus" on:click={()=>replace('/abstract/new')}>Add new abstract</Button>
		</div>
	</div>
</div>