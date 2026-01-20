<?php
$metadata['title'] = 'Dashboard - Profile | Smart Route Tracker';
$metadata['styles'] = ['/assets/css/dashboard.css'];
include_once BASE_PATH . '/app/views/layouts/general/header.php';

$user = SessionMiddleware::getCurrentUser();
$errors;
$message;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once BASE_PATH . '/app/controllers/AuthController.php';

    if (isset($_POST['form_name']) && $_POST['form_name'] === 'profile') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        $authController = new AuthController();
        $response = $authController->updateProfile($user['id'], $fullName, $email, $phone);
        $message = $response['message'] ?? '';

        if ($response['success']) {
            $_SESSION['user']['full_name'] = $fullName;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;

            $user = SessionMiddleware::getCurrentUser();
        } else {
            $errors = $response['errors'] ?? [];
        }
    } elseif (isset($_POST['form_name']) && $_POST['form_name'] === 'security') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        $authController = new AuthController();
        $response = $authController->changePassword($user['id'], $currentPassword, $newPassword);
        $message = $response['message'] ?? '';

        if (!$response['success']) {
            $errors = $response['errors'] ?? [];
        }
    } elseif (isset($_POST['form_name']) && $_POST['form_name'] === 'profile_picture') {
        require_once BASE_PATH . '/app/controllers/AuthController.php';
        $authController = new AuthController();

        if (isset($_FILES['profile_picture'])) {
            $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
            $fileName = $_FILES['profile_picture']['name'];
            $fileSize = $_FILES['profile_picture']['size'];
            $fileType = $_FILES['profile_picture']['type'];

            $response = $authController->updateProfilePicture(
                $user['id'],
                $fileTmpPath,
                $fileName,
                $fileSize,
                $fileType,
            );
            $message = $response['message'] ?? '';

            if ($response['success']) {
                $_SESSION['user']['profile_picture'] = $response['data']['profile_picture'] ?? '';
                $user = SessionMiddleware::getCurrentUser();
            } else {
                $errors = $response['errors'] ?? [];
            }
        } else {
            $message = 'No file uploaded or there was an upload error.';
        }
    }
}
?>
<style>
    .tabs {
      width: 100%;
    }
    
    .tabs__list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      background-color: var(--gray-100);
      border-radius: var(--radius);
      padding: 0.25rem;
      gap: 0.25rem;
    }
    
    .tabs__trigger {
      padding: 0.5rem 1rem;
      border-radius: var(--radius);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 150ms;
      color: var(--gray-700);
    }
    
    .tabs__trigger--active {
      background-color: white;
      color: var(--gray-900);
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    .tabs__content {
      display: none;
      margin-top: 1.5rem;
    }
    
    .tabs__content--active {
      display: block;
    }
    
    .profile-avatar {
      width: 6rem;
      height: 6rem;
      border-radius: 9999px;
      background-color: var(--blue-100);
      color: var(--blue-700);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 600;
      overflow: hidden;
      cursor: pointer;
    }

    .profile-avatar img {
        height: 100%;
        object-fit: cover;
    }
</style>

<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container py-4">
        <a href="<?php echo $user['user_type'] === 'admin'
            ? '/dashboard/admin'
            : '/dashboard'; ?>" class="btn btn--ghost">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                />
            </svg>
            Back to Dashboard
        </a>
    </div>
</header>

<main class="container py-8">
    <div class="container--max-4xl mx-auto space-y-6">
        <div class="card">
            <div class="card__content p-6">
                <div class="flex items-center gap-6">
                    <form enctype="multipart/form-data" id="profilePictureForm" action="<?php echo $_SERVER[
                        'REQUEST_URI'
                    ]; ?>" method="POST">
                    <div class="profile-avatar" id="profileAvatar"><?php if (
                        !empty($user['profile_picture'])
                    ) {
                        echo '<img src="' . $user['profile_picture'] . '" alt="Profile Picture" />';
                    } else {
                        echo strtoupper(
                            implode(
                                '',
                                array_map(
                                    fn($name) => $name[0],
                                    explode(' ', $user['full_name'] ?? ''),
                                ),
                            ),
                        );
                    } ?>
                </div>
                   <input type="file" name="profile_picture" id="profile_picture" hidden />
                    <input type="hidden" name="form_name" value="profile_picture">
                </form>
                    <div>
                        <h1 class="text-2xl font-bold" id="profileName"><?php echo $user[
                            'full_name'
                        ]; ?></h1>
                        <p class="text-gray-500" id="profileEmail"><?php echo $user['email']; ?></p>
                        <p class="text-sm text-gray-400 mt-1">
                            Account Type: <span id="profileType"><?php echo $user[
                                'user_type'
                            ]; ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Tabs -->
        <div class="tabs">
            <div class="tabs__list">
                <button class="tabs__trigger tabs__trigger--active" data-tab="profile">
                    Profile Info
                </button>
                <button class="tabs__trigger" data-tab="security">Security</button>
            </div>

            <!-- Profile Info -->
            <div class="tabs__content tabs__content--active" id="profile-tab">
                <div class="card">
                    <div class="card__header">
                        <h2 class="card__title">Profile Information</h2>
                        <p class="card__description">Update your personal information</p>
                    </div>
                    <div class="card__content">
                        <form action="<?php echo $_SERVER[
                            'REQUEST_URI'
                        ]; ?>" method="POST" id="profileForm" class="space-y-4">
                            <div class="form-group">
                                <label class="label" for="full_name">Full Name</label>
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
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    <input type="text" name="full_name" id="full_name" class="input pl-10" value="<?php echo $user[
                                        'full_name'
                                    ]; ?>" required />
                                </div>
                                <p class="text-sm text-red-600 mt-1" id="nameError">
                                    <?php echo $errors['full_name'] ?? ''; ?>
                                </p>
                            </div>

                            <div class="form-group">
                                <label class="label" for="email">Email</label>
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
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <input type="email" name="email" id="email" value="<?php echo $user[
                                        'email'
                                    ]; ?>" class="input pl-10" required />
                                </div>
                                <p class="text-sm text-red-600 mt-1" id="emailError">
                                    <?php echo $errors['email'] ?? ''; ?>
                                </p>
                            </div>

                            <div class="form-group">
                                <label class="label" for="phone">Phone Number</label>
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
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        />
                                    </svg>
                                    <input
                                        type="tel"
                                        name="phone"
                                        id="phone"
                                        value="<?php echo $user['phone']; ?>"
                                        class="input pl-10"
                                        placeholder="+1234567890"
                                    />
                                </div>
                                <p class="text-sm text-red-600 mt-1" id="phoneError">
                                    <?php echo $errors['phone'] ?? ''; ?>
                                </p>
                            </div>
                            <input type="hidden" name="form_name" value="profile">
                            <button type="submit" class="btn btn--default btn--full">
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
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
                                    />
                                </svg>
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security -->
            <div class="tabs__content" id="security-tab">
                <div class="card">
                    <div class="card__header">
                        <h2 class="card__title">Change Password</h2>
                        <p class="card__description">
                            Update your password to keep your account secure
                        </p>
                    </div>
                    <div class="card__content">
                        <form action="<?php echo $_SERVER[
                            'REQUEST_URI'
                        ]; ?>" method="POST" id="passwordForm" class="space-y-4">
                            <div class="form-group">
                                <label class="label" for="currentPassword">Current Password</label>
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
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                    <input
                                        name="current_password"
                                        type="password"
                                        id="currentPassword"
                                        class="input pl-10"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label" for="newPassword">New Password</label>
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
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                    <input
                                        name="new_password"
                                        type="password"
                                        id="newPassword"
                                        class="input pl-10"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label" for="confirmNewPassword"
                                    >Confirm New Password</label
                                >
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
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                    <input
                                        type="password"
                                        name="confirm_new_password"
                                        id="confirmNewPassword"
                                        class="input pl-10"
                                        required
                                    />
                                </div>
                            </div>
                            <input type="hidden" name="form_name" value="security">
                            <button type="submit" class="btn btn--default btn--full">
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
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    />
                                </svg>
                                Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    <?php if (isset($message) && !empty($message)) { ?>
        showToast("<?php echo $message; ?>", "<?php echo $response['success']
    ? 'success'
    : 'error'; ?>");
    <?php } ?>

    const user = <?php echo json_encode($user); ?>;
</script>

<script src="/assets/js/dashboard/profile.js"></script>
<?php include_once BASE_PATH . '/app/views/layouts/general/footer.php'; ?>
