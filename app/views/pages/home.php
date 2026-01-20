<?php
$metadata = [
    'title' => 'Smart Route Tracker - Real-Time Train Tracking',
    'styles' => ['/assets/css/home.css'],
];
include_once BASE_PATH . '/app/views/layouts/general/header.php';
?>


<main class="hero-gradient">
  <header class="bg-white shadow-sm">
    <div class="container container--max-7xl py-4 flex items-center justify-between">
      <a href="/" class="flex items-center gap-2">
        <div class="bg-blue-600 flex items-center p-2 rounded-lg">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><rect width="16" height="16" x="4" y="3" rx="2"></rect><path d="M4 11h16"></path><path d="M12 3v8"></path><path d="m8 19-2 3"></path><path d="m18 22-2-3"></path><path d="M8 15h.01"></path><path d="M16 15h.01"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Smart Route Tracker</h1>
      </a>
      <div class="flex gap-3">
        <?php if (isset($_SESSION['user'])) { ?>
          <a href="<?php echo $_SESSION['user']['user_type'] === 'admin'
              ? '/dashboard/admin'
              : '/dashboard'; ?>" class="btn btn--default">Dashboard</a>
        <?php } else { ?>
        <a href="/login" class="btn btn--ghost">Login</a>
        <a href="/register" class="btn btn--default">Get Started</a>
        <?php } ?>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="container container--max-7xl py-20">
    <div class="text-center">
      <h2 class="text-5xl font-bold text-gray-900 mb-6">
        Real-Time Train Tracking<br>
        <span class="text-blue-600">Made Simple</span>
      </h2>
      <p class="text-xl text-gray-600 mb-8 container--max-2xl mx-auto">
        Track your trains in real-time, get instant notifications about delays, 
        and manage your journey with our smart tracking platform.
      </p>
      <div class="flex gap-4 justify-center">
        <a href="/register" class="btn btn--default btn--lg">Start Tracking Now</a>
        <a href="/login" class="btn btn--outline btn--lg">Sign In</a>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="container container--max-7xl py-16">
    <div class="grid md-grid-cols-3 gap-8">
      <div class="card p-8">
        <div class="feature-icon-blue w-12 h-12 rounded-lg flex items-center justify-center mb-4">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3">Live Tracking</h3>
        <p class="text-gray-600">
          Track trains in real-time with interactive maps and precise location updates.
        </p>
      </div>

      <div class="card p-8">
        <div class="feature-icon-green w-12 h-12 rounded-lg flex items-center justify-center mb-4">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3">Smart Alerts</h3>
        <p class="text-gray-600">
          Get instant notifications about delays, schedule changes, and platform updates.
        </p>
      </div>

      <div class="card p-8">
        <div class="feature-icon-purple w-12 h-12 rounded-lg flex items-center justify-center mb-4">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3">Admin Control</h3>
        <p class="text-gray-600">
          Powerful admin tools to manage trains, routes, stations, and monitor the entire network.
        </p>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section mt-20">
    <div class="container container--max-7xl py-16 text-center">
      <h2 class="text-3xl font-bold mb-4">Ready to get started?</h2>
      <p class="mb-8 text-lg">Join thousands of users tracking their trains with confidence</p>
      <a href="/register" class="btn btn--secondary btn--lg">Create Free Account</a>
    </div>
  </section>


  <footer class="bg-gray-50 border-t border-gray-200">
    <div class="container container--max-7xl py-8">
      <p class="text-center text-gray-600">© 2026 Smart Route Tracker. All rights reserved.</p>
    </div>
  </footer>
</main>

<?php include_once BASE_PATH . '/app/views/layouts/general/footer.php';
?>
