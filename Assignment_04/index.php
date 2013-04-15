<?php
//  Account Management
/*  1.  Look up user name and password in users table.
 *      Offer congratulations or condolences
 *      Users table is a pre-defined CSV file
 */

  //  Set up debugging environment
  //  -----------------------------------------------------------------------------------
  ini_set('error_log', '../error_log');
  ini_set('log_errors', true);
  ini_set('error_level', E_ALL);

  //  Process form data
  //  -----------------------------------------------------------------------------------

  //  defaults if no form set
  $page_title = 'Login';

  //  Determine which form was submitted, if any, and process it
  if (isset($_POST['form-name']))
  {
    switch($_POST['form-name'])
    {
      case 'login-form':
        $login_success = 'Imposter';
        break;
      default:
        error_log('Invalid form-name');
        break;
    }
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
?>
<!DOCTYPE html>
<html <?php echo $html_attributes;?>>
  <head>
    <title>$page_title</title>
    <link rel='stylesheet' href='css/main.css' />
  </head>
  <body>
<?php
  echo "    <h1>$page_title</h1>\n";
  if (empty($login_success))
  {
    //  User is not logged in: display login form
    echo <<<EOD
    <form method='post' action='.'>
      <input type='hidden' name='form-name' value='login-form' />
      <fieldset><legend>Enter your user name and password</legend>
        <label for='username' tabindex='1'>User name</label>
        <input type='text' id='username' name='username' />
        <label for='password' tabindex='2'>Password</label>
        <input type='password' id='password' name='password' />
        <button type='submit'>Sign In</button>
      </fieldset>
    </form>
EOD;
  }
  else
  {
    echo "<h1>Congratulations, $login_success</h1>\n";
  }
?>
    <footer>  — &#x2014; -
      <a href="http://validator.w3.org/check?uri=referer">XHTML</a> —
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS</a>
    </footer>
  </body>
</html>
