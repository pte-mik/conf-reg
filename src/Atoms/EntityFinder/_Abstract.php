<?php namespace Application\Atoms\EntityFinder;
 use Atomino\Carbon\Finder;

 /**
  * Nobody uses this class, it exists only to help the code completion... waiting for generics...
  * @method \Application\Entity\Abstract[] collect( int|null $limit = null, int|null $offset = null, int|bool|null &$count = false)
  * @method \Application\Entity\Abstract[] page( int $size, int $page = 1, int|bool|null &$count = false )
  * @method \Application\Entity\Abstract pick()
  */ abstract class _Abstract extends Finder{}