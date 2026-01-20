<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $metadata['title'] ??
      'Smart Route Tracker - Real-Time Train Tracking'; ?></title>
  <link rel="stylesheet" href="/assets/css/main.css">
  
  <?php if (isset($metadata['styles'])) {
      foreach ($metadata['styles'] as $cssFile) {
          echo '<link rel="stylesheet" href="' . htmlspecialchars($cssFile) . '">' . "\n";
      }
  } ?>
  <script src="/assets/js/utils.js"></script>
</head>
<body>