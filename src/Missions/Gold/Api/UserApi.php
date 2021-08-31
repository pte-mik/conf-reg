<?php namespace Application\Missions\Gold\Api;

use Application\Entity\User;
use Application\Modules\Gold\Gold;
use Application\Modules\Gold\GoldApi;
use Application\Modules\Gold\GoldSorting;
use Application\Modules\Gold\GoldView;
use Atomino\Bundle\Attachment\AttachmentableInterface;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Plugins\Attachment\Attachmentable;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Route;
use function Atomino\debug;

#[Gold(User::class, 5, true)]
class UserApi extends GoldApi {

	protected function selectFilter(string $search):Filter|null{
		return Filter::where(User::name()->instring($search))->or(User::email()->instring($search));
	}
	/**
	 * @param User $item
	 * @return array
	 */
	protected function selectMap(Entity $item){
		return $item->name;
	}

	protected function formExport(Entity $item): array {
		$data = $item->export();
		$data['password'] = "";
		return $data;
	}

	/**
	 * @param User $item
	 * @param array $data
	 */
	protected function updateItem(Entity $item, array $data) {
		if($data['password'] === "") unset($data['password']);
		else $item->setPassword($data["password"]);
		parent::updateItem($item, $data);
	}

	protected function quickSearch(string $search) {
		return Filter::where(User::name()->instring($search))
		             ->or(User::email()->instring($search))
		             ->or(User::id($search));
	}

	#[Route(Api::POST, '/attachment/get')]
	public function getAttachments(){
		$id = $this->data->get('id');
		/** @var AttachmentableInterface $item */
		$item = ($this->entity)::pick($id);

		$attachments = $item->getAttachmentStorage()->attachments;
		$collectionNames = array_keys($item->getAttachmentStorage()->collections);
		$collections = [];
		$files = [];
		foreach ($collectionNames as $collectionName){
			$collections[$collectionName] = $item->getAttachmentStorage()->getCollection($collectionName)->files;
		}
		foreach ($attachments as $attachment){
			$file = $attachment->jsonSerialize();
			$file['name'] = $attachment->filename;
			$file['url'] = $attachment->url;
			if($attachment->isImage){
				$file['isImage'] = true;
				$file['thumbnail'] = $attachment->image->crop(240,180)->webp;
			}else{
				$file['isImage'] = false;
			}
			$files[$attachment->filename] = $file;
		}
		return [
			'collections'=>$collections,
			'files'=>$files
		];
	}

	#[GoldView('*', '-')]
	protected function allView(): Filter|null {
		return null;
	}

	#[GoldView('banned', '20nál nagyobb userek')]
	protected function bannedView(): Filter|null {
		return Filter::where(User::id()->gt(20));
	}

	#[GoldSorting('name', 'név')]
	protected function nameSorting(bool $asc) {
		if ($asc) {
			return [[User::name, "asc"]];
		} else {
			return [[User::name, "desc"]];
		}
	}

	#[GoldSorting('email', 'e-mail')]
	protected function emailSorting(bool $asc) {
		if ($asc) {
			return [[User::email, "asc"]];
		} else {
			return [[User::email, "desc"], [User::name, "asc"]];
		}
	}
}

