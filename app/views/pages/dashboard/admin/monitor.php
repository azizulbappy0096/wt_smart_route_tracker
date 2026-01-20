<?php
$metadata['title'] = 'Admin Dashboard - Monitor | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/admin.php';

$badgeClasses = [
    'on-time' => 'badge--success',
    'delayed' => 'badge--warning',
    'cancelled' => 'badge--error',
    'stopped' => 'badge--info',
];
?>

<main class="dashboard-main">
    <div class="dashboard-content space-y-6">
        <div class="grid sm-grid-cols-4 gap-4">
            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Trains</p>
                            <p class="text-3xl font-bold mt-1" id="activeTrains"><?php echo $analytics[
                                'stats'
                            ]['active_trains'] ?? 0; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg
                                class="h-6 w-6 text-blue-600"
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
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Delayed Trains</p>
                            <p class="text-3xl font-bold mt-1" id="delayedTrains"><?php echo $analytics[
                                'stats'
                            ]['delayed_trains'] ?? 0; ?></p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <svg
                                class="h-6 w-6 text-yellow-600"
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
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Open Issues</p>
                            <p class="text-3xl font-bold mt-1" id="openIssues">0</p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-lg">
                            <svg
                                class="h-6 w-6 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Avg Speed</p>
                            <p class="text-3xl font-bold mt-1" id="avgSpeed"><?php echo $analytics[
                                'stats'
                            ]['avg_speed'] ?? 0; ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <svg
                                class="h-6 w-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card__header">
                <h3 class="card__title">Active Trains</h3>
                <p class="card__description">Real-time train status and information</p>
            </div>
            <div class="card__content">
                <div class="space-y-3" id="activeTrainsList">
                    <?php foreach ($analytics['trains'] as $train) { ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold"><?php echo htmlspecialchars(
                                $train['name'],
                            ); ?></p>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars(
                                $train['number'],
                            ) .
                                ' • ' .
                                htmlspecialchars($train['type']); ?></p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Current Location</p>
                                <p class="font-medium"><?php echo htmlspecialchars(
                                    $train['current_station_name'] ?? 'N/A',
                                ); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Speed</p>
                                <p class="font-medium"><?php echo htmlspecialchars(
                                    $train['speed'],
                                ) . ' km/h'; ?></p>
                            </div>
                            <span class="badge <?php echo $badgeClasses[$train['status']] ??
                                ''; ?>"> <?php echo htmlspecialchars($train['status']); ?> </span>
                        </div>
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
