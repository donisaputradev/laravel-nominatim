# Laravel Nominatim
Ini adalah project laravel sebagai backup dari nominatim yang mana ada limit penggunaan. karena limit ini, kita sering menemukan kendala pada aplikasi kita. harapannya ini bisa dikembangkan lagi.

## GET - /search
API ini digunakan untuk mencari data berdasarkan beberapa parameter seperti search, street, city, county, state, country, dan postalcode. Endpoint ini akan mengembalikan hasil pencarian sesuai dengan kriteria yang diberikan melalui query parameters.

### Query Parameters
Berikut adalah query parameters yang dapat digunakan:

1. **search** (optional)
- Deskripsi: Kata kunci untuk pencarian umum.
- Contoh: ?search=hotel

2. **street** (optional)
- Deskripsi: Nama jalan atau alamat jalan.
- Contoh: ?street=Jalan Merdeka

3. **city** (optional)
- Deskripsi: Nama kota.
- Contoh: ?city=Jakarta

4. **county** (optional)
- Deskripsi: Nama kabupaten.
- Contoh: ?county=Bandung

5. **state** (optional)
- Deskripsi: Nama provinsi atau negara bagian.
- Contoh: ?state=West Java

6. **country** (optional)
- Deskripsi: Nama negara.
- Contoh: ?country=Indonesia

7. **postalcode** (optional)
- Deskripsi: Kode pos.
- Contoh: ?postalcode=40125

### Contoh Penggunaan
Pencarian berdasarkan kata kunci umum
```http
GET /search?search=Medan
```
Hasil: Mengembalikan hasil pencarian yang terkait dengan kata kunci Medan di name dan display name.

### Success Response
Response dari API akan berupa JSON yang berisi data yang sesuai dengan kriteria pencarian.

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

### Error Response
Jika parameter pencarian tidak ditemukan atau ada kesalahan dalam permintaan, API akan mengembalikan response dengan status error.
```json
{
    "meta": {
        "code": 500,
        "status": "error",
        "message": "Service Error"
    }
}
```
