<!-- resources/views/map.blade.php -->
@extends('layouts.app')

@section('content')
    <div id="map" style="height: 400px;"></div>
<style>
    
#map {
  height: 100%;
}

/* 
 * Optional: Makes the sample page fill the window. 
 */
html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>
    <script>
      
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 11,
                center: { lat: 40.785091, lng: -73.968285 },
            });
            const kmlPath = "<?php echo($kmlPath);?>"
          
            const ctaLayer = new google.maps.KmlLayer({
                url: kmlPath,
                map: map,
            });
            }

window.initMap = initMap;


        // Load Google Maps API with the key and callback
        const apiKey = 'AIzaSyDlDRj6I3G6nbuIiiWLCNbZDPDDESxMvBc';
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
        script.defer = true;
        document.head.appendChild(script);
    </script>
@endsection
