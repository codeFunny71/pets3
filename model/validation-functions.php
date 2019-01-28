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
