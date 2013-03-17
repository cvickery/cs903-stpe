<?php
  if (isset($_SERVER['HTTP_REFERER']))
  {
    fopen('error_log', 'w+');
    header("Location:{$_SERVER['HTTP_REFERER']}");
    exit();
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Clear Error Log</title>
  </head>
  <body>
<?php
  echo "<h1>" . `du -sh error_log` . "</h1>\n";
  fopen('error_log', 'w+') or die("<p>Unable to clear error_log</p>\n");
  echo "<p>error_log cleared</p>";
  ?>
  </body>
</html>
