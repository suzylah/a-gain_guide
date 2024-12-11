<?php

$optiongroups = $page->optiongroup()->toStructure();

$json = [];

$groups = [];

$serviceref = [];

$offersref = [];

foreach($optiongroups as $item) {

    $groupObjs = [];
    
    $options = $item->options()->toStructure();

    $optionObjs = [];

    foreach($options as $option) {

        $optionObjs[] = [
            'name' => (string)$option->name(),
            'slug' => Str::slug($option->name(),'_'),
            'services' => (array)$option->optservices()->split(','),
            'offers' => (array)$option->optoffers()->split(','),
            'extras' => (array)$option->optextras()->split(','),
            'type' => (string)$option->servicetype(),
        ];
    }

    $json[] = [
        'name' => (string)$item->name(),
        'slug' => Str::slug($item->name(),'_'),
        'options' => $optionObjs
    ];
}
  
echo json_encode($json);



