<?php
  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', '1');
  ini_set('log_errors', '~/stpe9999/htdocs/error_log');
  date_default_timezone_set('America/New_York');
  set_include_path('includes');
  require_once('markdown.php');

  function scandir_r($dir)
  {
    $files = array();
    $nodes = scandir($dir);
    foreach ($nodes as $node)
    {
      if (is_dir("$dir/$node"))
      {
        if ($node[0] !== '.' && $node[0] !== '_')
        {
          $files = $files + scandir_r("$dir/$node");
        }
      }
      else
      {
        $files["$dir/$node"] = filemtime("$dir/$node");
      }
    }
    return $files;
  }

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
    <title>The Professor’s Assignments</title>
    <link rel='stylesheet' href="./Assignment_03/css/assignment_03.css"/>
  </head>
  <body>
    <h1>The Professor’s Assignments</h1>
    <?php
    $dir = opendir('.');// or die("<h2 class='error'>Error: unable to open directory</h2>" .
        //"</body></html>\n");
    while ($dir_path = readdir($dir))
    {
      if (is_dir($dir_path) && $dir_path[0] !== '.' && $dir_path[0] !== '_')
      {
        $files = scandir_r($dir_path);
        $max_file = 'Unknown';
        $max_time = 0;
        foreach($files as $file => $mtime)
        {
          if ($mtime > $max_time)
          {
            $max_time = $mtime;
            $max_file = $file;
          }
        }
        if ($max_time === 0)
        {
          $max_file = 'Empty Directory';
          $max_time = filemtime($dir_path);
        }
        else
        {
          $max_file = substr($max_file, strlen($dir_path) + 1);
        }
        $modified_str = date('F j, Y \a\t g:i a', $max_time);
        echo <<<EOD
      <h2>
        <a href='$dir_path'>$dir_path</a>: last modified $modified_str ($max_file)
      </h2>

EOD;
        //  Find a readme file to display, if there is one
        $readme_contents = "<h3 class='error'>Missing README file!</h3>\n";
        $readme_files = array('README.md', 'README', 'README.txt');
        foreach ($readme_files as $readme_file)
        {
          if (is_file("$dir_path/$readme_file"))
          {
             $readme_contents = Markdown(file_get_contents("$dir_path/$readme_file"));
             break;
          }
        }
        echo "<div class='readme'>$readme_contents</div>\n";
      }
    }
    ?>
    <footer>
      <a href="http://validator.w3.org/check?uri=referer">XHTML</a>
      &#x2014; —
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS</a>
    </footer>
  </body>
</html>
