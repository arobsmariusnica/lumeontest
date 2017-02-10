<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="doctor")
 */
class Doctor
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
	private $name;

    /**
     * @ORM\OneToMany(targetEntity="Patient", mappedBy="doctor")
     */
    private $patients;

    /**
     * Doctor constructor.
     */
    public function __construct()
    {
        $this->patients = ArrayCollection();
    }

    /**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return Patient
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return Patient
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

    /**
     * @return Patient
     */
    public function getPatients()
    {
        return $this->patients;
    }
}
