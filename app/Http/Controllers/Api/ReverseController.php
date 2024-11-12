<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Place;
use App\Services\NominatimService;
use Illuminate\Http\Request;

class ReverseController extends Controller
{
    protected $service;

    public function __construct(NominatimService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $lat = round($request->lat, 2);
            $lon = round($request->lon, 2);

            $place = Place::where('lat', 'like', '%' . $lat . '%')
                ->orWhere('lon', 'like', '%' . $lon . '%')
                ->with('address')
                ->first();

            if ($place) {
                return ResponseFormatter::success($place);
            }

            $nominatimQuery = [
                'format' => 'json',
                'lat' => $lat,
                'lon' => $lon,
                'addressdetails' => 1,
                'limit' => 1,
            ];

            $result = $this->service->get('/reverse', $nominatimQuery);

            if ($result) {

                $place = Place::updateOrCreate(
                    ['place_id' => $result['place_id']],
                    [
                        'licence' => $result['licence'] ?? null,
                        'osm_type' => $result['osm_type'] ?? null,
                        'osm_id' => $result['osm_id'] ?? null,
                        'lat' => $result['lat'] ?? null,
                        'lon' => $result['lon'] ?? null,
                        'type' => $result['type'] ?? null,
                        'place_rank' => $result['place_rank'] ?? null,
                        'importance' => $result['importance'] ?? null,
                        'addresstype' => $result['addresstype'] ?? null,
                        'name' => $result['name'] ?? null,
                        'display_name' => $result['display_name'] ?? null,
                    ]
                );

                if (isset($result['address'])) {
                    $place->address()->updateOrCreate(
                        ['place_id' => $place->id],
                        [
                            'village' => $result['address']['village'] ?? null,
                            'borough' => $result['address']['borough'] ?? null,
                            'county' => $result['address']['county'] ?? null,
                            'city' => $result['address']['city'] ?? null,
                            'state' => $result['address']['state'] ?? null,
                            'postcode' => $result['address']['postcode'] ?? null,
                            'country' => $result['address']['country'] ?? null,
                            'country_code' => $result['address']['country_code'] ?? null,
                            'neighbourhood' => $result['address']['neighbourhood'] ?? null,
                            'road' => $result['address']['road'] ?? null,
                            'shop' => $result['address']['shop'] ?? null,
                            'suburb' => $result['address']['suburb'] ?? null,
                            'historic' => $result['address']['historic'] ?? null,
                        ]
                    );
                }

                return ResponseFormatter::success($result);
            }

            return ResponseFormatter::error('No results found for the given coordinates.');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 404);
        }
    }
}
