<?php
$metadata['title'] = 'Dashboard - Report Issue | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/general.php';
include_once BASE_PATH . '/app/controllers/ReportsController.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reported_by = $_SESSION['user']['id'];
    $issueTrain = !empty($_POST['issueTrain']) ? $_POST['issueTrain'] : null;
    $category = trim($_POST['category']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $reportsController = new ReportsController($_SERVER['REQUEST_URI']);
    $response = $reportsController->createReport(
        $reported_by,
        $issueTrain,
        $category,
        $title,
        $description,
    );

    if (!$response['success']) {
        if ($response['status'] === 'VALIDATION_ERROR') {
            $errors = $response['errors'];
        } else {
            echo "<script>showToast('Error: " . $response['message'] . "', 'error');</script>";
        }
    } else {
        $reports[] = $response['data'];
        echo "<script>showToast('Success: Report submitted successfully!', 'success');</script>";
    }
}
?>

<main class="dashboard-main">
    <div class="max-w-4xl mx-auto space-y-6">
      <div class="card">
        <div class="card__header">
          <h2 class="card__title">Report an Issue</h2>
          <p class="card__description">Help us improve by reporting problems you encounter</p>
        </div>
        <div class="card__content">
          <form action="<?php echo $_SERVER[
              'REQUEST_URI'
          ]; ?>" method="POST" id="reportIssueForm" class="space-y-4">
            <div class="form-group">
              <label class="label" for="category">Issue Type</label>
              <select id="category" name="category" class="select" required="">
                <option value="">Select issue type</option>
                <option value="delay">Train Delay</option>
                <option value="cancellation">Train Cancellation</option>
                <option value="technical">Technical Issue</option>
                <option value="safety">Safety Concern</option>
                <option value="other">Other</option>
              </select>
              <?php if (isset($errors['category'])) { ?>
                <p class="text-sm text-red-500 mt-1"><?php echo $errors['category']; ?></p>
              <?php } ?>
            </div>
            
            <div class="form-group">
              <label class="label" for="issueTrain">Train (Optional)</label>
              <select id="issueTrain" name="issueTrain" class="select">
                <option value="">Select a train</option>
                <?php foreach ($trains as $train) { ?>
                  <option value="<?php echo $train['id']; ?>"><?php echo htmlspecialchars(
    $train['name'],
); ?></option>
                <?php } ?>
              </select>
                 <?php if (isset($errors['issueTrain'])) { ?>
                <p class="text-sm text-red-500 mt-1"><?php echo $errors['issueTrain']; ?></p>
              <?php } ?>
            </div>
            
            <div class="form-group">
              <label class="label" for="issueTitle">Issue Title</label>
              <input type="text" id="issueTitle" name="title" class="input" placeholder="Brief description of the issue" required="">
                 <?php if (isset($errors['title'])) { ?>
                <p class="text-sm text-red-500 mt-1"><?php echo $errors['title']; ?></p>
              <?php } ?>
            </div>
            
            <div class="form-group">
              <label class="label" for="issueDescription">Description</label>
              <textarea id="issueDescription" name="description" class="input" rows="5" placeholder="Provide detailed information about the issue" required=""></textarea>
            <?php if (isset($errors['description'])) { ?>
                <p class="text-sm text-red-500 mt-1"><?php echo $errors['description']; ?></p>
              <?php } ?>
            </div>
            
            <button type="submit" class="btn btn--default btn--full">
              <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
              </svg>
              Submit Report
            </button>
          </form>
        </div>
      </div>
      
      <div class="card">
        <div class="card__header">
          <h2 class="card__title">My Reports</h2>
          <p class="card__description">Track the status of your submitted issues</p>
        </div>
        <div class="card__content">
          <?php if (empty($reports)) { ?>
            <p>You have not submitted any reports yet.</p>
            <?php } else {foreach ($reports as $report) { ?>
                    <div class="space-y-3">
      <div class="p-4 border border-gray-200 rounded-lg">
        <div class="flex items-start justify-between mb-2">
          <div>
            <h4 class="font-semibold"><?php echo htmlspecialchars($report['title']); ?></h4>
            <p class="text-sm text-gray-500"><?php echo htmlspecialchars(
                $report['category'],
            ); ?></p>
          </div>
          <span class="badge badge--secondary uppercase"><?php echo htmlspecialchars(
              $report['status'],
          ); ?></span>
        </div>
        <p class="text-sm text-gray-600 mb-2"><?php echo htmlspecialchars(
            $report['description'],
        ); ?></p>
        <p class="text-xs text-gray-400">Reported on 1/20/2026, 6:01:25 AM</p>
      </div>
            <?php }} ?>
    </div>
        </div>
      </div>
      
    </div>

</main>

<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
