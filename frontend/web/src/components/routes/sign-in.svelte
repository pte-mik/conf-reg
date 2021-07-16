<script lang="ts">
	import route from "src/services/route";
	import api from "src/services/api";
	import toast from "src/services/toast";
	import {Field,Input,Button} from "svelma"
	import handleFetch from "src/services/handle-fetch";

	let email: string = "";
	let password: string = "";

	function signIn() {
		api.signIn(email, password)
			.then(handleFetch)
			.then(res => {
				api.whoAmI();
				toast.success('Authentication Successfull');
				route.root();
			})
			.catch(e => {})
	}
</script>

<div class="columns is-centered">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Sign in</h1>
			<p class="is-size-7">Don't have an account? <a class="has-text-primary" href on:click|preventDefault={()=>route.auth.signUp()}>Sign up now</a></p>
		</div>
		<div class="card-content has-background-white-bis is-clearfix">
			<Field label="e-mail">
				<Input bind:value={email}/>
			</Field>
			<Field label="password">
				<Input type="password" bind:value={password} passwordReveal={true}/>
			</Field>
			<Button class="is-primary is-pulled-right" on:click={signIn}>Sign In</Button>
		</div>
		<div class="card-content has-background-black-ter has-text-centered">
			<a class="is-size-7 has-text-primary" href on:click|preventDefault={route.auth.forgotPassword}>Forgot password</a>
		</div>
	</div>
</div>
