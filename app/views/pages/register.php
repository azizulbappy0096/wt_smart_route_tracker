<?php
$metadata = [
    'title' => 'Register - Smart Route Tracker',
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
        <h2 class="card__title">Create Account</h2>
        <p class="card__description">Join Smart Route Tracker today</p>
      </div>
      
      <div class="card__content">
        <form id="registerForm" class="space-y-4">
          <div class="form-group">
            <label class="label" for="name">Full Name</label>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              <input type="text" id="name" class="input pl-10" placeholder="John Doe" required>
            </div>
          </div>

          <div class="form-group">
            <label class="label" for="email">Email</label>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <input type="email" id="email" class="input pl-10" placeholder="you@example.com" required>
            </div>
            <p id="emailError" class="text-red-600 text-sm mt-1"></p>
          </div>

          <div class="form-group">
            <label class="label" for="password">Password</label>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              <input type="password" id="password" class="input pl-10" placeholder="••••••••" required>
            </div>
            <p id="passwordError" class="text-red-600 text-sm mt-1"></p>
          </div>

          <div class="form-group">
            <label class="label" for="confirmPassword">Confirm Password</label>
            <div class="input-group">
              <svg class="input-group__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              <input type="password" id="confirmPassword" class="input pl-10" placeholder="••••••••" required>
            </div>
            <p id="confirmPasswordError" class="text-red-600 text-sm mt-1"></p>
          </div>

          <button type="submit" class="btn btn--default btn--full" id="submitBtn">Create Account</button>
        </form>

        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Already have an account? </span>
          <a href="/login" class="btn btn--link">Sign in</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
const form = document.getElementById('registerForm');
const submitBtn = document.getElementById('submitBtn');
const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');
const confirmPasswordError = document.getElementById('confirmPasswordError');

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    let errors = {
        email: false,
        password: false,
        confirmPassword: false,
    }

    if(/^\S+@\S+\.\S+$/.test(email) === false) {
        emailError.textContent = 'Please enter a valid email address';
        errors.email = true;
    }

    if (password !== confirmPassword) {
        confirmPasswordError.textContent = 'Passwords do not match';
        errors.confirmPassword = true;
    }

    if (password.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters';
        errors.password = true;
    }

    if (errors.email || errors.password || errors.confirmPassword) {
        return;
    }

    submitBtn.textContent = 'Creating account...';
    submitBtn.disabled = true;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/auth/register', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            const response = JSON.parse(xhr.responseText);
            const data = response.data || null;
            
            if(response.success) {
                showToast("Registration successful! Redirecting...", "success");
                window.location.href = '/login';
                return;
            }
            showToast(response.message, "error");
            submitBtn.textContent = 'Create Account';
            submitBtn.disabled = false;
        }
    }
    xhr.send(JSON.stringify({ full_name: name, email, password }));
});

</script>
<?php include_once BASE_PATH . '/app/views/layouts/general/footer.php'; ?>
