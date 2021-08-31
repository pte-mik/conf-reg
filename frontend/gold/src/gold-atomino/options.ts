import type {IOptions} from "./interfaces";
import FaIcon from "gold/fa-icon";

let options: IOptions = {
	attachment: {
		button: {icon: FaIcon.s("folder-upload")},
		modal:{
			upload: {icon: FaIcon.s("folder-upload")}
		}
	}
};

export default options;
