<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/06/2017
 * Time: 15:14
 */

namespace CABDesigns\AlexaNextBus;


use Nomisoft\Alexa\Response\AlexaResponse;
use Nomisoft\Alexa\Response\Card;
use Nomisoft\Alexa\Response\OutputSpeech;

class AlexaResponseMapper
{
    public function map(BusList $busList, AlexaResponse $response)
    {
        $speechStr = 'Bus times for LeedsPHP: ';
        $cardStr = '';

        foreach ($busList as $bus) {
            $speechStr .= $bus->getNumber() . ' at ' . $bus->getTime() . '. ';
            $cardStr .= $bus->getTime() . ' - ' . $bus->getNumber() . PHP_EOL;
        }

        $outputSpeech = new OutputSpeech();
        $outputSpeech->setSsml("<speak>" . $speechStr . "</speak>");
        $outputSpeech->setType("SSML");

        $card = new Card();
        $card->setType("Simple");
        $card->setTitle("Bus timetable");
        $card->setContent($cardStr);

        $response->setOutputSpeech($outputSpeech);
        $response->setCard($card);
    }
}