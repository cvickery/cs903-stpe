<?php
// sanitize.php

//  sanitize()
//  -------------------------------------------------------------------------------------
/*  Make a string SQL injection safe...
 *    Single quotes get smart.
 *    Double dashes => em dashes
 *    ;             =>  &#x3B;
 *
 *  ... and XSS safe
 *    &, <, and > => XML named character entities
 *
 *  ... and pretty
 *    Double quotes get smart
 *
 *  ... and Unix-y
 *    Line endings => lf
 */
  function sanitize($str)
  {
    $returnVal = trim ($str);
    $returnVal = preg_replace("/(^|\s)'/",  "$1‘",    $returnVal);
    $returnVal = str_replace("'",           "’",      $returnVal);
    $returnVal = str_replace("--",          "—",      $returnVal);
    $returnVal = str_replace(";",           "&#x3B;", $returnVal);

    $returnVal = htmlspecialchars($returnVal, ENT_NOQUOTES, "UTF-8", false);

    $returnVal = preg_replace('/(^|\s)"/',  "$1“",    $returnVal);
    $returnVal = str_replace('"',           "”",      $returnVal);

    $returnVal = str_replace("\r\n",        "\n",     $returnVal);
    $returnVal = str_replace("\r",          "\n",     $returnVal);

    return $returnVal;
  }
