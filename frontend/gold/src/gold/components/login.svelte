<script lang="ts">
	import type {IAuthApi} from "../interfaces";
	import options from "../options";

	let login:string = '';
	let password:string = '';
	export let authApi:IAuthApi;

	function auth(){
		authApi.login(login, password);
	}

</script>

<section class="hero is-fullheight">
	<div class="hero-body">
		<div class="container">
			<div class="columns is-centered">
				<div class="column is-5-tablet is-4-desktop is-3-widescreen">
					<form action="" class="box" on:submit|preventDefault={()=>auth()}>
						<div class="is-size-7 has-text-weight-bold has-text-centered mb-4">{options.login.title}</div>
						<div class="field">
							<div class="control has-icons-left is-size-7 ">
								<input type="text" placeholder={options.login.input.login.placeholder} class="input is-size-7 " required bind:value={login}>
								<span class="icon is-small is-left">{@html options.login.input.login.icon.tag}</span>
							</div>
						</div>
						<div class="field">
							<div class="control has-icons-left is-size-7 ">
								<input type="password" placeholder={options.login.input.password.placeholder} class="input is-size-7 "  required bind:value={password}>
								<span class="icon is-small is-left">{@html options.login.input.password.icon.tag}</span>
							</div>
						</div>
						<div class="field">
							<button class="is-size-7 button is-fullwidth is-success">{options.login.button.login.text}</button>
						</div>
						<div class="is-size-7 has-text-centered">
							<b>GoldAdmin v1.0</b><br>
							Copyright © 2021 Gergely Laborci
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>