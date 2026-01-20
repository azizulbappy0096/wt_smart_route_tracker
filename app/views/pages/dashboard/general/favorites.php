<?php
$metadata['title'] = 'Dashboard - Favorites | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/general.php';
?>

<main class="dashboard-main">
<div class="tab-content tab-content--active" id="favorites-tab">
    <div class="max-w-7xl mx-auto space-y-6">
      <div class="card">
        <div class="card__header">
          <h2 class="card__title flex items-center gap-2">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            Favorite Trains
          </h2>
          <p class="card__description">Quick access to your frequently tracked trains</p>
        </div>
        <div class="card__content space-y-4">
          <?php if (empty($trains)) { ?>
            <p class="text-center text-gray-500">You have no favorite trains yet. Start adding some!</p>
          <?php } else {foreach ($trains as $train) { ?>

            <div class="card hover-shadow" id="trainCard-<?php echo htmlspecialchars(
                $train['id'],
            ); ?>">
               
              <div class="card__content p-6">
                <div class="flex items-start justify-between mb-4">
                  <div class="flex-1 cursor-pointer" onClick="navigateToTracking('<?php echo htmlspecialchars(
                      $train['id'],
                  ); ?>')">
                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars(
                        $train['name'],
                    ); ?></h3>
                    <p class="text-sm text-gray-500">Train #<?php echo htmlspecialchars(
                        $train['number'],
                    ); ?></p>
                  </div>
                  <div class="flex gap-2 items-center">
                    <button class="btn btn--ghost p-2" onclick="removeFavorite('<?php echo htmlspecialchars(
                        $train['id'],
                    ); ?>', '<?php echo htmlspecialchars(
    $_SESSION['user']['id'],
); ?>')" title="Remove from favorites">
                      <svg class="h-5 w-5 text-red-500" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                      </svg>
                    </button>
                    <span class="badge badge--default uppercase">
                        <?php echo htmlspecialchars($train['status']); ?>
                    </span>
                  </div>
                </div>

                <div class="grid sm-grid-cols-3 gap-4 text-sm" style="cursor: pointer;" onClick="navigateToTracking('<?php echo htmlspecialchars(
                    $train['id'],
                ); ?>')">
                  <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                      <p class="text-gray-500">Current Location</p>
                      <p class="font-medium">
                         <?php echo htmlspecialchars($train['current_station_name']); ?>
                    </p>
                    </div>
                  </div>

                  <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                      <p class="text-gray-500">Next Station</p>
                      <p class="font-medium"><?php echo htmlspecialchars(
                          $train['next_station_name'],
                      ); ?> at <?php echo htmlspecialchars($train['next_arrival_time']); ?></p>
                    </div>
                  </div>

                  <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <div>
                      <p class="text-gray-500">Speed</p>
                      <p class="font-medium"><?php echo htmlspecialchars(
                          $train['speed'],
                      ); ?> km/h</p>
                    </div>
                  </div>
                </div>
              </div>
         
            </div>
          <?php }} ?>
        </div>
      </div>
    </div>
    </div>
</main>

<script>
    function removeFavorite(trainId, userId) {  
        const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/favorites/toggle', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                const trainCard = document.getElementById('trainCard-' + trainId);
                if (trainCard) {
                    trainCard.remove();
                }
                showToast(response.message, 'success');
            } else {
                showToast(response.message, 'error');
            }
        }
    };
    xhr.send(JSON.stringify({ user_id: userId, train_id: trainId }));
    }

    function navigateToTracking(trainId) {
        window.location.href = '/dashboard/tracking?train_id=' + trainId;
    }
</script>

<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
