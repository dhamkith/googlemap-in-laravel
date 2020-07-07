<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Location;

class ApiRestaurantController extends Controller
{
 
  
    /**
     * get save locations data from database
     * 
     */
    public function mapMarker()
    { 
        $locations = Location::all();
        $map_markes = array ();
        foreach ($locations as $key => $location) { 
            $map_markes[] = (object)array(
                'location_title' => $location->location_title,
                'coords_lat' => $location->coords_lat,
                'coords_lng' => $location->coords_lng,
                'number' => $location->number,
                'location_email' => $location->location_email,
                'addressline1' => $location->addressline1,
                'addressline2' => $location->addressline2,
                'city' => $location->city,
                'country' => $location->country,
            );
        }
        return response()->json($map_markes);
    }
 

}
