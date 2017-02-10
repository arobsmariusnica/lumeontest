<?php
/**
 * Created by PhpStorm.
 * User: marius.nica
 * Date: 2/10/2017
 * Time: 12:18
 */

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Patient;

class PatientService
{
    private $entityManager;

    /**
     * PacientService constructor.
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * Save Patient
     *
     * @param $em
     * @param $doctor
     * @param $hospital
     * @param array $pacientValues
     * @return Patient
     */
    public function save($doctor, $hospital, $pacientValues)
    {
        //save patient against doctor and hospital
        $patient = $this->getPatient();
        $patient->setDoctor($doctor);
        $patient->setHospital($hospital);
        $patient->setName($pacientValues['name']);
        $patient->setGender($pacientValues['gender']);
        $patient->setDob(new \DateTime($pacientValues['dob']));

        $this->getEntityManager()->persist($patient);
        $this->getEntityManager()->flush();

        return $patient;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getPatient()
    {
        return new Patient();
    }
}