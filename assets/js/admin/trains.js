const addTrainButton = document.getElementById('addTrainButton');

function openAddTrainDialog() {
    editingTrainId = null;
    selectedIntermediateStations = [];
    generatedRoute = [];
    document.getElementById('trainForm').reset();
    document.getElementById('dialogTitle').textContent = 'Add New Train';
    document.getElementById('saveButtonText').textContent = 'Save Train';
    document.getElementById('routePreviewSection').classList.add('hidden');
    document.getElementById('selectedStationsContainer').classList.add('hidden');

    openModal('trainDialog');
}

addTrainButton.addEventListener('click', openAddTrainDialog);
