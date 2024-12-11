<form id="guideForm" class="layout carousel slide" style="--gutter: 0" data-bs-ride="carousel" data-bs-interval="false" data-bs-wrap="false" data-bs-touch="false" data-guide-part="1">
  <div class="top-right">
    <div id="close" onClick="showQuitWarning()"><span></span></div>
  </div>

  <div class="carousel-inner">

    <?php 
    $reuse = page("reusematrix")->optiongroup()->toStructure();
    $quiz = page('quiz');
    $parts = $quiz->parts()->toStructure();

    foreach ($parts as $part): 
      $partIndex = $parts->indexOf($part) + 1;
    ?>
      <div class="carousel-item <?= $part->title() == "Guide – Part 1 of 3" ? 'active' : '' ?> part-<?= $partIndex ?>" data-guide-section="<?= $partIndex ?>">
        <section class="column bg-<?= $part->background() ?> vertical__center qscreen part-intro" style="--columns: 12;">
          <span class="section-title"><?= $part->title() ?></span>
          <h2><?= $part->description() ?></h2>
          <?= $part->description2() ?>
        </section>
      </div>

      <?php $questions = $part->questions()->toStructure();
        foreach ($questions as $question): ?>
          <?php snippet('form/question', ['question' => $question, 'part' => $part, 'reuse' => $reuse, 'partIndex' => $partIndex]); ?>
        <?php endforeach ?>
      <?php endforeach ?>

  <div class="carousel-item">

    <section class="column bg-purple vertical__center qscreen part-intro" style="--columns: 12;">
      <h2><?= $quiz->final() ?></h2>
      <button type="submit" id="submitQuery" class="btn-link __dark"><?= $quiz->submittext() ?></button>
    </section></div>

  </div>

  <button class="carousel-control-prev hidden" type="button" data-bs-target="#guideForm" data-bs-slide="prev">
    <div class="guide-control prev" aria-hidden="true"></div>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#guideForm" data-bs-slide="next">
    <div class="guide-control next" aria-hidden="true"></div>
    <span class="visually-hidden">Next</span>
  </button>

  <progress id="progressbar" class="hidden" max="100" value="0"></progress>

</form>

<div class="guide-advice-screen grid layout glossary">
  <div class="inner-wrapper column">
    <?= $quiz->advicetext() ?>
    
    <div class="btn-group">
      <div class="btn btn-outline-primary" onClick="closeGlossary(event)">
      <?php if($kirby->language()->code() == 'de'): ?>
        Zurück zur letzten Frage
      <?php else: ?>
        OK, LET'S CONTINUE
      <?php endif ?>
      </div>
    </div>
  </div>
  
</div>


