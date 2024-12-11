<div class="form-group select">
    <?php if (isset($choicevalues)):

        $inlineglossary = $question->hasinlineglossary()->toBool();
        foreach ($choicevalues as $c): 
            $opt = $c->name(); ?>
            <div class="form-element"><input type="radio" class="btn-check" id="o<?= $question ?>_<?= str::slug($opt,'_') ?>" name="<?= $question->shortname() ?>" value="<?= $opt ?>"><label class="btn btn-outline-primary" for="o<?= $question ?>_<?= str::slug($opt,'_') ?>"><?= $opt ?></label>
            <?php if ($inlineglossary) { ?>
                <div class="inline-glossary form-text"><?= $c->optdescription(); ?></div>
             <?php } ?>
        
        </div>
        <?php endforeach;

    else:
    
        $options = $question->options()->toStructure(); 
        foreach ($options as $option): ?>
        <div class="form-element"><input type="radio" class="btn-check" id="o<?= $question->id() ?>_<?= str::slug($option->option(),'_') ?>" name="<?= $question->shortname() ?>" value="<?= $option->option() ?>"><label class="btn btn-outline-primary" for="o<?= $question->id() ?>_<?= str::slug($option->option(),'_') ?>"><?= $option->option() ?></label></div>
        <?php endforeach;
    endif;

    ?>
</div>