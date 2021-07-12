<script lang="ts">
	import {replace} from "svelte-spa-router";
	import handleFetch from "../services/handle-fetch.ts";
	import api from "../services/api.ts";

	import toast from "../elements/toast.ts";
	import Field from "svelma/src/components/Field.svelte"
	import Input from "svelma/src/components/Input.svelte"
	import Button from "svelma/src/components/Button.svelte"

	let name: string = '';
	$: name_input_message = name.length > 3 ? "" : "required"
	let email: string = '';
	let password: string = '';
	let phone: string = '';
	let country: string = '';
	let address: string = '';
	let institute: string = '';
	let city: string = '';
	let zip: string = '';
	let vat: string = '';

	function validateEmail(email) {
		const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	}
	function validatePassword(password) {
		const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8})/;
		return re.test(password);
	}

	function signUp() {
		api.signUp(name, email, password, phone)
			.then(handleFetch)
			.then(res => {
				toast.success('Account created');
				replace("/sign-in");
			})
			.catch(e => {})
	}

</script>


<div class="columns is-centered">
	<div class="form column is-one-third card is-paddingless has-background-black-ter">
		<div class="card-content has-text-white">
			<h1 class="is-size-5 has-text-weight-bold">Sign up</h1>
			<p class="is-size-7">Already have an account? <a class="has-text-primary" href on:click|preventDefault={()=>replace('/sign-in')}>Sign in</a></p>
		</div>
		<div class="card-content has-background-white-bis is-clearfix">
			<div class="columns">
				<div class="column">
<!--					<div class="divider">Account</div>-->
					<Field label="name" message={name.length > 3 ? "" : "required (must be at least 4 characters long)"}>
						<Input bind:value={name}/>
					</Field>

					<Field label="e-mail" message={validateEmail(email) ? "" : "must be a valid email address"}>
						<Input type="email" bind:value={email}/>
					</Field>
					<Field label="password" message={validatePassword(password) ? "": "must be at least 8 characters long, must contain letters in mixed case and must contain numbers"}>
						<Input type="password" bind:value={password} passwordReveal={true}/>
					</Field>
					<Field label="phone">
						<Input bind:value={phone}/>
					</Field>
				</div>
<!--				<div class="column">-->
<!--					<div class="divider">Billing information</div>-->
<!--					<Field label="institute" message={institute.length > 3 ? "" : "required (must be at least 4 characters long)"}>-->
<!--						<Input bind:value={institute}/>-->
<!--					</Field>-->
<!--					<Field label="country" message={country.length > 3 ? "" : "required (must be at least 4 characters long)"}>-->
<!--						<Input bind:value={country}/>-->
<!--					</Field>-->
<!--					<Field label="zip" message={zip.length > 3 ? "" : "required (must be at least 4 characters long)"}>-->
<!--						<Input bind:value={zip}/>-->
<!--					</Field>-->
<!--					<Field label="address" message={address.length > 3 ? "" : "required (must be at least 4 characters long)"}>-->
<!--						<Input bind:value={address}/>-->
<!--					</Field>-->
<!--					<Field label="vat" message={vat.length > 3 ? "" : "required (must be at least 4 characters long)"}>-->
<!--						<Input bind:value={vat}/>-->
<!--					</Field>-->
<!--				</div>-->
			</div>


			<Button class="is-primary is-pulled-right" on:click={signUp}>Sign Up</Button>
		</div>
		<div class="card-content has-background-black-ter has-text-centered has-text-warning is-size-7 has-text-weight-bold">
			By proceeding, I agree with the terms and conditions and the privacy policy
		</div>
	</div>
</div>