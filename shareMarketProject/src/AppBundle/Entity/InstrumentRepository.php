<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InstrumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InstrumentRepository extends EntityRepository
{
    public function checkData()
    {
        echo "hello";
    }
}
