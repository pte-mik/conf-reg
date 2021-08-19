<script lang="ts">
	import MenuItem from "../menu-item";
	import {get} from "svelte/store";
	import goldOptions from "../options";
	export let menu: Array<MenuItem>;

	let options = get(goldOptions);
</script>


<nav class="navbar" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a class="navbar-item" href="https://bulma.io">
			<img src="{options.logoImageUrl}" width="112" height="28">
		</a>
	</div>

	<div id="navbarBasicExample" class="navbar-menu is-size-7">
		<div class="navbar-start">
			{#each menu as menuItem}
				{#if typeof menuItem.action === "function"}
					<a class="navbar-item" on:click={menuItem.action}>
						{#if menuItem.icon}
							<span class="icon"><i class="{menuItem.icon}"/></span>
						{/if}
						<span>{menuItem.label}</span>
					</a>
				{:else }
					<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link">
							{#if menuItem.icon}
								<span class="icon"><i class="{menuItem.icon}"/></span>
							{/if}
							<span>{menuItem.label}</span>
						</a>
						<div class="navbar-dropdown">
							{#each menuItem.action as menuItem}
								<a class="navbar-item is-size-7" on:click={menuItem.action}>
									{#if menuItem.icon}
										<span class="icon"><i class="{menuItem.icon}"/></span>
									{/if}
									<span>{menuItem.label}</span>
								</a>
							{/each}
						</div>
					</div>
				{/if}
			{/each}
		</div>

		<div class="navbar-end">
			<div class="navbar-item">
				<div class="buttons">
					<a class="button is-light is-small is-inverted is-rounded has-text-danger"> <span class="icon"><i class="{options.iconLogout}"/></span> </a>
				</div>
			</div>
		</div>
	</div>
</nav>