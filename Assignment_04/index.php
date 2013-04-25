<?php
//  Account Management
/*  1.  Look up user name and password in users table.
 *      Offer congratulations or condolences
 *      Users table is a pre-defined CSV file
 */

  //  Initialization
  set_include_path('include');
  require_once('init_session.inc');

  //  Set up debugging environment
  //  -----------------------------------------------------------------------------------
  ini_set('error_log', '../error_log');
  ini_set('log_errors', true);
  ini_set('error_level', E_ALL);

  //  Generate the web page
  //  -----------------------------------------------------------------------------------
  $page_title = 'Login';
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
    echo "<?xml version='1.0' encoding='UTF-8'?>\n";
  }
  else
  {
    header("Content-type: $mime_type; charset=utf-8");
  }
  echo <<<EOD
<!DOCTYPE html>
<html $html_attributes>
  <head>
    <title>$page_title</title>
    <link rel='stylesheet' href='css/assignment_4.css' />
  </head>
  <body>
    <h1>$page_title</h1>

EOD;
  echo "<!--"; var_dump($_SESSION); echo "-->";
  if (!empty($_SESSION[login_error_msg]))
  {
    echo "    <h2 class='error'>{$_SESSION[login_error_msg]}</h2>\n";
    unset($_SESSION[login_error_msg]);
  }
?>
    <form method='post' action='display_form_data.php'>
      <input type='hidden' name='form-name' value='login-form' />
      <fieldset><legend>Enter your user name and password</legend>
        <label for='username' tabindex='2'>User name</label>
        <input type='text' id='username' name='username' />
        <label for='password' tabindex='1'>Password</label>
        <input type='password' id='password' name='password' />
        <button type='submit' tabindex='3'>Sign In</button>
      </fieldset>
    </form>
    <footer>
      <a href="http://validator.w3.org/check?uri=referer">XHTML</a> —
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS</a>
    </footer>
  </body>
</html>
