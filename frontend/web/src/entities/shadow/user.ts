export enum User_Group {
	admin = "admin",
	user = "user",
}

export class UserShadow implements UserDTO{
	public id : number | null = null;
	public name : string | null = null;
	public email : string | null = null;
	public group : User_Group | null = null;
	public address : string | null = null;
	public phone : string | null = null;
	public institute : string | null = null;

	static create(data: UserDTO | object = {}) { return Object.assign(new this(), data);}


	export() : UserDTO {
		return {
			id : this.id,
			name : this.name,
			email : this.email,
			group : this.group,
			address : this.address,
			phone : this.phone,
			institute : this.institute,
		}
	}
}

export interface UserDTO{
	id : number | null;
	name : string | null;
	email : string | null;
	group : User_Group | null;
	address : string | null;
	phone : string | null;
	institute : string | null;
}
