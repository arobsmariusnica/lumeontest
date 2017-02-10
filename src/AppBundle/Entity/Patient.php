<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="patient")
 */
class Patient
{
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;
	const GENDER_OTHER = 3;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=100)
     */
	public $name;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
	private $dob;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=10)
     */
	private $gender;

    /**
     * @ORM\ManyToOne(targetEntity="Doctor", inversedBy="pacients")
     * @ORM\JoinColumn(name="doctor_id", referencedColumnName="id")
     */
	private $doctor;

    /**
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="pacients")
     * @ORM\JoinColumn(name="hospital_id", referencedColumnName="id")
     */
    private $hospital;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Patient
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Patient
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDob()
	{
		return $this->dob;
	}

	/**
	 * @param \DateTime $dob
	 * @return Patient
	 */
	public function setDob($dob)
	{
		$this->dob = $dob;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * @param string $gender
	 * @return Patient
	 */
	public function setGender($gender)
	{
		$this->gender = $gender;
		return $this;
	}

	/**
	 * @return Hospital
	 */
	public function getHospital()
	{
		return $this->hospital;
	}

	/**
	 * @param Hospital $hospital
	 * @return Patient
	 */
	public function setHospital($hospital)
	{
		$this->hospital = $hospital;
		return $this;
	}

    /**
     * @return Hospital
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * @param Doctor $doctor
     * @return Patient
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;
        return $this;
    }


}
