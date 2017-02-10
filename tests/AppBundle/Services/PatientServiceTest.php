<?php

namespace AppBundle\Tests\Services;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Services\PatientService;

class PatientServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testSave()
    {
        $doctor = $this->getMockBuilder(Doctor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hospital = $this->getMockBuilder(Hospital::class)
            ->disableOriginalConstructor()
            ->getMock();

        $patient = new Patient();
        $patient->setName('John Doe');
        $patient->setGender('male');

        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $patientService = $this
            ->getMockBuilder(PatientService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPacient', 'getEntityManager'])
            ->getMock();
        $patientService->expects($this->any())
            ->method('getPacient')
            ->will($this->returnValue($patient));
        $patientService->expects($this->any())
            ->method('getEntityManager')
            ->will($this->returnValue($entityManager));

        $patient = $patientService->save(
            $doctor,
            $hospital,
            array(
                "hospital_id"      => 1,
                "doctor_id"        => 1,
                "name"             => "John Doe",
                "gender"           => Patient::GENDER_MALE,
                "dob"              => '1980-02-03 09:30:00'
            )
        );

        $this->assertEquals('John Doe', $patient->getName());
        $this->assertEquals(Patient::GENDER_MALE, $patient->getGender());
    }
}
