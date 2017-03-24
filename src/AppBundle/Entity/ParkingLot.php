<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ParkingLot
 *
 * @ORM\Table(name="parking_lot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParkingLotRepository")
 */
class ParkingLot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="space", type="integer", nullable=false)
     * @Assert\NotNull()
     */
    private $space;

    /**
     * @ORM\OneToMany(targetEntity="Car", mappedBy="parkingLot")
    */
    private $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set space
     *
     * @param integer $space
     *
     * @return ParkingLot
     */
    public function setSpace($space)
    {
        $this->space = $space;

        return $this;
    }

    /**
     * Get space
     *
     * @return int
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * Get cars
     *
     * @return ArrayCollection
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * Remove a car
     *
     */
    public function removeCar($car)
    {
        return $this->cars->removeElement($car);
    }
}

