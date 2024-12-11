<div class="form-group range <?= $question->shortname() ?>-range">

    <?php

        $options = isset($choicevalues) ? $choicevalues : $question->options()->toStructure();
        $numopts = count($options);
        $optwidth = 100;
        $rangewidth = $numopts * $optwidth;
        $listwidth = $rangewidth + $optwidth;
        $itemwidth = floor(100/$numopts);
        $startat = 1;

    ?> 
    
    <input type="range" id="<?= $question->shortname() ?>" list="<?= $question->shortname() ?>-datalist" value="<?= $startat ?>" step="0.001" min="1" max="<?= $numopts ?>" size="<?= $rangewidth ?>" name="<?= $question->shortname() ?>" style="width: <?= $rangewidth ?>px" autocomplete="false" oninput="updateRange(event)">
    
    <div id="<?= $question->shortname() ?>-datalist" class="datalist" style="width: calc(<?= $rangewidth ?>px + <?= $itemwidth ?>%);margin-left: calc( -1 * <?= $itemwidth ?>% / 2);">
        <?php foreach ($options as $option): 
            $opt = isset($choicevalues) ? $option->name() : $option->option() ?> 
            <div class="datalist-opt" for="<?= (string)$option->id() + 1 ?>" style="width:<?= $itemwidth ?>%">
                <span class="name"><?= $opt ?></span>
                <span class="marker"></span>
            </div>
        <?php endforeach ?>
    </div>

</div>
