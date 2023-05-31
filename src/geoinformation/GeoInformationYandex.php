<?php

namespace TaskForce\geoinformation;

use Geocoder\Location;
use Geocoder\Provider\Yandex\Yandex;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use Geocoder\StatefulGeocoder;
use GuzzleHttp\Client;
use Yii;

class GeoInformationYandex
{
    private Location $coordinates;
    private Client $httpClient;
    private string $apiKey;
    private Yandex $provider;
    private StatefulGeocoder $geocoder;
    public ?string $city;
    public ?string $street;
    public ?string $buildingNumber;
    public Location $fullAddress;
    public ?float $latitude;
    public ?float $longitude;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->apiKey = Yii::$app->params['apiKeyGeocode'];
        $this->provider = new Yandex($this->httpClient, null, $this->apiKey);
        $this->geocoder = new StatefulGeocoder($this->provider, 'ru-RU');
    }

    public function setCoordinates(float $latitude, float $longitude)
    {

        $respondAddress = $this->geocoder->reverseQuery(ReverseQuery::fromCoordinates($latitude, $longitude));
        $this->fullAddress = $respondAddress->get(0);
        $this->city = $respondAddress->get(0)->getLocality();
        $this->street = $respondAddress->get(0)->getStreetName();
        $this->buildingNumber = $respondAddress->get(0)->getStreetNumber();
    }

    public function setAddress(string $address)
    {
        $respondCoordinates = $this->geocoder->geocodeQuery(GeocodeQuery::create($address));
        $this->coordinates = $respondCoordinates->get(0);
        $this->longitude = $respondCoordinates->get(0)->getCoordinates()->getLongitude();
        $this->latitude = $respondCoordinates->get(0)->getCoordinates()->getLatitude();
    }

}
