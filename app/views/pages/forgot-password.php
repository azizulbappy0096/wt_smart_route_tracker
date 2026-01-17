<?php
$metadata = [
    'title' => 'Forgot Password - Smart Route Tracker',
    'styles' => ['/assets/css/auth.css'],
];
include_once __DIR__ . '/../layouts/general/header.php';
?>

<main class="page-auth">
  <div class="auth-container">
    <a href="/login" class="btn btn--ghost mb-4">
      <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Back to Login
    </a>

    <div class="card">
      <div class="card__header text-center">
        <div class="flex items-center justify-center mb-4">
          <div class="bg-blue-600 p-3 rounded-lg">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </div>
        </div>
        <h2 class="card__title">Reset Password</h2>
        <p class="card__description">Enter your email address and we'll send you instructions to reset your password</p>
      </div>
      
      <div class="card__content">
        <form id="forgotForm" class="space-y-4">
          <div class="form-group">
            <label class="label" for="email">Email</label>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <input type="email" id="email" class="input pl-10" placeholder="user@traintracker.com" required>
            </div>
          </div>

          <button type="submit" class="btn btn--default btn--full" id="submitBtn">Send Reset Link</button>
        </form>

        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Remember your password? </span>
          <a href="/login" class="btn btn--link">Sign in</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include_once __DIR__ . '/../layouts/general/footer.php'; ?>
