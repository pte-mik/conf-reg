import {Modal} from "gold/modal-manager";
import type {IAttachmentApi} from "../interfaces";
import AttachmentModal from "./components/attachment-modal.svelte";
import type Form from "gold-entity/form/form";
import options from "../options";

export default function attachmentButton(api:IAttachmentApi, categories:{}){
	return {
		icon: options.attachment.button.icon,
		action: (form: Form) => {
			(new Modal(AttachmentModal, {categories, api, form})).open()
			//form.openModal(AttachmentModal, {categories, api})
		},
		onlyIfExists: true
	}
}