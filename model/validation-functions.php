<?php
/**
 * Validate a color
 *
 * @param $color
 * @return bool
 */
function validColor($color){
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validText($animal){
   // global $f3;
    if (empty($valid)){
        echo "Enter an animal";
        return false;
    }
    if (!preg_match("/^[a-zA-Z ]*$/",$animal)) {
        echo "Only letters and white space allowed";
        return false;
    }
    return true;

}
