<?php
try {
  include_once 'VisitorStatistics.php';
  VisitorStatistics::recordVisit();
} catch (Exception $e) {
  error_log($e->getMessage());
  $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Visitor Statistics Recorder</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
  </head>
  <body>
    <?php if (is_null($error)) { ?>
      <p>Thanks, your user agent-string has been recorded</p>
    <?php } else { ?>
      <p>Something went wrong! Contact a dev.</p>
    <?php } ?>
  </body>
</html>
