<?php

$items = $page->slider()->toStructure(); ?>

<div class="glide">
    <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides arrows__ctl" >
            <?php foreach ($items as $item): ?>
            <li class="glide__slide" >
                <h2><?= $item->text()->html() ?></h2>
            </li>
            <?php endforeach ?>
        </ul>
    </div>

    <div class="glide__arrows" data-glide-el="controls">
    <button class="glide__arrow glide__arrow--left glide--mobile-no-bg" data-glide-dir="<">prev</button>
    <button class="glide__arrow glide__arrow--right glide--mobile-no-bg" data-glide-dir=">">next</button>
    </div>

    <div class="glide__bullets" data-glide-el="controls[nav]">
        <?php $index=0; foreach ($items as $item): ?>
            <button class="glide__bullet" data-glide-dir="=<?php echo $index; ?>"></button>
            <?php $index++; ?>
        <?php endforeach ?>
    </div>

</div>