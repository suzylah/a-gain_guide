<div class="form-group multiselect">
    <?php 

    $inlineglossary = $question->hasinlineglossary()->toBool();

    if (isset($choicevalues)):
        foreach ($choicevalues as $c): 
            $opt = $c->name(); ?>
             <div class="form-element field-<?= str::slug($opt,'_') ?>">
             <input type="checkbox" class="btn-check" id="o<?= $question->id() ?>_<?= str::slug($opt,'_') ?>" name="<?= $question->shortname() ?>[]" value="<?= $opt ?>">
             <label class="btn btn-outline-primary" for="o<?= $question->id() ?>_<?= str::slug($opt,'_') ?>"><?= $opt ?></label>
             <?php if ($inlineglossary) { ?>
                <div class="inline-glossary form-text"><?= $c->optdescription(); ?></div>
             <?php } ?>
             
            </div>
        <?php endforeach;

    else:
        $options = $question->options()->toStructure(); 
        foreach ($options as $option): ?>
            <div class="form-element field-<?= str::slug($option->option(),'_') ?>"><input type="checkbox" class="btn-check" id="o<?php echo $question->id() ?>_<?= str::slug($option->option(),'_') ?>" name="<?= $question->shortname() ?>[]" value="<?= $option->option() ?>"><label class="btn btn-outline-primary" for="o<?php echo $question->id() ?>_<?= str::slug($option->option(),'_') ?>"><?= $option->option() ?></label></div>
        <?php endforeach;
    endif ?>
    
</div>