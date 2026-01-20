<?php
$metadata['title'] = 'Admin Dashboard - Monitor | Smart Route Tracker';
$metadata['styles'][] = '/assets/css/modal.css';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/admin.php';
?>

    <main class="dashboard-main">
      <div class="dashboard-content space-y-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold">Station Management</h2>
            <p class="text-gray-500">
              Manage station information and facilities
            </p>
          </div>
          <button class="btn btn--default" onclick="openAddStationDialog()">
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
                d="M12 4v16m8-8H4"
              />
            </svg>
            Add Station
          </button>
        </div>

        <div class="grid sm-grid-cols-2 gap-4" id="stationsGrid">
            <?php foreach ($stations as $station) { ?>
<div class="card" data-station-id="<?php echo htmlspecialchars($station['id']); ?>">
      <div class="card__content p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-lg font-semibold"> <?php echo htmlspecialchars(
                $station['name'],
            ); ?> </h3>
            <p class="text-sm text-gray-500"><?php echo htmlspecialchars(
                $station['code'],
            ); ?> • <?php echo htmlspecialchars($station['city']); ?>, <?php echo htmlspecialchars(
    $station['state'],
); ?></p>
          </div>
          <div class="flex gap-2">
            <button class="btn btn--ghost btn--icon" onclick="openEditStationDialog(<?php echo htmlspecialchars(
                json_encode($station),
            ); ?>)" title="Edit">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            <button class="btn btn--ghost btn--icon" onclick="deleteStation('<?php echo htmlspecialchars(
                $station['id'],
            ); ?>')" title="Delete">
              <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="space-y-2 text-sm">
          <p>
            <span class="text-gray-500">Platforms:</span> 
            <span class="font-medium"><?php echo htmlspecialchars($station['platforms']); ?></span>
          </p>
        </div>
      </div>
    </div>
                <?php } ?>
        </div>
      </div>
    </main>

    <div class="dialog-overlay" id="stationDialog">
      <div class="dialog dialog--large">
        <button class="dialog__close" onclick="closeModal('stationDialog')">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>

        <div class="dialog__header">
          <h2 class="dialog__title" id="dialogTitle">Add New Station</h2>
          <p class="dialog__description">Enter station details</p>
        </div>

        <div class="dialog__content">
          <form id="stationForm" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div class="form-group">
                <label class="label" for="stationName">Station Name *</label>
                <input
                  type="text"
                  id="stationName"
                  class="input"
                  placeholder="Central Station"
                  required
                />
                <p class="text-sm text-red-600 mt-1" id="nameError">
      
                </p>
              </div>
              <div class="form-group">
                <label class="label" for="stationCode">Station Code *</label>
                <input
                  type="text"
                  id="stationCode"
                  class="input"
                  placeholder="CST"
                  required
                  maxlength="5"
                />
                <p class="text-sm text-red-600 mt-1" id="codeError">
          
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="form-group">
                <label class="label" for="stationCity">City *</label>
                <input
                  type="text"
                  id="stationCity"
                  class="input"
                  placeholder="New York"
                  required
                />
                <p class="text-sm text-red-600 mt-1" id="cityError">
      
                </p>
              </div>
              <div class="form-group">
                <label class="label" for="stationState">State *</label>
                <input
                  type="text"
                  id="stationState"
                  class="input"
                  placeholder="NY"
                  required
                />
                <p class="text-sm text-red-600 mt-1" id="stateError"></p>
              </div>
            </div>


            <div class="form-group">
              <label class="label" for="stationPlatforms"
                >Number of Platforms *</label
              >
              <input
                type="number"
                id="stationPlatforms"
                class="input"
                placeholder="12"
                min="1"
                required
              />
              <p class="text-sm text-red-600 mt-1" id="platformsError"></p>
            </div>

               <div class="dialog__footer">
          <button
            type="submit"
            class="btn btn--default"

          >
            <span id="saveButtonText">Add Station</span>
          </button>
          <button
            type="button"
            class="btn btn--outline"
            onclick="closeModal('stationDialog')"
          >
            Cancel
          </button>
        </div>
          </form>
        </div>

     
      </div>
    </div>

<script src="/assets/js/dashboard/admin/stations.js"></script>
<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
