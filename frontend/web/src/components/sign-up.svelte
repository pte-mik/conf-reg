<script lang="ts">
	import {replace} from "svelte-spa-router";
	import handleFetch from "../services/handle-fetch.ts";
	import api from "../services/api.ts";

	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"

	let name: string = '';
	let email: string = '';
	let password: string = '';
	let phone: string = '';
	let country: string = '';
	let address: string = '';
	let institute: string = '';
	let city: string = '';
	let zip: string = '';

	function signUp() {
		api.signUp(name, email, password, phone, country, city, zip, address, institute)
			.then(handleFetch)
			.then(res => {
				toast.success('Account created');
				replace("/sign-in");
			})
			.catch(e => {})
	}

</script>


<div class="columns is-centered">
	<div class="form column is-two-thirds card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Sign up</h1>
			<p class="is-size-7">Already have an account? <a class="has-text-primary" href on:click|preventDefault={()=>replace('/sign-in')}>Sign in</a></p>
		</div>
		<div class="card-content has-background-white-bis is-clearfix">
			<div class="columns">
				<div class="column">
					<Field label="name">
						<Input bind:value={name}/>
					</Field>
					<Field label="institute">
						<Input bind:value={institute}/>
					</Field>
					<Field label="e-mail">
						<Input type="email" bind:value={email}/>
					</Field>
					<Field label="password">
						<Input type="password" bind:value={password} passwordReveal={true}/>
					</Field>
				</div>
				<div class="column">
					<Field label="phone">
						<Input bind:value={phone}/>
					</Field>
					<Field label="country">
						<Input bind:value={country}/>
					</Field>
					<Field label="zip">
						<Input bind:value={zip}/>
					</Field>
					<Field label="address">
						<Input bind:value={address}/>
					</Field>
				</div>
			</div>


			<Button class="is-primary is-pulled-right" on:click={signUp}>Sign Up</Button>
		</div>
		<div class="card-content has-background-black-ter has-text-centered has-text-warning is-size-7 has-text-weight-bold">
			By proceeding, I agree with the terms and conditions and the privacy policy
		</div>
	</div>
</div>