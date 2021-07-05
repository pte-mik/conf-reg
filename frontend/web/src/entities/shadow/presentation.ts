export enum Presentation_Status {
	draft = "draft",
	submitted = "submitted",
	declined = "declined",
	accepted = "accepted",
	modified = "modified",
}

export class PresentationShadow implements PresentationDTO{
	public id : number | null = null;
	public eventId : number | null = null;
	public category : string | null = null;
	public imageCaption : string | null = null;
	public keywords : Array<string> | null = null;
	public abstract : string | null = null;
	public status : Presentation_Status | null = null;
	public authors : Array<any> | null = null;

	static create(data: PresentationDTO | object = {}) { return Object.assign(new this(), data);}


	export() : PresentationDTO {
		return {
			id : this.id,
			eventId : this.eventId,
			category : this.category,
			imageCaption : this.imageCaption,
			keywords : this.keywords,
			abstract : this.abstract,
			status : this.status,
			authors : this.authors,
		}
	}
}

export interface PresentationDTO{
	id : number | null;
	eventId : number | null;
	category : string | null;
	imageCaption : string | null;
	keywords : Array<string> | null;
	abstract : string | null;
	status : Presentation_Status | null;
	authors : Array<any> | null;
}
