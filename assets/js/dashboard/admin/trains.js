const trainForm = document.getElementById('trainForm');
const addTrainButton = document.getElementById('addTrainButton');
let stations = [];
let editingTrainId = null;
let selectedIntermediateStations = [];
let generatedRoute = [];
let isSelectionPopulated = false;

// Fetch stations on load
(function fetchStations() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/stations', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);
            stations = response.data || [];
            populateStationSelects();
        }
    };
    xhr.send();
})();

function populateStationSelects() {
    if (isSelectionPopulated) return;
    const startStation = document.getElementById('startStation');
    const endStation = document.getElementById('endStation');
    const intermediateStation = document.getElementById('intermediateStation');

    stations.forEach((station) => {
        const optionStart = document.createElement('option');
        optionStart.value = station.id;
        optionStart.textContent = `${station.name} (${station.code})`;
        startStation.appendChild(optionStart.cloneNode(true));

        const optionEnd = document.createElement('option');
        optionEnd.value = station.id;
        optionEnd.textContent = `${station.name} (${station.code})`;
        endStation.appendChild(optionEnd);
    });

    document.getElementById('startStation').addEventListener('change', updateIntermediateOptions);
    document.getElementById('endStation').addEventListener('change', updateIntermediateOptions);
    isSelectionPopulated = true;
}

function updateIntermediateOptions() {
    const startStationId = document.getElementById('startStation').value;
    const endStationId = document.getElementById('endStation').value;
    const intermediateStation = document.getElementById('intermediateStation');

    intermediateStation.innerHTML = '<option value="">Add stations to route</option>';

    stations.forEach((station) => {
        if (
            station.id != startStationId &&
            station.id != endStationId &&
            !selectedIntermediateStations.includes(station.id)
        ) {
            const option = document.createElement('option');
            option.value = station.id;
            option.textContent = `${station.name} (${station.code})`;
            intermediateStation.appendChild(option);
        }
    });
}

function addIntermediateStation() {
    const select = document.getElementById('intermediateStation');
    const stationId = select.value;

    if (stationId && !selectedIntermediateStations.includes(stationId)) {
        selectedIntermediateStations.push(stationId);
        renderSelectedStations();
        updateIntermediateOptions();
        select.value = '';
    }
    generateRoute();
}

function removeIntermediateStation(stationId) {
    selectedIntermediateStations = selectedIntermediateStations.filter((id) => id !== stationId);
    renderSelectedStations();
    updateIntermediateOptions();
    generateRoute();
}

function renderSelectedStations() {
    const container = document.getElementById('selectedStations');
    const containerWrapper = document.getElementById('selectedStationsContainer');

    if (selectedIntermediateStations.length == 0) {
        containerWrapper.classList.add('hidden');
        return;
    }

    containerWrapper.classList.remove('hidden');
    container.innerHTML = '';

    selectedIntermediateStations.forEach((stationId, index) => {
        const station = stations.find((s) => s.id == stationId);
        if (station) {
            const chip = document.createElement('div');
            chip.className = 'station-chip';
            chip.innerHTML = `
        ${index + 1}. ${station.name}
        <button type="button" class="station-chip__remove" onclick="removeIntermediateStation('${stationId}')">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      `;
            container.appendChild(chip);
        }
    });
}

function generateRoute() {
    const startStationId = document.getElementById('startStation').value;
    let departureTime = document.getElementById('departureTime').value;
    const endStationId = document.getElementById('endStation').value;
    const speed = parseInt(document.getElementById('trainSpeed').value) || 80;
    departureTime = new Date(departureTime).toISOString();

    if (!startStationId || !endStationId || !departureTime) {
        return;
    }

    const allStationIds = [startStationId, ...selectedIntermediateStations, endStationId];
    const route = [];
    let cumulativeDistance = 0;

    allStationIds.forEach((stationId, index) => {
        const station = stations.find((s) => s.id == stationId);
        if (!station) return;

        const distanceFromPrev = index == 0 ? 0 : Math.floor(Math.random() * 100) + 50;
        cumulativeDistance += distanceFromPrev;
        const arrivalTime =
            index == 0
                ? departureTime
                : new Date(
                      new Date(departureTime).getTime() +
                          (cumulativeDistance / speed) * 60 * 60 * 1000,
                  ).toISOString();
        departureTime = new Date(new Date(arrivalTime).getTime() + 10 * 60 * 1000).toISOString();

        route.push({
            stationId: station.id,
            stationName: station.name,
            platform: Math.floor(Math.random() * station.platforms) + 1,
            distance: cumulativeDistance,
            arrivalTime,
            departureTime: index == allStationIds.length - 1 ? null : departureTime,
        });
    });

    generatedRoute = route;
    renderRoutePreview();
    showToast('Route generated successfully!', 'success');
}

