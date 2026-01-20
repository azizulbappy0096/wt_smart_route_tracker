let editingStationId = null;
const stationForm = document.getElementById('stationForm');

function renderStations(station) {
    const grid = document.getElementById('stationsGrid');

    const card = document.createElement('div');
    card.className = 'card';

    card.innerHTML = `
      <div class="card__content p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-lg font-semibold">${station.name}</h3>
            <p class="text-sm text-gray-500">${station.code} • ${station.city}, ${station.state}</p>
          </div>
          <div class="flex gap-2">
            <button class="btn btn--ghost btn--icon" onclick='openEditStationDialog(${JSON.stringify(station).replace(/'/g, '&apos;')})' title="Edit">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            <button class="btn btn--ghost btn--icon" onclick="deleteStation('${station.id}')" title="Delete">
              <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="space-y-2 text-sm">
          <p>
            <span class="text-gray-500">Platforms:</span> 
            <span class="font-medium">${station.platforms}</span>
          </p>

        </div>
      </div>
    `;

    grid.prepend(card);
}

function updateStationInUI(station) {
    const grid = document.getElementById('stationsGrid');
    const cards = grid.getElementsByClassName('card');
    for (let card of cards) {
        const title = card.querySelector('h3');
        if (station.id == card.getAttribute('data-station-id')) {
            title.textContent = station.name;
            const info = card.querySelector('p.text-sm');
            info.textContent = `${station.code} • ${station.city}, ${station.state}`;
            const platforms = card.querySelector('span.font-medium');
            platforms.textContent = station.platforms;
            break;
        }
    }
}

function openAddStationDialog() {
    editingStationId = null;
    stationForm.reset();
    document.getElementById('dialogTitle').textContent = 'Add New Station';
    document.getElementById('saveButtonText').textContent = 'Add Station';
    openModal('stationDialog');
}

function openEditStationDialog(station) {
    editingStationId = station.id;
    document.getElementById('dialogTitle').textContent = 'Edit Station';
    document.getElementById('saveButtonText').textContent = 'Update Station';

    document.getElementById('stationName').value = station.name;
    document.getElementById('stationCode').value = station.code;
    document.getElementById('stationCity').value = station.city;
    document.getElementById('stationState').value = station.state;
    document.getElementById('stationPlatforms').value = station.platforms;

    openModal('stationDialog');
}

function saveStation() {
    const name = document.getElementById('stationName').value.trim();
    const code = document.getElementById('stationCode').value.trim().toUpperCase();
    const city = document.getElementById('stationCity').value.trim();
    const state = document.getElementById('stationState').value.trim();
    const platforms = parseInt(document.getElementById('stationPlatforms').value);

    let errors = {
        name: '',
        code: '',
        city: '',
        state: '',
        platforms: '',
    };

    if (!name) {
        document.getElementById('nameError').textContent = 'Station name is required.';
        errors.name = 'Station name is required.';
    }
    if (!code) {
        document.getElementById('codeError').textContent = 'Station code is required.';
        errors.code = 'Station code is required.';
    }
    if (!city) {
        document.getElementById('cityError').textContent = 'City is required.';
        errors.city = 'City is required.';
    }
    if (!state) {
        document.getElementById('stateError').textContent = 'State is required.';
        errors.state = 'State is required.';
    }
    if (isNaN(platforms) || platforms < 1) {
        document.getElementById('platformsError').textContent = 'Platforms must be at least 1.';
        errors.platforms = 'Platforms must be at least 1.';
    }
    if (Object.values(errors).some((err) => err !== '')) {
        return;
    }

    const stationData = {
        name,
        code,
        city,
        state,
        platforms,
    };

    const xhr = new XMLHttpRequest();
    if (editingStationId) {
        stationData.id = editingStationId;
        xhr.open('PUT', `/api/stations/update`);
    } else {
        xhr.open('POST', '/api/stations/add');
    }

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 || xhr.status === 201) {
                const response = JSON.parse(xhr.responseText);
                closeModal('stationDialog');
                xhr.status === 201 ? renderStations(response.data) : updateStationInUI(stationData);
                showToast('Station saved successfully', 'success');
            } else {
                showToast('Error saving station', 'error');
            }
        }
    };
    xhr.send(JSON.stringify(stationData));
}

function deleteStation(id) {
    if (!confirm('Are you sure you want to delete this station?')) {
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open('DELETE', `/api/stations/delete?id=${id}`);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.querySelector(`.card[data-station-id='${id}']`).remove();
                showToast('Station deleted successfully', 'success');
            } else {
                showToast('Error deleting station', 'error');
            }
        }
    };
    xhr.send();
}

stationForm.addEventListener('submit', (e) => {
    e.preventDefault();
    saveStation();
});
