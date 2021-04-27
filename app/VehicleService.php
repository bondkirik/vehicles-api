<?php


namespace App;


use GuzzleHttp\Client;

class VehicleService
{
    public function callApi()
    {
        $url = config('services.vehicle.url');

        $client = new Client([
            'base_uri' => 'http://localhost:8000', // <-- base_uri instead of base_url
        ]);

        $response = $client->request('GET', $url );

        if ($response->getStatusCode() !== 200){
            throw new Exception('There is a problem with random vehicle service');
        }

        $responseContents = $response->getBody()->getContents();
        $vehiclesObj = simplexml_load_string($responseContents);
        $vehiclesJson = $this->getVehicleJson($vehiclesObj);
        $vehicles = $this->getVehicleArray($vehiclesJson);

        return $vehicles ? $vehicles : null;

    }

    private function getVehicleJson($vehiclesObj)
    {
        return json_encode($vehiclesObj);
    }
    private function getVehicleArray($vehiclesJson)
    {
        return json_decode($vehiclesJson,TRUE)['object'];
    }
}
