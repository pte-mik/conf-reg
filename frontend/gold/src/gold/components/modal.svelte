<script>
	export let full = false;
	let modal;
	$: { if (modal) document.body.appendChild(modal)}
</script>


<div class="modal is-active" class:full={full} bind:this={modal}>
	<div class="modal-background"></div>
	<div class="modal-content">
		<slot/>
	</div>
</div>

<style lang="scss">
	div.modal-background {
		background-color: #0009 !important;
		backdrop-filter: blur(4px);
	}

	.full {
		div.modal-content {
			min-width: calc(100vw - 60px);
			height: calc(100vh - 60px);
			width: auto;
			:global(.modal-card) {
				width: auto !important;
				height: 100%;
			}
		}
	}
</style>
