<?php

try {
  include_once '../VisitorStatistics.php';
  $visits = VisitorStatistics::getVisits();
} catch (Exception $e) {
  error_log($e->getMessage());
  $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Visitor Statistics</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h2>Visitor Statistics</h2>
    <?php if (is_null($error)) { ?>
      <p>Here are the visitors we've seen so far</p>
      <table id=user-agent-strings-table>
        <thead>
          <tr><td>User Agent String</td><td>Timestamp</td></tr>
        </thead>
        <tbody>
          <?php foreach ($visits as $visit) { ?>
              <tr>
                <td><?= htmlspecialchars($visit['user_agent_string']) ?></td>
                <td><?= htmlspecialchars($visit['date_created']) ?></td>
              </tr>
            <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>Something went wrong fetching visitor records! Contact a dev.</p>
    <?php } ?>
  </body>
</html>
