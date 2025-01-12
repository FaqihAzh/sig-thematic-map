@extends('layouts.index')

@section('title', 'Peta Provinsi di Indonesia')

@section('content')
<div id="map">Loading map...</div>
@endsection

@push('scripts')
<script>
    var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom: 14,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var provinces = @json($provincesData);

    provinces.forEach(function(province) {
        L.marker([province.latitude, province.longitude]).addTo(map).bindPopup(province.name);
    })

    const title = "Data Provinsi di Indonesia";
        const headers = ['Provinsi', 'Latitude', 'Longitude'];
        const properties = ['Provinsi', 'Latitude', 'Longitude'];
        const tableData = provinces.map(province => ({
            Provinsi: province.name,
            Latitude: province.latitude,
            Longitude: province.longitude
        }));
        dataTable(title, headers, properties, tableData);

    L.control.scale().addTo(map);
</script>
@endpush