function renderRoutePreview() {
    const preview = document.getElementById('routePreview');
    const section = document.getElementById('routePreviewSection');
    const summary = document.getElementById('routeSummary');

    if (generatedRoute.length == 0) {
        section.classList.add('hidden');
        return;
    }

    section.classList.remove('hidden');
    preview.innerHTML = '';

    generatedRoute.forEach((stop, index) => {
        const isFirst = index == 0;
        const isLast = index == generatedRoute.length - 1;
        const showLine = !isLast;

        const stopDiv = document.createElement('div');
        stopDiv.className = 'route-preview__stop';
        stopDiv.innerHTML = `
      <div class="route-preview__marker">
        <div class="route-preview__dot ${isFirst ? 'route-preview__dot--start' : isLast ? 'route-preview__dot--end' : 'route-preview__dot--intermediate'}"></div>
        ${showLine ? '<div class="route-preview__line"></div>' : ''}
      </div>
      <div class="route-preview__info">
        <p class="route-preview__station-name">${stop.stationName}</p>
        <p class="route-preview__station-details">Platform ${stop.platform} • ${stop.distance} km</p>
      </div>
        <div class="route-preview__times">
        <p class="route-preview__time">Arr: ${new Date(stop.arrivalTime).toLocaleTimeString()}</p>
        ${!isLast ? `<p class="route-preview__time--secondary">Dep: ${new Date(stop.departureTime).toLocaleTimeString()}</p>` : ''}
      </div>
    `;
        preview.appendChild(stopDiv);
    });
}

function openAddTrainDialog() {
    editingTrainId = null;
    selectedIntermediateStations = [];
    generatedRoute = [];
    trainForm.reset();
    document.getElementById('dialogTitle').textContent = 'Add New Train';
    document.getElementById('saveButtonText').textContent = 'Save Train';
    document.getElementById('routePreviewSection').classList.add('hidden');
    document.getElementById('selectedStationsContainer').classList.add('hidden');
    populateStationSelects();
    openModal('trainDialog');
}

function openEditTrainDialog(train) {
    editingTrainId = train.id;
    document.getElementById('dialogTitle').textContent = 'Edit Train';
    document.getElementById('saveButtonText').textContent = 'Update Train';
    console.log(train);
    document.getElementById('trainNumber').value = train.number;
    document.getElementById('trainName').value = train.name;
    document.getElementById('trainType').value = train.type;
    document.getElementById('trainSpeed').value = train.speed;
    document.getElementById('startStation').value = train.route[0].station_id;
    document.getElementById('endStation').value = train.route[train.route.length - 1].station_id;
    document.getElementById('departureTime').value = train.route[0].departure_time.slice(0, 16);

    selectedIntermediateStations = train.route.slice(1, -1).map((r) => r.station_id);
    generatedRoute = train.route.map((r) => ({
        stationId: r.station_id,
        stationName: r.station_name,
        platform: r.platform,
        arrivalTime: r.arrival_time,
        departureTime: r.departure_time,
        distance: r.distance,
    }));

    populateStationSelects();
    renderSelectedStations();
    renderRoutePreview();
    openModal('trainDialog');
}

function saveTrain() {
    const trainNumber = document.getElementById('trainNumber').value.trim();
    const trainName = document.getElementById('trainName').value.trim();
    const trainType = document.getElementById('trainType').value;
    const speed = parseInt(document.getElementById('trainSpeed').value) || 80;
    const departureTime = document.getElementById('departureTime').value;
    const startStationId = document.getElementById('startStation').value;
    const endStationId = document.getElementById('endStation').value;

    // Clear previous errors
    document.getElementById('trainNumberError').textContent = '';
    document.getElementById('trainNameError').textContent = '';
    document.getElementById('trainTypeError').textContent = '';
    document.getElementById('trainSpeedError').textContent = '';
    document.getElementById('departureTimeError').textContent = '';

    let errors = {
        trainNumber: false,
        trainName: false,
        trainType: false,
        trainSpeed: false,
        departureTime: false,
    };

    if (!trainNumber) {
        errors.trainNumber = true;
        document.getElementById('trainNumberError').textContent = 'Train number is required.';
    }
    if (!trainName) {
        errors.trainName = true;
        document.getElementById('trainNameError').textContent = 'Train name is required.';
    }
    if (!trainType) {
        errors.trainType = true;
        document.getElementById('trainTypeError').textContent = 'Train type is required.';
    }
    if (!speed || speed <= 0) {
        errors.trainSpeed = true;
        document.getElementById('trainSpeedError').textContent = 'Valid speed is required.';
    }
    if (!departureTime) {
        errors.departureTime = true;
        document.getElementById('departureTimeError').textContent = 'Departure time is required.';
    }

    if (generatedRoute.length === 0) {
        showToast('Please generate a valid route before saving.', 'error');
        return;
    }

    if (Object.values(errors).some((e) => e)) {
        return;
    }

    const trainData = {
        name: trainName,
        number: trainNumber,
        type: trainType,
        speed: speed,
        departureTime: new Date(departureTime).toISOString(),
        route: generatedRoute,
        start_station: startStationId,
        end_station: endStationId,
    };

    const xhr = new XMLHttpRequest();
    const url = editingTrainId ? `/api/trains/update` : '/api/trains/add';
    const method = editingTrainId ? 'PUT' : 'POST';

    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200 || xhr.status == 201) {
                const response = JSON.parse(xhr.responseText);
                closeModal('trainDialog');
                renderTrains(response.data);
                showToast(response.message, 'success');
            }
        }
    };
    xhr.send(JSON.stringify(trainData));
}

