import fs from "fs";

let entities = JSON.parse(fs.readFileSync("./entities.json"));

for (let entity in entities) if (entities.hasOwnProperty(entity)) {

	let imports = [];
	let enums = [];
	let fields = [];
	let file = entity.toLowerCase();

	for (let field in entities[entity]) if (entities[entity].hasOwnProperty(field)) {
		let desc = entities[entity][field];
		switch (typeof desc) {
			case "string":
				fields.push({field, type: desc});
				break;
			case "object":
				if (desc instanceof Array) {
					let e = entity + "_" + field.charAt(0).toUpperCase() + field.slice(1);
					enums.push({name: e, values: desc})
					fields.push({field, type: e});
				} else {
					fields.push({field, type: desc.type});
					if (typeof desc.default === "undefined") desc.default = true;
					imports.push(desc);
				}
		}
	}

	let shadowFile = "";
	if (imports.length) {
		for (let i of imports) {
			shadowFile += "import ";
			shadowFile += i.default ? i.type : "{" + i.type + "}";
			shadowFile += " from \"../" + i.from + "\";\n";
		}
		shadowFile += "\n";
	}
	if (enums.length) {
		for (let e of enums) {
			shadowFile += "export enum " + e.name + " {\n";
			for (let v of e.values) {
				shadowFile += "\t" + v + " = \"" + v + "\",\n";
			}
			shadowFile += "}\n\n";
		}
	}

	shadowFile += "export class " + entity + "Shadow implements " + entity + "DTO{\n";
	for (let field of fields) {
		shadowFile += "\tpublic " + field.field + " : " + field.type + " | null = null;\n";
	}
	shadowFile += "\n\tstatic create(data: " + entity + "DTO | object = {}) { return Object.assign(new this(), data);}\n\n"

	shadowFile += "\n\texport() : " + entity + "DTO {\n";
	shadowFile += "\t\treturn {\n";
	for (let field of fields) {
		shadowFile += "\t\t\t" + field.field + " : this." + field.field + ",\n";
	}

	shadowFile += "\t\t}\n";
	shadowFile += "\t}\n";

	shadowFile += "}\n\n";

	shadowFile += "export interface " + entity + "DTO{\n";
	for (let field of fields) {
		shadowFile += "\t" + field.field + " : " + field.type + " | null;\n";
	}
	shadowFile += "}\n";

	let entityFile = "";
	entityFile += "import {" + entity + "Shadow} from \"./shadow/" + file + "\";\n\n";
	entityFile += "export default class " + entity + " extends " + entity + "Shadow{\n\n}\n";

	fs.writeFileSync("./entities/shadow/" + file + ".ts", shadowFile);
	if (!fs.existsSync("./entities/" + file + ".ts")) fs.writeFileSync("./entities/" + file + ".ts", entityFile);
}