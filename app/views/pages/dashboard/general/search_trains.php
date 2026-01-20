<?php
$metadata['title'] = 'Dashboard - Search Trains | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/general.php';

$badgeClasses = [
    'on-time' => 'bg-green-100 text-green-800',
    'delayed' => 'bg-yellow-100 text-yellow-800',
    'stopped' => 'bg-red-100 text-red-800',
];
?>

<main class="dashboard-main">
    <div class="container container--max-7xl space-y-6">
        <div class="card">
            <div class="card__header">
                <h2 class="card__title">Search Trains</h2>
                <p class="card__description">Find trains by name, number, route, or station</p>
            </div>
            <div class="card__content">
                <div class="grid sm-grid-cols-3 gap-4">
                    <div class="input-group">
                        <svg
                            class="input-group__icon"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                        <input
                            type="text"
                            id="searchInput"
                            class="input pl-10"
                            placeholder="Search by train name or number..."
                            value="<?php echo htmlspecialchars($searchParams['query'] ?? ''); ?>"
                        />
                    </div>

                    <select id="stationFilter" class="select" value="<?php echo htmlspecialchars(
                        $searchParams['station'] ?? 'all',
                    ); ?>">
                        <option value="all">All Stations</option>
                    </select>

                    <select id="typeFilter" class="select">
                        <option value="all">All Types</option>
                        <option value="Express">Express</option>
                        <option value="Super Fast">Super Fast</option>
                        <option value="Local">Local</option>
                        <option value="Passenger">Passenger</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="searchResults" class="grid gap-4">
            <?php foreach ($trains as $train) { ?>
                <div class="card hover-shadow">
                    <div class="card__content p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1 cursor-pointer" onclick="selectTrainAndTrack('<?php echo htmlspecialchars(
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
                                <button
                                    class="btn btn--ghost p-2"
                                    onclick="
                                        toggleFavorite('<?php echo htmlspecialchars(
                                            $train['id'],
                                        ); ?>', '<?php echo htmlspecialchars(
    $_SESSION['user']['id'],
); ?>');
                                    "
                                    title="Remove from favorites"
                                    id="favoriteBtn-<?php echo htmlspecialchars($train['id']); ?>"
                                >
                                    <svg
                                        class="h-5 w-5 text-red-500"
                                        fill="currentColor"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                        ></path>
                                    </svg>
                                </button>
                                <span class="badge uppercase <?php echo htmlspecialchars(
                                    $badgeClasses[strtolower($train['status'])] ?? '',
                                ); ?>"><?php echo htmlspecialchars($train['status']); ?></span>
                                <span class="badge badge--outline capitalize"><?php echo htmlspecialchars(
                                    $train['type'],
                                ); ?></span>
                            </div>
                        </div>

                        <div
                            class="grid sm-grid-cols-3 gap-4 text-sm"
                            onclick="window.location.href='/dashboard/tracking?train_id=<?php echo htmlspecialchars(
                                $train['id'],
                            ); ?>'"
                            style="cursor: pointer"
                        >
                            <div class="flex items-center gap-2">
                                <?php if ($train['is_favorite']) { ?>
                                <svg
                                    class="h-4 w-4 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    ></path>
                                </svg>
                                <?php } else { ?>
<svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                                <?php } ?>
                                
                                <div>
                                    <p class="text-gray-500">Current Location</p>
                                    <p class="font-medium"><?php echo htmlspecialchars(
                                        $train['current_station_name'],
                                    ); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg
                                    class="h-4 w-4 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                                <div>
                                    <p class="text-gray-500">Next Station</p>
                                    <p class="font-medium"><?php echo htmlspecialchars(
                                        $train['next_station_name'] .
                                            ' at ' .
                                            date('h:i A', strtotime($train['next_arrival_time'])),
                                    ); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg
                                    class="h-4 w-4 text-purple-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                    ></path>
                                </svg>
                                <div>
                                    <p class="text-gray-500">Speed</p>
                                    <p class="font-medium"><?php echo htmlspecialchars(
                                        $train['speed'] . ' km/h',
                                    ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
        </div>
    </div>
</main>

<script>
    const stationFilter = document.getElementById("stationFilter");

    let stations = [];

    // Fetch stations on load
(function fetchStations() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/stations', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);
            stations = response.data || [];

                stations.forEach((station) => {
        const option = document.createElement("option");
        option.value = station.id;
        option.textContent = `${station.name} (${station.code})`;
        option.selected =
            station.id == "<?php echo htmlspecialchars($searchParams['station'] ?? ''); ?>";
        stationFilter.appendChild(option);
    });

        }
    };
    xhr.send();
})();

// Filter state
let searchQuery = "<?php echo htmlspecialchars($searchParams['query'] ?? ''); ?>";
let selectedStation = "<?php echo htmlspecialchars($searchParams['station'] ?? 'all'); ?>";
let selectedType = "<?php echo htmlspecialchars($searchParams['type'] ?? 'all'); ?>";
let debounceTimer;
const timeout = 300; 

document.getElementById("typeFilter").value =selectedType;


// Event listeners
document.getElementById("searchInput").addEventListener("input", (e) => {
  searchQuery = e.target.value;
  filter();
});

document.getElementById("stationFilter").addEventListener("change", (e) => {
  selectedStation = e.target.value;
  filter();
});

document.getElementById("typeFilter").addEventListener("change", (e) => {
  selectedType = e.target.value;
  filter();
});

function filter() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        window.location.href = `/dashboard?query=${encodeURIComponent(
            searchQuery,
        )}&station=${encodeURIComponent(selectedStation)}&type=${encodeURIComponent(selectedType)}`;
    }, timeout);
}

function toggleFavorite(trainId, userId) {
    const favoriteBtn = document.getElementById(`favoriteBtn-${trainId}`);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/favorites/toggle', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                if (xhr.status === 200) {
                    favoriteBtn.title = 'Add to favorites';
                    favoriteBtn.innerHTML = `
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        `;
                    showToast('Favorite removed successfully.', 'success');
                } else {
                    favoriteBtn.title = 'Remove from favorites';
                    favoriteBtn.innerHTML = `
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        `;
                    showToast('Favorite added successfully.', 'success');
                }
            } else {
                showToast(response.message, 'error');
            }
        }
    };
    xhr.send(JSON.stringify({ user_id: userId, train_id: trainId }));
}

</script>

<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
