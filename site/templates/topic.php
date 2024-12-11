<?php snippet('header') ?>

<div class="layout grid" style="--gutter: 0">
    <section class="column h-90 vertical__center bg-brightgreen title-screen title-<?= $page->slug() ?>" style="--columns: 12;">
        <span class="topline">
            <?= $page->title() ?>
        </span>

        <?php if ($file = $page->illustration()->toFile()) :?>
            <div class="illustration">
                <?= svg($file) ?>
            </div>
        <?php endif ?>
        <h1>
            <?= $page->title() ?>
        </h1>
        <h3 class="subtitle">
            <?= $page->subtitle() ?>
        </h3>
    </section>

    <section id="topic-index" class="column h-90 vertical__center bg-white" style="--columns: 12;">
        
        <span class="topline">
            
            <?php if($kirby->language()->code() == 'de'): ?>
                Inhalt
            <?php else: ?>
                Content
            <?php endif ?>
        </span>

        <h3>1.<br>
        <?php if($kirby->language()->code() == 'de'): ?>
            Kurze Einführung
        <?php else: ?>
            Short introduction
        <?php endif ?></h3>
        
        <button class="btn-link btn-down"><a href="#introduction">
        <?php if($kirby->language()->code() == 'de'): ?>
            Zum Abschnitt
        <?php else: ?>
            Go to Chapter
        <?php endif ?>
        </a></button>
    
        <h3>2.<br>
            <?php if($kirby->language()->code() == 'de'): ?>
                Ein „Deep Dive“ zum Thema 
            <?php else: ?>
                A deeper dive into 
            <?php endif ?><?= $page->title() ?>
        </h3>

        <button class="btn-link btn-down"><a href="#deepdive">
        <?php if($kirby->language()->code() == 'de'): ?>
            Zum Abschnitt
        <?php else: ?>
            Go to Chapter
        <?php endif ?>
        </a></button>
    
        <h3>3.<br>Quick Wins & Challenges</h3>

        <button class="btn-link btn-down"><a href="#aspects">
        <?php if($kirby->language()->code() == 'de'): ?>
            Zum Abschnitt
        <?php else: ?>
            Go to Chapter
        <?php endif ?>
        </a></button>

        <h3>4.<br><?php if($kirby->language()->code() == 'de'): ?>
            Jetzt kommst du ins Spiel!
            <?php else: ?>
                Now you come into play!
            <?php endif ?>
        </h3>

        <button class="btn-link btn-down"><a href="#takeaction">
        <?php if($kirby->language()->code() == 'de'): ?>
            Zum Abschnitt
        <?php else: ?>
            Go to Chapter
        <?php endif ?>
        </a></button>
       
      </section>
</div>

<div class="layout grid chapter-title" style="--gutter: 0">
    <section id="introduction" class="column h-90 vertical__center bg-brightgreen" style="--columns: 12;">
        <span class="topline">
            <?php if($kirby->language()->code() == 'de'): ?>
                Warum?
            <?php else: ?>
                Why?
            <?php endif ?>
        </span>
        <h2>1.<br>
        <?php if($kirby->language()->code() == 'de'): ?>
            Kurze Einführung
        <?php else: ?>
            Short introduction
        <?php endif ?>
        </h2>
    </section>
</div>

<?php snippet('layouts', ['field' => $page->introduction()])  ?>

<div class="layout grid chapter-title" style="--gutter: 0">
    <section id="deepdive" class="column h-90 vertical__center bg-brightgreen" style="--columns: 12;">
        <span class="topline">
            Deep Dive
        </span>
        <h2>2.<br>
        <?php if($kirby->language()->code() == 'de'): ?>
                Ein „Deep Dive“ zum Thema 
            <?php else: ?>
                A deeper dive into 
            <?php endif ?><?= $page->title() ?>
        </h2>
    </section>
</div>

<?php snippet('layouts', ['field' => $page->deepdive()])  ?>
<div class="layout grid chapter-title" style="--gutter: 0">
    <section id="aspects" class="column h-90 vertical__center bg-brightgreen" style="--columns: 12;">
        <span class="topline">
            REFLECTION
        </span>
        <h2>3.<br>
        <?php if($kirby->language()->code() == 'de'): ?>
            Quick Wins &amp; Challenges
        <?php else: ?>
            Quick Wins &amp; Challenges
        <?php endif ?>
        </h2>
    </section>
</div>

<?php snippet('layouts', ['field' => $page->aspects()])  ?>

<div class="layout grid chapter-title" style="--gutter: 0">
    <section id="takeaction" class="column h-90 vertical__center bg-brightgreen" style="--columns: 12;">
        <span class="topline">
            Take Action
        </span>
        <h2>4.<br>
        <?php if($kirby->language()->code() == 'de'): ?>
            Jetzt kommst du ins Spiel!
        <?php else: ?>
            Now you come into play!
        <?php endif ?>
        </h2>
    </section>
</div>

<?php snippet('layouts', ['field' => $page->takeaction()])  ?>

 <?php snippet('layouts', ['field' => $page->topicfooter()])  ?>

<?php snippet('footer') ?>