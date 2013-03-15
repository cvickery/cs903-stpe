<?php
  date_default_timezone_set('America/New_York');
  ini_set('error_reporting', E_ALL);
  ini_set('log_errors', 'On');
  ini_set('error_log', './error_log');
  ini_set('display_errors', 'On');
  assert_options(ASSERT_ACTIVE, 1);
  assert_options(ASSERT_WARNING, 1);
  include('index.php');
?>
