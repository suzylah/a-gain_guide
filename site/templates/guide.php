<?php snippet('header') ?>

<?= css(
  'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css', ['integrity' => 'sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==', 'crossorigin' => '']
) ?>

<?= css([
  'assets/css/templates/map.css',
  'assets/css/templates/quiz.css',
  '@auto'
]) ?>

<div id="content" class="layout grid" style="--gutter: 0">
  <section class="column h-90 vertical__center bg-purple text-dark" style="--columns: 12;">
    <span class="topline">Use The Guide</span>
    <h2>
      <?php if($kirby->language()->code() == 'de'): ?>
      Die glänzende Zukunft deiner gebrauchten Kleidung ist nur ein paar Fragen entfernt. Deine A-GAIN GUIDE Reise kann beginnen! :)
      <?php else: ?>
        The shining future of your used clothes is just a few questions away. Let's start the journey! :)
      <?php endif ?>
    </h2>

    <div id="startguide" style="display:none">
      <button class="btn btn-link __dark" onClick="startGuide()">
        <?php if($kirby->language()->code() == 'de'): ?>
          Start Guide
        <?php else: ?>
          Start Guide
        <?php endif ?>
      </button><span class="info" aria-controls="#data-notice" onClick="showGlossary(event)">i</span>
    </div>
        <?php snippet("data-notice") ?>

        <p><?php if($kirby->language()->code() == 'de'): ?>
          Es braucht nur circa 5 Minuten
        <?php else: ?>
          It just takes about 5 minutes
        <?php endif ?></p>
      </section>

      <section class="column h-sq-50 vertical__center text" style="--columns: 6;padding:30px">
        <h3>
          <?php if($kirby->language()->code() == 'de'): ?>
            Erhalte den größten Wert deiner Textilien für dich und die Umwelt.<br><br>Finde unter vielen kreativen Angeboten den richtigen Service für dich und wähle die beste Möglichkeit, um Textilien länger zu nutzen - A-GAIN & A-GAIN
          <?php else: ?>
            Get the GAIN that gives you and the environment the most value.  <br><br>Find the right service among many creative offers and choose the best way to continue using it — A-GAIN & A-GAIN
          <?php endif ?>
        </h3>
      </section>

      <section class="column h-sq-50 vertical__center bg-purple text" style="--columns: 6;background:rgb(208,182,229)">
        <h3>
          <?php if($kirby->language()->code() == 'de'): ?>
            In deiner abgenutzten Kleidung steckt oft mehr als gedacht.<br><br>
            Neugierig? Dann erfahre mehr auf unserer KNOWLEDGE Seite.  
          <?php else: ?>
            In your used clothing there is often more than you think.<br><br>
            Curious? Find out more on our KNOWLEDGE page.
          <?php endif ?>
        </h3>
        <button class="btn-link"><a href="<?= $pages->find('knowledge')->url() ?>">
        <?php if($kirby->language()->code() == 'de'): ?>
          KNOWLEDGE PAGE
        <?php else: ?>
          KNOWLEDGE PAGE
        <?php endif ?>
        </a></button>
      </section>
  </div>

<?php snippet('layouts', ['field' => $page->layout()])  ?>

<div id="guide" style="display:none"><?php snippet('form/quizform') ?></div>

<div id="result" style="display:none" class="map">
  <div id="viewSwitch">
    <div id="viewMap">Map</div>
    <div id="viewList" class="activeView">List</div>
  </div>
</div>

<div class="quit-warning-screen grid layout glossary">
  <div class="inner-wrapper column">
    <h3>Are you sure you wanna quit the GUIDE?</h3>
    <p>Your answers will be lost.</p>
    <div class="btn-group">
      <div class="btn btn-outline-primary" onClick="cancelGuide()">Yes, quit</div>
      <div class="btn btn-outline-primary" onClick="closeGlossary(event)">No, continue</div>
    </div>
  </div>
</div>

<div class="actions top-right">
  <div class="button-group save-results">
    <button class="btn btn-outline-primary">Save</button>
    <div class="inner">
      <p>Send your results to yourself via mail so you can recall all services later again.</p>  
      <?php snippet('send-guide-results') ?>
      
    </div>
  </div>
  <div class="button-group share-guide">
    <button class="btn btn-outline-primary">Share</button>
    <div class="inner"><?php snippet('share') ?></div>
  </div>
  <div class="button-group quit-guide" style="display:none">
    <button id="close-guide" class="btn btn-outline-primary" onClick="showQuitWarning()">Quit</button>
  </div>
</div>

<?= js(
  'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', ['integrity' => 'sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==', 'crossorigin' => '']
) ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<?= js([
  'assets/js/map/map-guide.js',
  'assets/js/templates/quiz.js',
  'assets/js/map/leaflet-feature-list.js',
  'assets/js/map/leaflet.markercluster.js',
]) ?>

<?php 
  $map = page('map');
  if ($map->code()->last()->exists()) :
    $data = $map->code()->last()->url();
  else :
    $data = $kirby->url('assets') . '/data/empty.json';
  endif;
?>

<script>

  const stakeholders = "<?= $data ?>";
  
</script>
<?php snippet('footer') ?>
