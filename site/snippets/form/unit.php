<div id="unit_<?= str::slug($question->question(),'_') ?>" class="form-group unit">

    <div class="num-group">
        <span class="min btn">&minus;</span>
        <input type="number" min="1" max="50" value="1" class="numfield" name="<?= $question->shortname() ?>">
        <span class="plus btn">&plus;</span>
    </div>

    <div class="unit-group">

    <?php 

        $inlineglossary = $question->hasinlineglossary()->toBool();

        if (isset($choicevalues)):
            foreach ($choicevalues as $c): 
                $opt = $c->name(); ?>
                <div class="unit-form-element">
                 <input type="radio" class="btn-check" id="o<?= $question->id() ?>_<?= str::slug($opt,'_') ?>" name="<?= $question->shortname() ?>_unit" value="<?= $opt ?>"><label class="btn btn-outline-primary" for="o<?= $question->id() ?>_<?= str::slug($opt,'_') ?>"><?= $opt ?></label>

                 <?php if ($inlineglossary) { ?>
                    <div class="inline-glossary form-text"><?= $c->optdescription(); ?></div>
                 <?php } ?>
                 </div>
            <?php endforeach;
        else:

            $options = $question->options()->toStructure(); 
            foreach ($options as $option): ?>
            <input type="radio" class="btn-check" id="o<?= $question ?>_<?= str::slug($option->option(),'_') ?>" name="<?= $question->shortname() ?>_unit" value="<?= $option->option() ?>"><label class="btn btn-outline-primary" for="o<?= $question ?>_<?= str::slug($option->option(),'_') ?>"><?= $option->option() ?></label>
            <?php endforeach ?>

        <?php endif ?>
    
    
    </div>

</div>



<script>


    const numfield = document.querySelector('#unit_<?= str::slug($question->question(),'_') ?> input[type="number"]')

    document.querySelector('#unit_<?= str::slug($question->question(),'_') ?> .plus').addEventListener('click', ()=>{
    
        numfield.value = numfield.value == 50 ? 50 : parseInt(numfield.value) + 1

    })

    document.querySelector('#unit_<?= str::slug($question->question(),'_') ?> .min').addEventListener('click', ()=>{

        numfield.value = numfield.value == 1 ? 1 : parseInt(numfield.value) - 1

    })

</script>