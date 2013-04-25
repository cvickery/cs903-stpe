<?php
date_default_timezone_set('America/New_York');
set_include_path('include');
require_once ('markdown.php');

//  class Node_Time
//  -------------------------------------------------------------------------------------
class Node_Time
{
  public $node, $mtime;
  function __construct($node)
  {
    $this->node = $node;
    $this->mtime = filemtime($node);
  }
  function __toString()
  {
    return $this->node . ' ' . date('F j, Y \a\t g:i a', $this->mtime);
  }
}

//  scandir_r()
//  -------------------------------------------------------------------------------------
/*  Return pathname and modification time of most recent non-hidden node in a
 *  directory tree.
 */
  function scandir_r($dir, $max_node_time)
  {
    echo "<!-- $dir, $max_node_time -->\n";
    assert('is_dir($dir)');
    $nodes = scandir($dir);
    foreach ($nodes as $node)
    {
      if (is_dir("$dir/$node"))
      {
        if ($node[0] !== '.' && $node[0] !== '_')
        {
          $return_node_time = scandir_r("$dir/$node", $max_node_time);
          if (($max_node_time === null) ||
              ($return_node_time->mtime > $max_node_time->mtime))
          {
            $max_node_time = $return_node_time;
          }
        }
      }
      else
      {
        if ($max_node_time === null)
        {
          $max_node_time = new Node_Time("$dir/$node");
        }
        else if (($mtime = filemtime("$dir/$node")) > $max_node_time->mtime)
        {
          $max_node_time->node = "$dir/$node";
          $max_node_time->mtime = $mtime;
        }
      }
    }
    return $max_node_time;
  }

  $mime_type = "text/html";
  $html_attributes = "lang=\"en\"";
  if (
        array_key_exists("HTTP_ACCEPT", $_SERVER) &&
        (
          stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml") ||
          stristr($_SERVER["HTTP_ACCEPT"], "application/xml")
        ) ||
        (
          array_key_exists("HTTP_USER_AGENT", $_SERVER) &&
          stristr($_SERVER["HTTP_USER_AGENT"], "W3C_Validator")
        )
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
<html <?php echo $html_attributes; ?>>
  <head>
    <title>Perfect Student’s Assignments</title>
    <link rel='stylesheet' href="./Assignment_03/css/assignment_03.css"/>
  </head>
  <body>
    <h1>Perfect Student’s Assignments</h1>
<?php
    $suffixes = ' KMGTP';
    $error_log_size = filesize('error_log');
    $e = 0;
    if ($error_log_size > 0)  $e = floor(log($error_log_size, 2) / 10);
    $n = $error_log_size / pow(2, $e * 10);
    $d = strpos($n, '.');
    $n = substr($n, 0, 3 + $d) . @$suffixes[$e];
    $readme_file = is_file('README.md') ?
        Markdown(file_get_contents('README.md')) : "<p class='error'>Missing README</p>";
    $status = <<<EOD
    $n bytes.</p>
    <ul>
      <li><a href='./error_log'>View Error Log</a></li>
      <li><a href='./clear_log.php'>Clear Error Log</a></li>
    </ul>
EOD;
    if ($n == 0)
    {
      $status = "empty.</p>";
    }
    echo <<<EOD
      <dir class='readme'>
        $readme_file
        <p>The error_log file is currently $status
      </dir>

EOD;

    $dir = opendir('.') or die("<h2 class='error'>Error: unable to open directory</h2>" .
                               "</body></html>\n");
    assert('is_dir("."); // the assertion failed');
    error_log("That wasn’t a real assertion. Don’t worry about it, ok?");
    error_log("OK, I won't worry about it. Thanks for the heads up!");
    while ($dir_path = readdir($dir))
    {
      if (is_dir($dir_path) && $dir_path[0] !== '.' && $dir_path[0] !== '_')
      {
        $max_node_time = scandir_r($dir_path, null);
        if ($max_node_time === null)
        {
          $max_node_time = new Node_Time($dir_path);
        }
        $max_node = $max_node_time->node;
        $modified_str = date('F j, Y \a\t g:i a', $max_node_time->mtime);
        echo <<<EOD
      <h2>
      <a href='$dir_path'>$dir_path</a>: last modified $modified_str ($max_node)
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
        echo "      <div class='readme'>$readme_contents</div>\n";
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
