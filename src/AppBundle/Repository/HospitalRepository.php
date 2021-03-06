<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Hospital;

class HospitalRepository implements RepositoryInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /** @return Hospital */
	public function selectById($id)
	{
        $entity = $this->doctrine
            ->getRepository('AppBundle:Hospital')
            ->find($id);

        return $entity;
	}
}