function getStatusBadgeClass(status) {
    switch (status) {
        case 'on-time':
            return 'badge--green';
        case 'delayed':
            return 'badge--yellow';
        case 'stopped':
            return 'badge--red';
        default:
            return 'badge--gray';
    }
}

function renderTrains(train) {
    const container = document.getElementById('trainsContainer');

    let card = document.createElement('div');
    let existingCard = container.querySelector(`[data-train-id='${train.id}']`);
    if (existingCard) {
        card = existingCard;
    }

    card.className = 'card';
    card.setAttribute('data-train-id', train.id);
    card.innerHTML = `
      <div class="card__content p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <div class="flex items-center gap-3 mb-1">
              <h3 class="text-lg font-semibold">${train.name}</h3>
              <span class="badge badge--outline">${train.type}</span>
              <span class="badge ${getStatusBadgeClass(train.status)}">${train.status.replace('-', ' ').toUpperCase()}</span>
            </div>
            <p class="text-sm text-gray-500">Train #${train.number}</p>
          </div>
          <div class="flex gap-2">
            <button class="btn btn--ghost btn--icon" onclick='openEditTrainDialog(${JSON.stringify(train).replace(/'/g, '&apos;')})'>
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            <button class="btn btn--ghost btn--icon" onclick="deleteTrain('${train.id}')">
              <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="train-card__route mb-4">
          <div class="flex items-center gap-2 text-sm">
            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="font-medium">${train.route[0]?.station_name || 'N/A'}</span>
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
            <span class="text-gray-500">${train.route.length - 2} stops</span>
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
            <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="font-medium">${train.route[train.route.length - 1]?.station_name || 'N/A'}</span>
          </div>
        </div>

        <div class="grid sm-grid-cols-4 gap-4 mb-4">
          <div>
            <p class="text-sm text-gray-500">Current Location</p>
            <p class="font-medium">${train?.current_station_name || 'N/A'}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Speed</p>
            <p class="font-medium">${train.speed} km/h</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Next Station</p>
            <p class="font-medium">${train?.next_station_name || 'N/A'}</p>
          </div>
        </div>

        <div class="train-card__status-buttons">
          <span class="train-card__status-label">Update Status:</span>
          <button class="btn btn--${train.status == 'on-time' ? 'default' : 'outline'} btn--sm" onclick="updateStatus('${train.id}', 'on-time')">
            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            On Time
          </button>
          <button class="btn btn--${train.status == 'delayed' ? 'default' : 'outline'} btn--sm" onclick="updateStatus('${train.id}', 'delayed')">
            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Delayed
          </button>
          <button class="btn btn--${train.status == 'stopped' ? 'default' : 'outline'} btn--sm" onclick="updateStatus('${train.id}', 'stopped')">
            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Stopped
          </button>
        </div>
      </div>
    `;

    !existingCard && container.prepend(card);
}

function updateStatus(id, status) {
    const train = allTrains.find((t) => t.id == id);
    if (train) {
        train.status = status;
        const xhr = new XMLHttpRequest();
        xhr.open('PUT', '/api/trains/status', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    showToast(`Train status updated to ${status}`, 'success');
                    renderTrains(train);
                }
            }
        };
        xhr.send(JSON.stringify({ id: id, status: status }));
    }
}

function deleteTrain(id) {
    if (confirm('Are you sure you want to delete this train?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `/api/trains/delete?id=${id}`, true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    showToast('Train deleted successfully!', 'success');
                    document
                        .getElementById('trainsContainer')
                        .removeChild(document.querySelector(`[data-train-id='${id}']`));
                }
            }
        };
        xhr.send();

        // const index = allTrains.findIndex((t) => t.id == id);
        // if (index > -1) {
        //     const trainName = allTrains[index].trainName;
        //     allTrains.splice(index, 1);
        //     showToast(`${trainName} deleted successfully!`, 'success');

        // }
    }
}

trainForm.addEventListener('submit', (e) => {
    e.preventDefault();
    saveTrain();
});
addTrainButton.addEventListener('click', openAddTrainDialog);
