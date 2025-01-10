@extends('layouts.index')

@section('title', 'Peta Tingkat Pengangguran Terbuka Kab/Kota Sulawesi Utara 2024')

@section('content')
<div id="map">Loading map...</div>
@endsection

@push('scripts')
<script>
    var map = L.map('map').setView([1.5, 124.8], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 10,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Faqih Azhar'
    }).addTo(map);

    function getColor(tpt) {
        return tpt > 7.65 ? '#006400' :
       tpt > 6.34 ? '#228B22' :
       tpt > 4.61 ? '#ADFF2F' :
       tpt > 2.84 ? '#FFD700' :
       tpt > 2.09 ? '#FF4500' :
                    '#FF6347';
    }

    function style(feature) {
        return {
            fillColor: getColor(feature.properties.tpt),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }

    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({
            weight: 3,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.9
        });

        if (layer.feature.properties && layer.feature.properties.Kabupaten) {
            layer.bindTooltip(`<strong>${layer.feature.properties.Kabupaten}</strong>`, {
                permanent: false,
                direction: 'top',
                className: 'tooltip-style'
            }).openTooltip();
        }

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
    }

    function resetHighlight(e) {
        geojsonLayer.resetStyle(e.target);
        e.target.closeTooltip();
    }

    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
    }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });

        if (feature.properties) {
            layer.bindPopup(
                `<strong>Provinsi:</strong> Sulawesi Utara<br>
                 <strong>Kabupaten/Kota:</strong> ${feature.properties.Kabupaten}<br>
                 <strong>TPT:</strong> ${feature.properties.tpt} %`
            );
        }
    }

    let geojsonLayer;
    fetch('/geojson/prov-sulut.geojson')
        .then(response => response.json())
        .then(data => {
            geojsonLayer = L.geoJSON(data, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);
        })
        .catch(error => console.error('Error fetching GeoJSON:', error));

    var legend = L.control({ position: 'bottomright' });
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
            grades = [2.09, 2.84, 4.61, 6.34, 7.65, 8.85],
            labels = [
                'Sangat Rendah (2,09% - 2,84%)',
                'Rendah (2,84% - 4,61%)',
                'Sedang (4,61% - 6,34%)',
                'Tinggi (6,34% - 7,65%)',
                'Sangat Tinggi (7,65% - 8,85%)'
            ];

        for (var i = 0; i < grades.length - 1; i++) {
            var row = document.createElement('div');
            row.style.display = 'flex';
            row.style.alignItems = 'center';
            row.style.marginBottom = '5px';

            var colorBox = document.createElement('i');
            colorBox.style.background = getColor(grades[i] + 0.01);
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.display = 'inline-block';

            var text = document.createElement('span');
            text.innerHTML = labels[i];
            text.style.flex = '1';

            row.appendChild(colorBox);
            row.appendChild(text);
            div.appendChild(row);
        }

        div.style.backgroundColor = '#fff';
        div.style.borderRadius = '8px';
        div.style.padding = '15px';
        div.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
        div.style.fontSize = '12px';
        div.style.fontFamily = 'Poppins, sans-serif';
        div.style.maxWidth = '300px';
        div.style.lineHeight = '1.5';

        return div;
    };
    legend.addTo(map);

    var zoomControl = L.control.zoom({
        position: 'bottomleft'
    }).addTo(map);
</script>



@endpush
