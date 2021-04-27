<?php


namespace App;


use App\Models\Option;
use App\Models\Spec;
use App\Models\Vehicle;
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

    public function parseVehicle()
    {
        $vehicles = $this->callApi();

        $this->removeOldVin($vehicles);

        foreach ($vehicles ?? [] as $vehicle){

            $vehicle_new= [
                'api_id' => $vehicle['id'],
                'uid' => $vehicle['uid'],
                'vin' => $vehicle['vin'],
                'make_and_model' => $vehicle['make-and-model'],
                'color' => $vehicle['color'],
                'transmission' => $vehicle['transmission'],
                'drive_type' => $vehicle['drive-type'],
                'fuel_type' => $vehicle['fuel-type'],
                'car_type' => $vehicle['car-type'],
                'doors' => $vehicle['doors'],
                'mileage' => $vehicle['mileage'],
                'kilometrage' => $vehicle['kilometrage'],
                'license_plate' => $vehicle['license-plate'],
            ];

            $options = $vehicle['car-options']['car-option'];
            $specs = $vehicle['specs']['spec'];

            if (!Vehicle::where('vin', $vehicle['vin'])->exists()){

                $car = Vehicle::create($vehicle_new);

                foreach ($options as $option){
                    Option::create([
                        'option' => $option,
                        'vehicle_id' => $car['id']
                    ]);
                }

                foreach ($specs as $spec){
                    Spec::create([
                        'spec' => $spec,
                        'vehicle_id' => $car['id']
                    ]);
                }
            }else{
                $car = Vehicle::update($vehicle_new);

                foreach ($options as $option){
                    Option::update([
                        'option' => $option,
                        'vehicle_id' => $car['id']
                    ]);
                }

                foreach ($specs as $spec){
                    Spec::update([
                        'spec' => $spec,
                        'vehicle_id' => $car['id']
                    ]);
                }
            }

        }

    }


    private function getVehicleJson($vehiclesObj)
    {
        return json_encode($vehiclesObj);
    }
    private function getVehicleArray($vehiclesJson)
    {
        return json_decode($vehiclesJson,TRUE)['object'];
    }

    public function removeOldVin($vehicles){
        foreach ($vehicles ?? [] as $vehicle) {
            if (!Vehicle::where('vin', $vehicle['vin'])->exists()) {
                $models = Vehicle::where('vin', '!=', $vehicle['vin'])->get();
                foreach ($models as $model){
                    Option::where('vehicle_id',$model['id'])->delete();
                    Spec::where('vehicle_id', $model['id'])->delete();
                    Vehicle::where('id', $model['id'])->delete();
                }
            }
        }
    }
}
