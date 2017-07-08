<?php

require_once 'vendor/autoload.php';

use Nomisoft\Alexa\Response\AlexaResponse;
use CABDesigns\AlexaNextBus\TransportAPI;
use CABDesigns\AlexaNextBus\BusList;
use CABDesigns\AlexaNextBus\BusListMapper;
use CABDesigns\AlexaNextBus\BusListSorter;
use CABDesigns\AlexaNextBus\AlexaResponseMapper;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$dotenv->required('ATCO_CODES')->notEmpty();
$dotenv->required('SKILL_ID')->notEmpty();
$dotenv->required('TRANSPORT_API_APP_KEY')->notEmpty();
$dotenv->required('TRANSPORT_API_APP_ID')->notEmpty();

$transportApi = new TransportAPI(new Client(), $_ENV['TRANSPORT_API_APP_ID'], $_ENV['TRANSPORT_API_APP_KEY']);
$atcoCodes = json_decode($_ENV['ATCO_CODES']);

$promises = $transportApi->fetchNextBuses($atcoCodes);

Promise\all($promises)->then(function (array $httpResponses) {

    $busList = new BusList();
    $busListMapper = new BusListMapper();

    // Map our API responses to a list of buses
    foreach ($httpResponses as $httpResponse) {
        $busListMapper->map($httpResponse, $busList);
    }

    // Sort the buses
    $busList = (new BusListSorter())->sort($busList);

    // Limit the buses
    $busList = new BusList(array_slice($busList->getArrayCopy(), 0, 3));

    // Generate an alexa response from the list of buses
    $alexaResponseMapper = new AlexaResponseMapper();
    $alexaResponse = new AlexaResponse();
    $alexaResponseMapper->map($busList, $alexaResponse);
    $alexaResponse->render();

})->wait();