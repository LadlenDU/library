<?php

namespace app\core;

use app\helpers\Db;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class EntityModel extends EntityRepository
{
    public function __construct()
    {
        $metadata = new ClassMetadata($this->entityName());
        parent::__construct(Db::em(), $metadata);
    }

    /**
     * Возвращает название сущности БД.
     *
     * @return string
     */
    abstract public function entityName();
}