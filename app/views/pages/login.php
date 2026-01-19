<?php
$metadata = [
    'title' => 'Login - Smart Route Tracker',
    'styles' => ['/assets/css/auth.css'],
];
include_once BASE_PATH . '/app/views/layouts/general/header.php';
?>

<main class="page-auth">
  <div class="auth-container">
    <a href="/" class="btn btn--ghost mb-4">
      <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Back to Home
    </a>

    <div class="card">
      <div class="card__header text-center">
        <div class="flex items-center justify-center mb-4">
          <div class="bg-blue-600 p-3 rounded-lg">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
        </div>
        <h2 class="card__title">Welcome Back</h2>
        <p class="card__description">Sign in to your Smart Route Tracker account</p>
      </div>
      
      <div class="card__content">
        <form id="loginForm" class="space-y-4">
          <div class="form-group">
            <label class="label" for="email">Email</label>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <input type="email" id="email" class="input pl-10" placeholder="user@traintracker.com" required>
            </div>
            <p id="emailError" class="text-red-600 text-sm mt-1"></p>
          </div>

          <div class="form-group">
            <div class="form-group__label-row">
              <label class="label" for="password">Password</label>
              <a href="/forgot-password" class="btn btn--link text-sm">Forgot password?</a>
            </div>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              <input type="password" id="password" class="input pl-10" placeholder="••••••••" required>
            </div>
            <p id="passwordError" class="text-red-600 text-sm mt-1"></p>
          </div>

          <button type="submit" class="btn btn--default btn--full" id="submitBtn">Sign In</button>
        </form>

        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Don't have an account? </span>
          <a href="/register" class="btn btn--link">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  const form = document.getElementById('loginForm');
  const submitBtn = document.getElementById('submitBtn');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

        let errors = {
        email: false,
        password: false,
        confirmPassword: false,
    }

    if(/^\S+@\S+\.\S+$/.test(email) === false) {
        emailError.textContent = 'Please enter a valid email address';
        errors.email = true;
    }

    if (!password) {
        passwordError.textContent = 'Password is required';
        errors.password = true;
    }

    if (errors.email || errors.password) {
        return;
    }
    
    submitBtn.textContent = 'Signing in...';
    submitBtn.disabled = true;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/auth/login', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            const response = JSON.parse(xhr.responseText);
            const data = response.data || null;
            
            if(response.success) {
                showToast("Login successful! Redirecting...", "success");
               if (data && data.user_type === 'admin') {
                    window.location.href = '/dashboard/admin';
                } else {
                    window.location.href = '/dashboard';
                }
                return;
            }
            showToast(response.message, "error");
            submitBtn.textContent = 'Sign In';
            submitBtn.disabled = false;
        }
    }
    xhr.send(JSON.stringify({ email, password }));
  });
</script>

<?php include_once BASE_PATH . '/app/views/layouts/general/footer.php'; ?>
