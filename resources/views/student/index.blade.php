@extends('layouts.index')

@section('title', 'Peta Sebaran Pelajar Per Km2 Kab/Kota Sulawesi Utara 2024')

@section('content')
<div id="map">Loading map...</div>
@endsection

@push('scripts')
<script>
    var map = L.map('map').setView([1.5, 124.8], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 10,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Faqih | Rafi | Bayu'
    }).addTo(map);

    function getColor(sebaran_pelajar) {
        return sebaran_pelajar > 5.149 ? '#7f2704' :
               sebaran_pelajar > 4.0 ? '#a63603' :
               sebaran_pelajar > 2.5 ? '#d94801' :
               sebaran_pelajar > 1.0 ? '#f16913' :
               sebaran_pelajar > 0.132 ? '#fdae6b' :
                                        '#feedde';
    }

    function style(feature) {
        return {
            fillColor: getColor(feature.properties.sebaran_pelajar),
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
                 <strong>Sebaran Pelajar:</strong> ${feature.properties.sebaran_pelajar} Pelajar/Km²`
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
            grades = [0.132, 1.0, 2.5, 4.0, 5.149],
            labels = [];

        for (var i = 0; i < grades.length; i++) {
            var row = document.createElement('div');
            row.style.display = 'flex';
            row.style.alignItems = 'center';
            row.style.marginBottom = '5px';

            var colorBox = document.createElement('i');
            colorBox.style.background = getColor(grades[i] + 0.001);
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.display = 'inline-block';

            var text = document.createElement('span');
            text.innerHTML = grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + ' Pelajar/Km²' : '+ Pelajar/Km²');
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
        div.style.maxWidth = '250px';
        div.style.lineHeight = '1.5';

        return div;
    };
    legend.addTo(map);

    var zoomControl = L.control.zoom({
        position: 'bottomleft'
    }).addTo(map);
</script>




@endpush
