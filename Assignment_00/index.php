<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>My Zeroth Assignment</title>
  </head>
  <body>
    <h1>My Zeroth Assignment</h2>
<?php
  $dir = opendir('..');
  while ($node = readdir($dir))
  {
    echo "      <p>$node</p>\n";
  }
?>
    <footer>
      <a href="http://validator.w3.org/check?uri=referer">XHTML</a>
      —
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS</a>
    </footer>
  </body
</html>
