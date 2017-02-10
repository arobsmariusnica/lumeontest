<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;

class DoctorRepository implements RepositoryInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /** @return Doctor */
	public function selectById($id)
	{
        $entity = $this->doctrine
            ->getRepository('AppBundle:Doctor')
            ->find($id);

        return $entity;
	}
}