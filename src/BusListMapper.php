<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/06/2017
 * Time: 15:04
 */

namespace CABDesigns\AlexaNextBus;


use Psr\Http\Message\ResponseInterface;

class BusListMapper
{
    public function map(ResponseInterface $response, BusList $list)
    {

        $r = json_decode($response->getBody(), true);

        foreach ($r['departures'] as $busNum => $bus) {
            foreach($bus as $departure) {
                $bus = new Bus($busNum, $departure['aimed_departure_time']);
                $list->append($bus);
            }
        }

    }
}