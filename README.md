# Laravel Nominatim
This is a Laravel project as a backup for Nominatim which has a usage limit. because of this limit, we often encounter problems in our applications. The hope is that this can be developed again.

## GET - /search
This API is used to search for data based on several parameters such as search, street, city, county, state, country, and postalcode. This endpoint will return search results according to the criteria provided via query parameters.

### Query Parameters
The following are the query parameters that can be used:

1. **search** (optional)
- Description: Keywords for general search.
- Example: ?search=hotel

2. **street** (optional)
- Description: Street name or street address.
- Example: ?street=Independence Street

3. **city** (optional)
- Description: City name.
- Example: ?city=Jakarta

4. **county** (optional)
- Description: District name.
- Example: ?county=Bandung

5. **state** (optional)
- Description: Name of province or state.
- Example: ?state=West Java

6. **country** (optional)
- Description: Country name.
- Example: ?country=Indonesia

7. **postal code** (optional)
- Description: Postal code.
- Example: ?postalcode=40125

### Usage Example
Search based on general keywords
```http
GET /search?search=Medan
```
Results: Returns search results related to the keyword Medan in name and display name.

## GET - /reverse
This API is used to retrieve address data based on latitude and longitude coordinates.

### Query Parameters
1. **lat** (required)
- Description: Latitude is used to find a location.
- Example: ?lat=3.595193

2. **lon** (required)
- Description: Longitude is used to find locations.
- Example: ?lon=98.675022

### Usage Example
To search for an address based on latitude and longitude coordinates:
```http
GET /reverse?lat=3.595193&lon=98.675022
```
Results: Returns the closest address data that matches the given latitude and longitude coordinates.

## Success Response
The response from the API will be in the form of JSON containing data that matches the search criteria.

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": null
    },
    "data": [
        {
            "place_id": 234441200,
            "licence": "Data © OpenStreetMap contributors, ODbL 1.0. http://osm.org/copyright",
            "osm_type": "relation",
            "osm_id": 8484616,
            "lat": "3.5896654",
            "lon": "98.6738261",
            "type": "administrative",
            "place_rank": 12,
            "importance": 0.57434742996263,
            "addresstype": "city",
            "name": "Kota Medan",
            "display_name": "Kota Medan, Sumatera Utara, Sumatera, Indonesia",
            "address": {
                "village": null,
                "borough": null,
                "county": null,
                "city": "Kota Medan",
                "state": "Sumatera Utara",
                "postcode": null,
                "country": "Indonesia",
                "country_code": "id",
                "neighbourhood": null,
                "road": null,
                "shop": null,
                "suburb": null,
                "historic": null,
            }
        }
    ]
}
```

## Error Response
If the search parameter is not found or there is an error in the request, the API will return a response with an error status.

```json
{
    "meta": {
        "code": 500,
        "status": "error",
        "message": "Service Error"
    }
}
```
