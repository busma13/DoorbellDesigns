<?php

namespace App;

class Utils
{
  public static function setItemName($itemObj)
  {
    $itemNameWithOptions = $itemObj->itemNameString;
    foreach ($itemObj->options->optionsPairStrings as $obj) {
      $itemNameWithOptions .= ', ' . $obj->stringKey . ' ' . $obj->stringValue;
    }
    return $itemNameWithOptions;
  }
}