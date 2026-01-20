<?php
$metadata['title'] = 'Dashboard - Live Tracking | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/general.php';

$badgeClasses = [
    'on-time' => 'badge--success',
    'delayed' => 'badge--warning',
    'cancelled' => 'badge--danger',
];
$current_station_index = -1;
if (!empty($train['route'])) {
    foreach ($train['route'] as $index => $stop) {
        if ($stop['station_id'] == $train['current_station']) {
            $current_station_index = $index;
            break;
        }
    }
}

$journey_progress =
    $current_station_index > 0 ? ($current_station_index / (count($train['route']) - 1)) * 100 : 0;
?>

<main class="dashboard-main">
    <div class="dashboard-content max-w-7xl mx-auto space-y-6">
        <div class="card">
            <div class="card__content p-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <select id="trackingTrainSelect" class="select" style="width: 16rem">
                        <?php if (!empty($train)) { ?>
                            <option value="<?= htmlspecialchars($train['id']) ?>" selected>
                                <?= htmlspecialchars($train['name']) ?> (<?= htmlspecialchars(
     $train['number'],
 ) ?>)

                            </option>
                        <?php } ?>
                        <?php if (!empty($allTrains)) {
                            foreach ($allTrains as $t) {
                                if ($t['id'] !== $train['id']) { ?>
                            <option value="<?= htmlspecialchars($t['id']) ?>">
                                <?= htmlspecialchars($t['name']) ?> (<?= htmlspecialchars(
     $t['number'],
 ) ?>)
                            </option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="flex gap-2">
                        <button class="btn btn--default">
                            <svg
                                class="h-4 w-4 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                            Timeline View
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card__header">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="card__title" id="trainName"><?php echo htmlspecialchars(
                            $train['name'] ?? '',
                        ); ?></h2>
                        <p class="text-sm text-gray-500" id="trainNumber">Train #<?php echo htmlspecialchars(
                            $train['number'] ?? '',
                        ); ?></p>
                    </div>
                    <div class="flex gap-2">
                        <span class="badge uppercase base--outline <?php echo $badgeClasses[
                            $train['status']
                        ] ?? ''; ?>" id="trainStatus"><?php echo htmlspecialchars(
    $train['status'] ?? 'STATUS',
); ?></span>
                        <span class="badge badge--outline" id="trainType"><?php echo htmlspecialchars(
                            $train['type'] ?? 'Type',
                        ); ?></span>
                    </div>
                </div>
            </div>
            <div class="card__content space-y-4">
                <div class="grid sm-grid-cols-3 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg
                                class="h-5 w-5 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Current Location</p>
                            <p class="font-semibold" id="currentLocation"><?php echo htmlspecialchars(
                                $train['current_station_name'] ?? '-',
                            ); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg
                                class="h-5 w-5 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Next Station</p>
                            <p class="font-semibold" id="nextStation"><?php echo htmlspecialchars(
                                $train['next_station_name'] ?? '-',
                            ); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <svg
                                class="h-5 w-5 text-purple-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Current Speed</p>
                            <p class="font-semibold" id="currentSpeed"><?php echo htmlspecialchars(
                                $train['speed'] ?? '-',
                            ); ?></p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="text-gray-600">Journey Progress</span>
                        <span class="font-medium" id="progressPercent"><?php echo round(
                            $journey_progress,
                            2,
                        ); ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-bar__fill" id="progressFill" style="width: <?php echo round(
                            $journey_progress,
                            2,
                        ); ?>%"></div>
                    </div>
                </div>

                <div
                    id="delayWarning"
                    class="p-3 bg-yellow-50 rounded-lg border border-yellow-200"
                    style="display: none"
                >
                    <p class="text-sm text-yellow-800"></p>
                </div>
            </div>
        </div>

        <div id="timelineView" class="card">
            <div class="card__header">
                <h2 class="card__title">Journey Timeline</h2>
            </div>
            <div class="card__content">
                <div class="space-y-4" id="routeTimeline">
                  <?php foreach ($train['route'] as $index => $stop) {

                      $isCurrent = $index === $current_station_index;
                      $isPassed = $current_station_index !== -1 && $index < $current_station_index;

                      $dotColor = $isCurrent ? '#2563eb' : ($isPassed ? '#16a34a' : '#d1d5db');
                      $dotBg = $isCurrent ? '#2563eb' : ($isPassed ? '#16a34a' : 'white');
                      $lineColor = $isPassed ? '#16a34a' : '#d1d5db';
                      ?>
<div class="flex gap-4">
    <div class="flex flex-col items-center" style="width: 16px;">
        <div style="width: 16px; height: 16px; border-radius: 50%; border: 2px solid <?php echo $dotColor; ?>; background-color: <?php echo $dotBg; ?>; flex-shrink: 0;"></div>
        
        <?php if ($index < count($train['route']) - 1): ?>
            <div style="width: 2px; flex: 1; background-color: <?php echo $lineColor; ?>; min-height: 60px;"></div>
        <?php endif; ?>
    </div>

    <div class="flex-1" style="padding-bottom: <?php echo $index < count($train['route']) - 1
        ? '1rem'
        : '0'; ?>;">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h4 class="font-semibold text-base"><?php echo htmlspecialchars(
                    $stop['station_name'] ?? 'Unknown',
                ); ?></h4>
                <p class="text-sm text-gray-500"><?php echo htmlspecialchars(
                    $stop['station_code'] ?? '',
                ); ?></p>
            </div>
            <?php if ($isCurrent): ?>
                <span class="badge badge--default">Current</span>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-2 gap-x-8 gap-y-1 text-sm">
            <?php if (!empty($stop['arrival_time'])): ?>
                <div>
                    <span class="text-gray-500">Arrival: </span>
                    <span class="font-medium"><?php echo date(
                        'H:i',
                        strtotime($stop['arrival_time']),
                    ); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($stop['departure_time'])): ?>
                <div>
                    <span class="text-gray-500">Departure: </span>
                    <span class="font-medium"><?php echo date(
                        'H:i',
                        strtotime($stop['departure_time']),
                    ); ?></span>
                </div>
            <?php endif; ?>

            <div>
                <span class="text-gray-500">Platform: </span>
                <span class="font-medium"><?php echo htmlspecialchars($stop['platform']); ?></span>
            </div>
            <div>
                <span class="text-gray-500">Distance: </span>
                <span class="font-medium"><?php echo htmlspecialchars(
                    $stop['distance'],
                ); ?> km</span>
            </div>
        </div>
    </div>
</div>
<?php
                  } ?>
    
                </div>
            </div>
        </div>
    </div>
</main>


<script>
    document.getElementById('trackingTrainSelect').addEventListener('change', function () {
        const selectedTrainId = this.value;
        window.location.href = `/dashboard/tracking?train_id=${selectedTrainId}`;
    });
</script>

<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
