<script lang="ts">
	import "./global-css.svelte"
	import Router from "svelte-spa-router";
	import routes from "../routes.ts"
	import {event, user} from "../stores.ts"
	import api from "../services/api.ts";
	import 'bulma/css/bulma.css'
	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"

	api.whoAmI();
	function signOut() { api.signOut();}
</script>

<nav class="navbar is-transparent mt-0 mb-6" role="navigation" aria-label="main navigation" style="background-color: rgba(0,0,0,.6)">
	<div class="navbar-brand">
		<a class="navbar-item">
			<i class="fas fa-font mr-3 has-text-danger"/>
		</a>
	</div>

	<div id="navbarBasicExample" class="navbar-menu">
		<div class="navbar-start">
			<div class="buttons">
				<Button iconPack="fas" iconLeft="users" size="is-small" rounded type="is-light" on:click={signOut}>{event.title}</Button>
				{#if ($user)}
					<Button iconPack="fas" iconLeft="user" size="is-small" rounded type="is-light" on:click={signOut}>My profile</Button>
					<Button iconPack="fas" iconLeft="file-powerpoint" size="is-small" rounded type="is-light" on:click={signOut}>My abstracts</Button>
				{/if}
			</div>

		</div>
		{#if ($user)}
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="buttons">
						<Button iconPack="fas" iconLeft="times" rounded size="is-small" type="is-danger" on:click={signOut}>Sign out</Button>
					</div>
				</div>
			</div>
		{/if}
	</div>
</nav>

<main class="container">
	<section class="mb-6">
		{#if ($user)}
			<Router routes={routes.app}/>
		{:else }
			<Router routes={routes.auth}/>
		{/if}
	</section>
	<section class="has-text-white">
		<h3 class="is-size-7 has-text-centered	">Privacy Policy</h3>
	</section>
</main>
