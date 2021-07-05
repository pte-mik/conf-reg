export class EventShadow implements EventDTO{
	public id : number | null = null;
	public title : string | null = null;
	public subtitle : string | null = null;
	public name : string | null = null;

	static create(data: EventDTO | object = {}) { return Object.assign(new this(), data);}


	export() : EventDTO {
		return {
			id : this.id,
			title : this.title,
			subtitle : this.subtitle,
			name : this.name,
		}
	}
}

export interface EventDTO{
	id : number | null;
	title : string | null;
	subtitle : string | null;
	name : string | null;
}
