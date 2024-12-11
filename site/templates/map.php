<?php snippet('header') ?>

<?= css(
  'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css', ['integrity' => 'sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==', 'crossorigin' => '']
) ?>

<?= css('@auto') ?>

<style>.footer, .colophon {display:none}</style>

<div id="map-container">
  <div id="map"></div>

  <div id="viewSwitch">
    <div id="viewMap" class="activeView">Map</div>
    <div id="viewList">List</div>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

<?= js([
  'assets/js/map/map.min.js',
  //'assets/js/map/map.js',
  'assets/js/map/leaflet-featurelist.min.js',
  //'assets/js/map/leaflet-feature-list.js',
  'assets/js/map/leaflet-filterfeatures.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/4.0.0/leaflet-search.min.js',
]) ?>

<?php 
  if ($page->code()->last()->exists()) :
    $data = $page->code()->last()->url();
  else :
    $data = $kirby->url('assets') . '/data/empty.json';
  endif;
?>

<script>
  document.addEventListener("DOMContentLoaded", fetchResults("<?= $data ?>"));
</script>

<?php snippet('footer') ?>