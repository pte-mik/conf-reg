<script lang="ts">
	import {Button} from "svelma";

	let fileupload;
	export let onFileSelect;
	function upload(event) { onFileSelect(fileupload.files[0]);}
</script>

<Button iconPack="fas" iconLeft="upload" class="is-size-7" on:click={()=>fileupload.click()}>upload image</Button>
<input class="is-hidden" type="file" on:change={upload} bind:this={fileupload}>