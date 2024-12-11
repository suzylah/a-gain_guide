<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

<?php snippet('header') ?>

<div id="map-container">
  <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

<?= js([
  'assets/js/leaflet/map.js',
  'assets/js/leaflet/leaflet-feature-list.js',
  'assets/js/leaflet/leaflet-filter-features.js',
  'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/4.0.0/leaflet-search.min.js',
  '@auto'
]) ?>

<?php snippet('footer') ?>

