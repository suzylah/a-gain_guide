<?php snippet('header') ?>

<?php snippet('layouts', ['field' => $page->layout()])  ?>

<section class="layout grid margin-0 topic-grid">

    <?php 
        $topics = ['rethink', 'care', 'repair', 'remake', 'share', 'recirculate'];
        foreach($topics as $item): 
        $topic = $page->findPageOrDraft($item)
    ?>

    <div class="column" style="--columns:6">
        <div class="block block-type-topic vertical__center topic-<?= $item ?> ">

            <?php if ($file = $topic->illustration()->toFile()) :?>
                <div class="illustration">
                    <?= svg($file) ?>
                </div>
            <?php endif ?> 
            
            <h2>
                <?= $topic->title()->esc() ?>
            </h2>
            <p>
                <?= $topic->subtitle() ?>
            </p>
            <?php if ( $topic->isPublished() ) { ?>
                <button class="btn-link btn-center">
                    <a href="<?= $topic->url() ?>">
                        <?php if($kirby->language()->code() == 'de'): ?>
                            Zum Thema
                        <?php else: ?>
                            Go to topic
                        <?php endif ?>
                    </a>
                </button>
                <?php } else if ( $topic->isDraft() ) { ?>
                <button class="btn-link btn-center btn-disabled">
                    
                    <?php if($kirby->language()->code() == 'de'): ?>
                        Bald verfügbar
                    <?php else: ?>
                        Coming soon
                    <?php endif ?>
                </button>
                <?php } ?>
        </div>
    </div>
<?php endforeach ?>

</section>

<section id="newsletter" class="knowledge-newsletter column h-90 vertical__center bg-brightgreen" style="--columns: 12;">
    <h2 style="margin:1em auto">
        <?php if($kirby->language()->code() == 'de'): ?>
            Bleib up to date!
        <?php else: ?>
            Stay up to date!
        <?php endif ?>
    </h2>

    <p><?php if($kirby->language()->code() == 'de'): ?>
        Begleite uns auf unserer Reise durch die Straßen Berlins und tauche ein in zirkuläre Lösungsansätze auf unserer KNOWLEDGE-Seite.
        Bleibe auf dem Laufenden über neu veröffentlichte Beiträge und um zu erfahren, wann es an der Zeit ist, Textilabfälle in unseren Textile Journeys 2024 in Angriff zu nehmen.
        <br><br>
        Melde dich für unseren Newsletter an!
        <?php else: ?>
            Join us on our journey through the streets of Berlin and deep diving into circular solutions on our KNOWLEDGE page. 
            Stay up to date on freshly published topics and when it's time to tackle textile waste hands-on in our 2024 Textile Journey events.
            <br><br>
            Sign up to our newsletter!
        <?php endif ?>
    </p>
    
    <!-- Insert newsletter form -->

</section>

<?php snippet('footer') ?>