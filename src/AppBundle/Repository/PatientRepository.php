<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Patient;

class PatientRepository implements RepositoryInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

	/** @return Patient */
    public function selectById($id)
    {
        $entity = $this->doctrine
            ->getRepository('AppBundle:Patient')
            ->find($id);

        return $entity;
    }

	/**
	 * @param \AppBundle\Entity\Hospital $hospital
	 * @return Patient[]
	 */
	public function selectByHospital($hospital)
    {
        return $hospital->getPacients();
    }
}