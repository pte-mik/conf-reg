<script lang="ts">
	import Modal from "gold-admin/app/components/modal.svelte";
	import toast from "gold-admin/toast";
	import Ajv from "ajv";

	export let onSave:Function;
	export let modal;
	export let data:any;
	export let schema:any;
	let dataString = JSON.stringify(data,null,2);

	function save(){
		try {
			let data = JSON.parse(dataString);
			const ajv = new Ajv()
			let validate = ajv.compile(schema)

			if (validate(data)) {
				let message = onSave(data)
				if(message === true){
					modal.close();
				}else{
					toast.danger(message);
				}
			}else{
				console.log(validate.errors)
				for (let error of validate.errors) {
					toast.danger(error.instancePath + ' ' + error.message)
				}
			}
		}catch (e){
			toast.danger('Could not parse JSON data')
		}
	}
</script>

<Modal>
	<div class="modal-card">
		<header class="modal-card-head p-3 px-4">
			<p class="modal-card-title is-size-6 has-text-weight-bold">Json Editor</p>
			<button class="delete" aria-label="close" on:click={()=>modal.close()}></button>
		</header>
		<section class="modal-card-body has-background-black-bis m-0 p-2">
			<textarea class="input is-size-7 has-text-weight-bold" bind:value={dataString} />
		</section>
		<footer class="modal-card-foot is-justify-content-center p-2">
			<button class="button is-primary is-size-7" on:click={()=>{save()}}>Save</button>
			<button class="button is-danger is-size-7" on:click={()=>modal.close()}>Close</button>
		</footer>
	</div>
</Modal>

<style lang="scss">
	textarea{
		min-height: 300px;
		font-family: "Courier New", monospace;
	}
</style>
