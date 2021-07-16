// @ts-ignore
import Toast from "svelma/src/components/Toast/index.js"

export default {
	success: (message:string)=>Toast.create({message, type:"is-success", position: "is-bottom-right"}),
	white: (message:string)=>Toast.create({message, type:"is-white", position: "is-bottom-right"}),
	black: (message:string)=>Toast.create({message, type:"is-black", position: "is-bottom-right"}),
	light: (message:string)=>Toast.create({message, type:"is-light", position: "is-bottom-right"}),
	primary: (message:string)=>Toast.create({message, type:"is-primary", position: "is-bottom-right"}),
	info: (message:string)=>Toast.create({message, type:"is-info", position: "is-bottom-right"}),
	warning: (message:string)=>Toast.create({message, type:"is-warning", position: "is-bottom-right"}),
	danger: (message:string)=>Toast.create({message, type:"is-danger", position: "is-bottom-right"})
}
