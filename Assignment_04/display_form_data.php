<?php

  //  Set up debugging environment
  //  -----------------------------------------------------------------------------------
  ini_set('error_log', '../error_log');
  ini_set('log_errors', true);
  ini_set('error_level', E_ALL);

  // Initialization
  set_include_path("./include");
  require_once('init_session.inc');
  require_once('sanitize.inc');

  //  Determine whether to deal with this page load or not.
  //  $_POST must be non-empty; the form-name must be 'login-form'
  if (empty($_POST) or empty($_POST[form_name]))
  {
    $_SESSION[login_error_msg] = 'Form not submitted properly';
    header('Location: index.php');
    exit;
  }

  //  Generate the web page
  //  -----------------------------------------------------------------------------------
  $mime_type = "text/html";
  $html_attributes="lang=\"en\"";
  if ( array_key_exists("HTTP_ACCEPT", $_SERVER) &&
        (stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml") ||
         stristr($_SERVER["HTTP_ACCEPT"], "application/xml") )
       ||
       (array_key_exists("HTTP_USER_AGENT", $_SERVER) &&
        stristr($_SERVER["HTTP_USER_AGENT"], "W3C_Validator"))
     )
  {
    $mime_type = "application/xhtml+xml";
    $html_attributes = "xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\"";
    header("Content-type: $mime_type");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  }
  else
  {
    header("Content-type: $mime_type; charset=utf-8");
  }
  echo <<<EOD
<!DOCTYPE html>
<html $html_attributes>
  <head>
    <title>Form Data</title>
    <link rel='stylesheet' href='css/assignment_4.css' />
  </head>
  <body>
    <h1>Form Data</h1>
    <table>
      <tr>
        <th>Name</th><th>Value</th>
      </tr>
EOD;
  foreach ($_POST as $name => $value)
  {
    $name   = sanitize($name);
    $value  = sanitize($value);
    echo "      <tr><td>$name</td><td>$value</td></tr>";
  }
?>
    </table>
  </body>
</html>
