<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Place;
use App\Services\NominatimService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $service;

    public function __construct(NominatimService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $query = Place::query()->with('address')
                ->where(function ($q) use ($request) {
                    if ($request->search) {
                        $q->where('places.name', 'like', '%' . $request->search . '%')
                            ->orWhere('places.display_name', 'like', '%' . $request->search . '%');
                    }
                    if ($request->street) {
                        $q->orWhereHas('address', fn($query) => $query->where('road', 'like', '%' . $request->street . '%'));
                    }
                    if ($request->city) {
                        $q->orWhereHas('address', fn($query) => $query->where('city', 'like', '%' . $request->city . '%'));
                    }
                    if ($request->county) {
                        $q->orWhereHas('address', fn($query) => $query->where('county', 'like', '%' . $request->county . '%'));
                    }
                    if ($request->state) {
                        $q->orWhereHas('address', fn($query) => $query->where('state', 'like', '%' . $request->state . '%'));
                    }
                    if ($request->country) {
                        $q->orWhereHas('address', fn($query) => $query->where('country', 'like', '%' . $request->country . '%'));
                    }
                    if ($request->postalcode) {
                        $q->orWhereHas('address', fn($query) => $query->where('postcode', 'like', '%' . $request->postalcode . '%'));
                    }
                })->limit(10);

            $places = $query->get();

            if ($places->isNotEmpty()) {
                return ResponseFormatter::success($places);
            }

            $nominatimQuery = [
                'format' => 'json',
                'q' => $request->search,
                'street' => $request->street,
                'city' => $request->city,
                'county' => $request->county,
                'state' => $request->state,
                'country' => $request->country,
                'postalcode' => $request->postalcode,
                'addressdetails' => 1,
                'limit' => 10,
            ];

            $results = $this->service->get('/search', $nominatimQuery);

            if ($results) {
                foreach ($results as $item) {
                    $place = Place::create([
                        'place_id' => $item['place_id'],
                        'licence' => $item['licence'] ?? null,
                        'osm_type' => $item['osm_type'] ?? null,
                        'osm_id' => $item['osm_id'] ?? null,
                        'lat' => $item['lat'] ?? null,
                        'lon' => $item['lon'] ?? null,
                        'type' => $item['type'] ?? null,
                        'place_rank' => $item['place_rank'] ?? null,
                        'importance' => $item['importance'] ?? null,
                        'addresstype' => $item['addresstype'] ?? null,
                        'name' => $item['name'] ?? null,
                        'display_name' => $item['display_name'] ?? null,
                    ]);

                    if (isset($item['address'])) {
                        $place->address()->create([
                            'village' => $item['address']['village'] ?? null,
                            'borough' => $item['address']['borough'] ?? null,
                            'county' => $item['address']['county'] ?? null,
                            'city' => $item['address']['city'] ?? null,
                            'state' => $item['address']['state'] ?? null,
                            'postcode' => $item['address']['postcode'] ?? null,
                            'country' => $item['address']['country'] ?? null,
                            'country_code' => $item['address']['country_code'] ?? null,
                            'neighbourhood' => $item['address']['neighbourhood'] ?? null,
                            'road' => $item['address']['road'] ?? null,
                            'shop' => $item['address']['shop'] ?? null,
                            'suburb' => $item['address']['suburb'] ?? null,
                            'historic' => $item['address']['historic'] ?? null,
                        ]);
                    }
                }
            }

            return ResponseFormatter::success($results);
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), $th->getCode());
        }
    }
}
