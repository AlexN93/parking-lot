<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
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
     * @var string
     *
     * @ORM\Column(name="number", type="string", nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", nullable=false)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="slot", type="integer", nullable=false)
     * @Assert\NotNull()
     */
    private $slot;

    /**
     * @ORM\ManyToOne(targetEntity="ParkingLot", inversedBy="cars")
     */
    public $parkingLot;


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
     * Set number
     *
     * @param string $number
     *
     * @return Car
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Car
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get slot
     *
     * @return int
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * Set slot
     *
     * @param integer $slot
     *
     * @return ParkingLot
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;

        return $this;
    }
}

