<script lang="ts">
	import Page from "gold/page";
	export let page:Page;
	let title = page.$title;
</script>

<div class="box">
	This is the dashboard {$title}
</div>

