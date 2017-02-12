<?php

namespace app\models;

use app\core\Web;
use app\core\EntityModel;

/**
 * Publisher модель издательства.
 *
 * @package app\models
 */
class Publisher extends EntityModel
{
    public function entityName()
    {
        return '\\Entities\\Publisher';
    }

    public function addPublisher($name)
    {
        $publisher = new \Entities\Publisher();
        $publisher->setName($name);
        $this->getEntityManager()->persist($publisher);
        $this->getEntityManager()->flush();
    }

    public function getPublishers()
    {
        $res = $this->findAll();
        return $res;
    }
}
