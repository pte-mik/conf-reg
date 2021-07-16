<script lang="ts">
	import "./global-css.svelte"
	import Router from "svelte-spa-router";
	import routes from "src/services/routes"
	import {event, user} from "src/services/stores"
	import api from "src/services/api";
	import ApplicationFrame from "src/components/presentation/application-frame.svelte";

	let promise = api.whoAmI();
</script>

{#await promise then result}
	<ApplicationFrame user={user} event={event} onSignOut={()=>api.signOut()}>
		{#if ($user)}
			<Router routes={routes.authenticated}/>
		{:else }
			<Router routes={routes.unatuhenticated}/>
		{/if}
	</ApplicationFrame>
{/await}