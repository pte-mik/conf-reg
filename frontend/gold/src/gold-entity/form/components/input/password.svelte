<script lang="ts">
	import {Input} from "svelma"
	import type PasswordInput from "./password";
	import type EntityPage from "../../../form/form-page";
	export let page: EntityPage;
	export let control:PasswordInput;
	export let item;
	export let onChange: Function;
</script>

<Input type="password" size="is-small" bind:value={$item[control.field]} on:change={onChange} passwordReveal={true}/>
