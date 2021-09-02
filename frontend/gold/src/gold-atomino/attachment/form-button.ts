import {Modal} from "gold/modal-manager";
import {get} from "svelte/store";
import type {IAttachmentApi} from "../interfaces";
import AttachmentModal from "./components/attachment-modal.svelte";
import type Form from "gold-entity/form/form";
import options from "../options";

export default function attachmentButton(api:IAttachmentApi, visibleCollections:any){
	for(let i in visibleCollections)if(visibleCollections.hasOwnProperty(i)){
		if(typeof visibleCollections[i] === 'string'){
			visibleCollections[i] = {label:visibleCollections[i]}
		}
		if(typeof visibleCollections[i].props === 'undefined'){
			visibleCollections[i].props = [];
		}
	}

	return {
		icon: options.attachment.button.icon,
		action: (form: Form) => {
			(new Modal(AttachmentModal, {visibleCollections, api, id:get(form.$item).id})).open()
		},
		onlyIfExists: true
	}
}
