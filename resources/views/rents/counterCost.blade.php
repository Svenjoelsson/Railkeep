<?php
if ($counterCost) {
    $value = intval($counterCost);
  if (str_contains($value, ' ')) {
    $value = str_replace(" ", "", $value);
  }
  $fmt = numfmt_create( 'se-SE', NumberFormatter::CURRENCY );
  echo numfmt_format_currency($fmt, $value, $currency);



    //echo ." ";
}
?>