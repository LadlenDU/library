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
        /*$em = $this->getEntityManager();


        $em->select
        $qb->expr()->in(
            'o.id',
            $qb2->select('o2.id')
                ->from('Order', 'o2')
                ->join('Item',
                    'i2',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    $qb2->expr()->andX(
                        $qb2->expr()->eq('i2.order', 'o2'),
                        $qb2->expr()->eq('i2.id', '?1')
                    )
                )
                ->getDQL()
        )*/

        //SELECT IF(MAX(field_to_increment) IS NULL, 1, MAX(field_to_increment) + 1) FROM table t)

        $this->createQueryBuilder('p')
            ->insert('Publisher')
            ->values(
                array(
                    'name' => ':name',
                )
            )
            ->setParameter('name', $name)
        ;

/*        $qb = $this->createQueryBuilder('p');
        $qb->ins
        $ttt = $qb->select('IF(MAX(p.id) IS NULL, 1, MAX(p.id) + 1)')
        ->getDQL();*/

            /*->where('u.id = :id')
            ->setParameter('id', $uId)
            ->getQuery()
            ->getOneOrNullResult();*/

        /*$publisher = new \Entities\Publisher();
        $publisher->setName($name);
        $this->getEntityManager()->persist($publisher);
        $this->getEntityManager()->flush();

        $qb = $this->createQueryBuilder('p')->i*/
    }

    public function getPublishers()
    {
        $res = $this->findAll();
        return $res;
    }
}
