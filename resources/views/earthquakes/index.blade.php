@extends('layouts.index')

@section('title', 'Peta Sebaran Gempa Terkini | BMKG')

@section('content')
<div id="map">Loading map...</div>
@endsection

@push('scripts')
<script>
    let map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom: 14,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let getEarthquakeData = {!! file_get_contents('https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json') !!}

    let earthquakeData = getEarthquakeData.Infogempa.gempa;
    earthquakeData.forEach(item => {
        let coordinat = item.Coordinates.split(",");
        let latitude = coordinat[0];
        let longitude = coordinat[1];

        L.marker([latitude, longitude]).addTo(map)
            .bindPopup(
                `<table style="border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 4px; font-weight: bold;">Waktu</td>
                        <td style="padding: 4px;">:</td>
                        <td style="padding: 4px;">${item.Tanggal} ${item.Jam}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold;">Kedalaman</td>
                        <td style="padding: 4px;">:</td>
                        <td style="padding: 4px;">${item.Kedalaman} Km</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold;">Magnitude</td>
                        <td style="padding: 4px;">:</td>
                        <td style="padding: 4px;">${item.Magnitude} SR</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold;">Potensi</td>
                        <td style="padding: 4px;">:</td>
                        <td style="padding: 4px;">${item.Potensi}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold;">Koordinat</td>
                        <td style="padding: 4px;">:</td>
                        <td style="padding: 4px;">${item.Coordinates}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold;">Wilayah</td>
                        <td style="padding: 4px;">:</td>
                        <td style="padding: 4px;">${item.Wilayah}</td>
                    </tr>
                </table>`
            )
        .openPopup();
    })
</script>
@endpush
