<script lang="ts">
	import Modal from "../../../elements/modal.svelte";
	import FormDoc from "../form/doc.ts";

	export let close;
	export let doc: FormDoc;
	export let file: Object = {};
	export let reload: Function = null;
	let modal: Modal;

	let safe, focus;

	if (file.safezone === null) {
		safe = {x: 10, y: 10, width: file.width - 20, height: file.height - 20}
	} else {
		let str = file.safezone;
		let len = str.length / 4;
		safe = {
			x: parseInt(str.substr(0, len), 36),
			y: parseInt(str.substr(len, len), 36),
			width: parseInt(str.substr(len * 2, len), 36),
			height: parseInt(str.substr(len * 3, len), 36),
		}
	}

	if (file.focus === null) {
		focus = {x: Math.ceil(file.width / 2), y: Math.ceil(file.height / 2)}
	} else {
		let str = file.focus;
		let len = str.length / 2;
		focus = {
			x: parseInt(str.substr(0, len), 36),
			y: parseInt(str.substr(len, len), 36)
		}
	}

	function reset() {
		safe = {x: 10, y: 10, width: file.width*scale - 20, height: file.height*scale - 20}
		focus = {x: Math.ceil(file.width*scale / 2), y: Math.ceil(file.height*scale / 2)}
	}

	function mousemove(event) {
		if (event.buttons === 0) dragged = false;
		if (!dragged) return;
		let x = event.clientX - containerDiv.getBoundingClientRect().x;
		let y = event.clientY - containerDiv.getBoundingClientRect().y;
		switch (dragged) {
			case 'bottomright':
				safe.width = Math.floor(Math.max(10, x - safe.x));
				safe.height = Math.floor(Math.max(10, y - safe.y));
				break;
			case 'topleft':
				safe.x = Math.floor(Math.min(file.width*scale - 10, Math.max(0, x)));
				safe.y = Math.floor(Math.min(file.height*scale - 10, Math.max(0, y)));
				break;
			case 'focus':
				focus.x = Math.floor(Math.min(file.width*scale, Math.max(0, x)));
				focus.y = Math.floor(Math.min(file.height*scale, Math.max(0, y)));
				break;
		}
		focus.x = Math.max(Math.min(focus.x, safe.x + safe.width), safe.x);
		focus.y = Math.max(Math.min(focus.y, safe.y + safe.height), safe.y);
		if ((safe.x + safe.width) > file.width*scale) safe.width = file.width*scale - safe.x;
		if ((safe.y + safe.height) > file.height*scale) safe.height = file.height*scale - safe.y;
	}

	let scale = 1;

	let dragged = null;
	let focusDiv;
	let topleftDiv;
	let bottomrightDiv;
	let containerDiv;

	function save() {
		let data = {
			safezone: Math.floor(safe.x/scale).toString(36).padStart(3, '0') + Math.floor(safe.y/scale).toString(36).padStart(3, '0') + Math.floor(safe.width/scale).toString(36).padStart(3, '0') + Math.floor(safe.height/scale).toString(36).padStart(3, '0'),
			focus: Math.floor(focus.x/scale).toString(36).padStart(3, '0') + Math.floor(focus.y/scale).toString(36).padStart(3, '0')
		};
		file.safezone = data.safezone;
		file.focus = data.focus;
		doc.class.fetcher.attachment.modify(doc.id, file.name, data).then(close).then(reload)
	}

	function imgloaded(){
		scale = containerDiv.getBoundingClientRect().width / file.width;
		focus.x *= scale;
		focus.y *= scale;
		safe.x *= scale;
		safe.y *= scale;
		safe.width *= scale;
		safe.height *= scale;
	}

</script>

<Modal bind:this={modal} icon="inverse far fa-image" title="Edit image focus">
	<nav slot="nav">
		<button on:click={reset}><i class="fas fa-crosshairs"></i></button>
		<button on:click={save}><i class="fas fa-times"></i></button>
	</nav>
	<main>
		<div on:mousemove={mousemove} bind:this={containerDiv} class="container">
			<img on:load={imgloaded} alt="" draggable="false" class="back" src={file.url}>
			<img alt="" style={"clip: rect(" + safe.y +"px, " + (safe.x + safe.width) +"px, "+(safe.y + safe.height)+"px, "+safe.x+"px)"} draggable="false" class="front" src={file.url} >
			<div class="frame" style={"top:"+safe.y+"px;" + "width:"+safe.width+"px;" + "height:"+safe.height+"px;" + "left:"+safe.x+"px;" }></div>
			<div on:mousedown={()=>dragged = 'topleft'} on:mouseup={()=>dragged=false} class="topleft" bind:this={topleftDiv} style={"top:"+(safe.y - 5)+"px;" + "left:"+(safe.x - 5)+"px;" }></div>
			<div on:mousedown={()=>dragged = 'bottomright'} on:mouseup={()=>dragged=false} class="bottomright" bind:this={bottomrightDiv} style={"top:"+(safe.y + safe.height - 5)+"px;" + "left:"+(safe.x + safe.width-5)+"px;" }></div>
			<div on:mousedown={()=>dragged = 'focus'} on:mouseup={()=>dragged=false} class="focus" bind:this={focusDiv} style={"top:"+(focus.y- 5)+"px;" + "left:"+(focus.x-5)+"px;" }></div>
		</div>
	</main>
</Modal>

<style lang="scss">
	@import "../../../style/mixins";
	@keyframes border-dance {
		0% { border-color: #000;}
		50% { border-color: #fff;}
		100% { border-color: #000;}
	}

	div.container {
		position: relative;
	}

	img.back {
		background-color: rgba(0,0,0,.5);
		max-width: 100%;
		filter: brightness(30%);
		user-select: none;
		display: block;
	}

	img.front {
		display: block;
		user-select: none;
		position: absolute;
		top: 0; left: 0;
		max-width: 100%;
	}
	div.frame {
		position: absolute;
		border-width: 1px;
		border-style: dashed;
		animation: border-dance 1s infinite linear;
	}
	div.topleft, div.bottomright, div.focus {
		width: 10px;
		height: 10px;
		background-color: #ff5900;
		border-radius: 5px;
		position: absolute;
		border-width: 1px;
		border-style: solid;
		animation: border-dance 1s infinite linear;
		cursor: move;
	}
	div.bottomright {
		cursor: nwse-resize;
	}
	div.focus {
		background-color: #00b7ff;
	}


	main {
		background-image: linear-gradient(45deg, #808080 25%, transparent 25%), linear-gradient(-45deg, #808080 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #808080 75%), linear-gradient(-45deg, transparent 75%, #808080 75%);
		background-size: 20px 20px;
		background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
		padding: 20px;
	}
</style>