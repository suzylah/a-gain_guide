<?php

$req = $question->isrequired()->toBool();
$glossary = $question->hasglossary()->toBool();
$cond = $question->isconditional()->toBool();

?>
<div class="<?= $cond ? 'question-hidden': 'carousel-item' ?> <?= $req ? 'required': '' ?> part-<?= $partIndex ?>" data-guide-section="<?= $partIndex ?>">
<section id="q<?= $question->id() ?>_<?= $question->shortname() ?>" class="column bg-<?= $part->background() ?> vertical__center qscreen" style="--columns: 12;" <?= $cond ? 'data-parent="' . Str::slug($question->dependson(),'_') . '"': '' ?>>

    <span class="topline"><?= $part->title() ?></span>
    <h2>
        <?= Str::replace($question->question(),'—','— <br>') ?>
        <?php if ($glossary) { ?>
        <span class="info" aria-controls="#glossary_<?= $question->id() ?>" onClick="showGlossary(event)">i</span>
        <?php } ?>
    </h2>

    <p class="desc"><?= $question->description() ?></p>

    <?php 
        $fieldtemp = $question->fieldtype();
        if($fieldtemp) :
        if ($question->choices()->isNotEmpty()) {
            $choices = $reuse->findBy('name', Str::trim($question->choices()));
            $choicevalues = $choices->options()->toStructure();
            snippet('form/' . $fieldtemp, ['question' => $question, 'choicevalues' => $choicevalues]);

            if ($glossary) {
                snippet('form/glossary', ['question' => $question, 'choicevalues' => $choicevalues]);
            }

        } else {
            snippet('form/' . $fieldtemp, ['question' => $question]);
            if ($glossary) { snippet('form/glossary', ['question' => $question]); }
        }
        endif;
    ?>

 </section>
 </div>