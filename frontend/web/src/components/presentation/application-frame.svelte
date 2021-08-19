 <script lang="ts">
	import type User from "src/entities/user.ts";
	import type Event from "src/entities/event";
	import {Button, Icon} from "svelma"
	import route from "src/services/route";

	export let event: Event;
	export let onSignOut: Function;
	export let user: User;

	let isHamburgerActive: boolean = false;


</script>

<nav class="navbar is-transparent is-black mt-0 mb-6" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a href class="navbar-item has-text-weight-bold has-text-white">
			<div class="mr-3">
				<Icon pack="fas" icon="user-ninja"/>
			</div>
			<div class="mr-3">Conference ninja</div>
		</a>
		<a role="button" class="navbar-burger burger" class:is-active={isHamburgerActive} aria-label="menu" aria-expanded="false" data-target="navbarBasicExample" on:click={()=>isHamburgerActive = !isHamburgerActive}>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</a>
	</div>

	<div class="navbar-menu" class:is-active={isHamburgerActive}>
		<div class="navbar-start">
			<a class="navbar-item is-size-7" target="_blank" href={$event.website}><span class="mr-1"><Icon pack="fas" icon="users"/></span> {$event.title}</a>
			{#if ($user)}
				<a class="navbar-item is-size-7" target="_blank" href on:click|preventDefault={route.profile}><span class="mr-1"><Icon pack="fas" icon="user"/></span>My profile</a>
				<a class="navbar-item is-size-7" target="_blank" href on:click|preventDefault={route.submission.list}><span class="mr-1"><Icon pack="fas" icon="file-powerpoint"/></span>My submissions</a>
			{/if}
		</div>
		{#if ($user)}
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="buttons">
						<Button iconPack="fas" iconLeft="times" size="is-small" type="is-danger" on:click={onSignOut}>Sign out</Button>
					</div>
				</div>
			</div>
		{/if}
	</div>
</nav>

<main class="container mb-6">
	<section>
		<slot/>
	</section>
</main>