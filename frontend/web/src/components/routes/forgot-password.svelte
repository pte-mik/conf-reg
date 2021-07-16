<script lang="ts">
	import api from "src/services/api.ts";
	import handleFetch from "src/services/handle-fetch.ts";
	import route from "src/services/route";
	import toast from "src/services/toast.ts";
	import {Button, Field, Input} from "svelma"

	let email: string = "";

	function forgotPassword() {
		api.forgotPassword(email)
			.then(handleFetch)
			.then(data => {
				if (data) toast.success('Success, email sent');
				else toast.danger('We could not find any record matching those details');
			})
			.catch(e => {})
	}
</script>


<div class="columns is-centered">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Forgot your password?</h1>
			<p class="is-size-7">Or did you want to
				<a class="has-text-primary" href on:click|preventDefault={route.auth.signIn}>Sign in</a> /
				<a class="has-text-primary" href on:click|preventDefault={route.auth.signUp}>Sign up</a>
			</p>
		</div>
		<div class="card-content has-background-white-bis is-clearfix">
			<Field label="e-mail" message="Enter your e-mail for further guidance">
				<Input bind:value={email}/>
			</Field>
			<Button class="is-primary is-pulled-right" on:click={forgotPassword}>Submit</Button>
		</div>
	</div>
</div>
