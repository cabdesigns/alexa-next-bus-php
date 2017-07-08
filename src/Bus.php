<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/06/2017
 * Time: 15:00
 */

namespace CABDesigns\AlexaNextBus;


class Bus
{
    private $number;
    private $time;

    public function __construct($number, $time)
    {
        $this->number = $number;
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }
}