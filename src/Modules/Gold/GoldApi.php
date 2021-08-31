<?php namespace Application\Modules\Gold;

use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Carbon\ValidationError;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Route;

class GoldApi extends Api {

	/** @var GoldView[] */
	protected array $views = [];
	/** @var GoldSorting[] */
	protected array $sortings = [];
	/** @var Entity */
	protected string $entity;

	protected int $pagesize;
	protected bool $quicksearch;

	public function __construct() {
		$reflectionClass = new \ReflectionClass($this);
		$methods = $reflectionClass->getMethods();
		$this->entity = Gold::get($reflectionClass)->class;
		$this->pagesize = Gold::get($reflectionClass)->pagesize;
		$this->quicksearch = Gold::get($reflectionClass)->quicksearch;

		foreach ($methods as $method) {
			if (!is_null($view = GoldView::get($method))) {
				$view->method = $method->name;
				$this->views[$view->name] = $view;
			}
			if (!is_null($sorting = GoldSorting::get($method))) {
				$sorting->method = $method->name;
				$this->sortings[$sorting->name] = $sorting;
			}
		}
	}

	protected function view(string|null $view): Filter|null { return null; }
	protected function sorting(string|null $view): Filter|null { return null; }

	protected function listExport(Entity $item): array { return $item->export(); }
	protected function formExport(Entity $item): array { return $item->export(); }
	protected function updateItem(Entity $item, array $data) { $item->import($data)->save(); }
	protected function createItem(Entity $item, array $data) { $item->import($data)->save(); }
	protected function deleteItem(Entity $item) { $item->delete(); }
	protected function quickSearch(string $search) { return Filter::where("id=$1", $search); }

	// item routes

	#[Route("POST", '/create')]
	public function create() {
		$data = $this->data->get("item");
		$item = ($this->entity)::create();
		try {
			$this->createItem($item, $data);
		} catch (ValidationError $e) {
			$this->setStatusCode(Api::VALIDATION_ERROR);
			return $e->getMessages();
		}
		return $item->id;
	}

	#[Route("POST", '/update')]
	public function update() {
		$data = $this->data->get("item");
		$item = ($this->entity)::pick($data["id"]);
		if (is_null($item)) {
			$this->setStatusCode(404);
			return null;
		}
		try {
			$this->updateItem($item, $data);
		} catch (ValidationError $e) {
			$this->setStatusCode(Api::VALIDATION_ERROR);
			return $e->getMessages();
		}
		return $item->id;
	}

	#[Route("POST", '/delete')]
	public function delete() {
		$id = $this->data->get("id");
		$item = ($this->entity)::pick($id);
		if (is_null($item)) {
			$this->setStatusCode(404);
			return null;
		}
		try {
			$this->deleteItem($item);
		} catch (ValidationError $e) {
			$this->setStatusCode(Api::VALIDATION_ERROR);
			return $e->getMessages();
		}
		return $item->id;
	}

	#[Route("POST", '/get')]
	public function get() {
		$id = $this->data->get('id');
		$item = ($this->entity)::pick($id);
		if (is_null($item)) {
			$this->setStatusCode(404);
			return null;
		} else {
			return $this->formExport($item);
		}
	}

	#[Route("POST", '/blank')]
	public function blank() {
		return ($this->entity)::create()->export();
	}

	// list routes

	#[Route("POST", '/list/get')]
	public function listGet() {
		$pagesize = $this->data->get('pagesize');
		$page = $this->data->get('page');
		$view = $this->data->get('view');
		$sorting = $this->data->get('sorting');
		$quicksearch = $this->data->get('quicksearch');

		$method = is_null($view) ? null : $this->views[$view]->method;
		/** @var Filter $filter */
		$filter = is_null($method) ? null : $this->$method();

		if($quicksearch && $this->quicksearch){
			$quicksearch = $this->quickSearch($quicksearch);
			$filter = is_null($filter) ? $quicksearch : $filter->and($quicksearch);
		}

		if (!is_null($sorting)) {
			$dir = substr($sorting, 0, 1) === '+';
			$sorting = substr($sorting, 1);
			$method = is_null($sorting) ? null : $this->sortings[$sorting]->method;
		}
		$order = is_null($method) ? [] : $this->$method($dir);

		$items = ($this->entity)::search($filter)->order(...$order)->page($pagesize, $page, $count);
		if(count($items) === 0){
			$page = ceil($count/$pagesize);
			$items = ($this->entity)::search($filter)->order(...$order)->page($pagesize, $page, $count);
		}
		return ["items" => array_map(fn(Entity $item) => $this->listExport($item), $items), "count" => $count, "page" => $page];
	}

	#[Route("POST", '/list/options')]
	public function listOptions() {
		return [
			"quicksearch" => $this->quicksearch,
			"pagesize"    => $this->pagesize,
			"views"       => count($this->views) ? $this->views : null,
			"sortings"    => count($this->sortings) ? $this->sortings : null,
		];
	}

	// select

	#[Route("POST", "/select/search")]
	public function selectSearch(){
		$search = $this->data->get("search");
		$items = ($this->entity)::search($this->selectFilter($search))->collect();
		return array_map(fn($item)=>["key"=>$item->id, "value"=>$this->selectMap($item)], $items);
	}

	#[Route("POST", "/select/get")]
	public function selectGet(){
		$value = $this->data->get("value");
		$items = ($this->entity)::search(Filter::where(($this->entity)::id($value)))->collect();
		return array_map(fn($item)=>["key"=>$item->id, "value"=>$this->selectMap($item)], $items);
	}

	protected function selectFilter(string $search):Filter|null{
		return null;
	}

	protected function selectMap(Entity $item){
		return $item->id;
	}
}