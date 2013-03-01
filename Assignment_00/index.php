<?php
  header('Content-type: application/xhtml+xml');
  echo "<?xml version='1.0' encoding='UTF-8'?>\n";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>My Zeroth Assignment</title>
    <link rel='stylesheet' type='text/css' href='css/assignment_0.css' />
  </head>
  <body>
    <h1>My Zeroth Assignment</h1>
<?php
  $dir = opendir('..');
  while ($node = readdir($dir))
  {
		if ($node[0] === '.' || $node[0] === '_') continue;
    echo "    <p>$node</p>\n";
  }
?>
    <footer>
      <a href="http://validator.w3.org/check?uri=referer">XHTML</a>
      —
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS</a>
    </footer>
  </body
></html>
