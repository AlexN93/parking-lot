<?php

namespace AppBundle\Handler;

use AppBundle\Entity\ParkingLot;
use AppBundle\Entity\Car;

class ParkingLotHandler
{
    private $commands;
    private $colors;

    private $parkingLot;

    public function __construct() {
        $this->commands = array(
            'create_parking_lot', // create_parking_lot 6
            'park', // park KA-01-HH-1234 White
            'leave', // leave 2
            'status', // status
            'registration_numbers_for_cars_with_colour', // registration_numbers_for_cars_with_colour White
            'slot_numbers_for_cars_with_colour', // slot_numbers_for_cars_with_colour White
            'slot_number_for_registration_number' // slot_number_for_registration_number KA-01-HH-1234
        );
        $this->colors = array('White','Black','Blue','Red','Yellow','Grey','Green','Purple','Orange','Silver','Gold');

        $this->parkingLot = null;
    }

    public function command($input) {
        $response = array(
            'success' => false,
            'message' => 'Invalid command'
        );
        $params = explode(' ', trim($input));

        if (in_array($params[0], $this->commands)) {
            switch ($params[0]) {
                case 'create_parking_lot':
                    $response = $this->createParkingLot($params, $response);
                    break;
                case 'park':
                    $response = $this->parkCar($params, $response);
                    break;
                case 'leave':
                    $response = $this->leaveParkingLot($params, $response);
                    break;
                case 'status':
                    $response = $this->getParkingLotStatus($params, $response);
                    break;
                case 'registration_numbers_for_cars_with_colour':
                    $response = $this->getRegNumberPerColor($params, $response);
                    break;
                case 'slot_numbers_for_cars_with_colour':
                    $response = $this->getSlotPerColor($params, $response);
                    break;
                case 'slot_number_for_registration_number':
                    $response = $this->getSlotPerRegNumber($params, $response);
                    break;
            }
        }
//        print_r($params);
        return $response;
    }

    private function createParkingLot($params, $response) {
        if (count($params) == 2 && $this->parkingLot == null) {
            if (is_int(intval($params[1]))) {
                $parkingLot = new ParkingLot();
                $parkingLot->setSpace($params[1]);
                $this->parkingLot = $parkingLot;
//                print_r($this->parkingLot);
                $response = array(
                    'success' => true,
                    'message' => 'Created a parking lot with '.$params[1].' slots'
                );
            }
        }

        return $response;
    }

    private function parkCar($params, $response) {
        if ($this->parkingLot != null && isset($params[1]) && isset($params[2])) {
            if (strlen($params[1]) > 12 && in_array($params[2], $this->colors)) {
                if (count($this->parkingLot->getCars()) < $this->parkingLot->getSpace()) {
                    $car = new Car();
                    $car->setNumber($params[1]);
                    $car->setColor($params[2]);
                    $car->setSlot($this->findEmptySlot());
                    $this->parkingLot->getCars()->add($car);
//                    print_r($car);
                    $response = array(
                        'success' => true,
                        'message' => 'Allocated slot number: ' . $car->getSlot()
                    );
                }
                else {
                    $response['message'] = 'Sorry, parking lot is full';
                }
            }
        }

        return $response;
    }

    private function leaveParkingLot($params, $response) {
        if (count($params) == 2) {
            if (is_int(intval($params[1])) && $params[1] <= count($this->parkingLot->getCars())) {
                $car = $this->findCarBySlot(intval($params[1]));
                if ($car != null) {
                    $this->parkingLot->removeCar($car);
                    $response = array(
                        'success' => true,
                        'message' => 'Slot number ' . $car->getSlot() . ' is free'
                    );
//                    print_r($this->parkingLot->getCars());
                }
                else {
                    $response['message'] = 'Parking slot is already empty';
                }
            }
        }

        return $response;
    }

    private function getParkingLotStatus($params, $response) {
        $table = "Slot No \t Registration No \t Color\n";
        if (count($params) == 1) {
            foreach ($this->parkingLot->getCars() as $car) {
                $table .= $car->getSlot() . "\t" . $car->getNumber() . "\t" . $car->getColor() . "\n";
            }
            $response = array(
                'success' => true,
                'message' => $table
            );
        }

        return $response;
    }

    private function getRegNumberPerColor($params, $response) {
        if (count($params) == 2) {
            $output = '';
            foreach ($this->parkingLot->getCars() as $car) {
                if ($car->getColor() == $params[1]) {
                    $output .= $car->getNumber() . ',';
                }
            }
            if (strlen($output) > 1) {
                $response = array(
                    'success' => true,
                    'message' => substr($output, 0, -1)
                );
            }
            else {
                $response = array(
                    'success' => true,
                    'message' => 'Not found'
                );
            }
        }
        return $response;
    }

    private function getSlotPerColor($params, $response) {
        if (count($params) == 2) {
            $output = '';
            foreach ($this->parkingLot->getCars() as $car) {
                if ($car->getColor() == $params[1]) {
                    $output .= $car->getSlot() . ',';
                }
            }
            if (strlen($output) > 1) {
                $response = array(
                    'success' => true,
                    'message' => substr($output, 0, -1)
                );
            }
            else {
                $response = array(
                    'success' => true,
                    'message' => 'Not found'
                );
            }
        }
        return $response;
    }

    private function getSlotPerRegNumber($params, $response) {
        if (count($params) == 2) {
            $output = '';
            foreach ($this->parkingLot->getCars() as $car) {
                if ($car->getNumber() == $params[1]) {
                    $output .= $car->getSlot() . ',';
                }
            }
            if (strlen($output) > 1) {
                $response = array(
                    'success' => true,
                    'message' => substr($output, 0, -1)
                );
            }
            else {
                $response = array(
                    'success' => true,
                    'message' => 'Not found'
                );
            }
        }
        return $response;
    }

    private function findCarBySlot($slot) {
        foreach ($this->parkingLot->getCars() as $car) {
            if($slot == $car->getSlot()) {
                return $car;
            }
        }
        return null;
    }

    private function findEmptySlot() {
        $slot = 1;
        $spaces = array_fill(0, $this->parkingLot->getSpace(), 0);
        foreach ($this->parkingLot->getCars() as $car) {
            $spaces[$car->getSlot() - 1] = 1;
        }
        foreach ($spaces as $key=>$space) {
            if ($space == 0) {
                $slot = $key + 1;
                return $slot;
            }
        }
        return $slot;
    }


}