

<div id="glossary_<?= $question->id() ?>" class="glossary grid layout">

    <div class="inner-wrapper column">
        
        <h3>Glossary</h3>

        <?php

            if (isset($choicevalues)) {
                
                foreach($choicevalues as $choice):
        
                    echo $choice->optdescription();

                endforeach;

            } else {
                echo $question->glossary();
            }
        
        ?>

        <div class="btn btn-outline-primary" onClick="closeGlossary(event)">Ok let's go back</div>
    
    </div>

</div>