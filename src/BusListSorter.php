<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/06/2017
 * Time: 15:27
 */

namespace CABDesigns\AlexaNextBus;


class BusListSorter
{
    public function sort(BusList $busList)
    {
        $indexedBuses = [];

        foreach($busList as $bus) {
            // obviously this will clobber values, but enough for
            // demo purposes.
            $indexedBuses[$bus->getTime()] = $bus;
        }

        ksort($indexedBuses);

        return new BusList($indexedBuses);
    }
}