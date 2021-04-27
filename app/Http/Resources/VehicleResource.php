<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'api_id' => $this->api_id,
            'uid' => $this->uid,
            'vin' => $this->vin,
            'make_and_model' => $this->make_and_model,
            'color' => $this->color,
            'transmission' => $this->transmission,
            'drive_type' => $this->drive_type,
            'fuel_type' => $this->fuel_type,
            'car_type' => $this->car_type,
            'doors' => $this->doors,
            'mileage' => $this->mileage,
            'kilometrage' => $this->kilometrage,
            'license_plate' => $this->license_plate,
            'created_at' => $this->created_at,
            'options' => OptionResource::collection($this->options),
            'specs' => SpecResource::collection($this->specs),

        ];
    }
}
