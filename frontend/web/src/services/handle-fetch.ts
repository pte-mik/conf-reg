import toast from "../elements/toast";

export default function handleFetch(res: Response) {
	switch (res.status) {
		case 200:
			return res.json();
		case 401:
			toast.danger('Unauthenticated');
			throw {code: 401}
		case 403:
			toast.danger('Has no permission');
			throw {code: 403}
		case 404:
			toast.danger('Item not found');
			throw {code: 404}
		case 422:
			return res.json().then((messages:Array<Message>) => {
				let output:any = {};
				for (let message of messages) output[message.field] = message.message;
				for (let field in output) if(output.hasOwnProperty(field)) toast.danger('Validation error: ' + field + '<div class="is-size-7">'+ output[field] +'</div>');
				throw {code: 422, messages: output}
			});
		default:
			throw {code: res.status};
	}
}

interface Message{
	field:string;
	message:string;
}