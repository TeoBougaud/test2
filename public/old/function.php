<?php

function insertLoremIpsumParagraph($count)
{
    for ($i = 0; $i < $count; $i++) {
        $div = "<p>";
        $div .= "Officia labore eiusmod est veniam officia ullamco nostrud pariatur do ipsum aliqua. Magna aute incididunt incididunt dolore id laboris sunt voluptate sint officia proident ad. Duis culpa non proident nulla laboris officia non exercitation officia culpa incididunt id ea. Elit eiusmod aute adipisicing et sit aute elit ipsum officia do ipsum Lorem eu Lorem. Eiusmod anim est commodo voluptate. Excepteur culpa aliquip aliqua commodo ad excepteur non consectetur qui excepteur officia proident duis.";
        $div .= "</p>";

        echo $div;
    }
}