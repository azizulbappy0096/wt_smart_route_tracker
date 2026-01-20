<?php
$metadata['styles'][] = '/assets/css/dashboard.css';
include_once BASE_PATH . '/app/views/layouts/general/header.php';
?>

<div class="dashboard-page">
  <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
          <div class="bg-blue-600 p-2 rounded-lg">
            <?php if ($dashboardType === 'admin') { ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-white"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            <?php } else { ?>
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            <?php } ?>
          </div>
          <div>
            <h1 class="text-xl font-bold text-gray-900">Smart Route Tracker <?php echo $dashboardType ===
            'admin'
                ? 'Admin'
                : ''; ?></h1>
            <p class="text-xs text-gray-500"><?php echo $pageHeaderSubtitle ?? 'Dashboard'; ?></p>
          </div>
        </div>
        
        <div class="flex items-center gap-4">
          <?php if ($dashboardType !== 'admin') { ?>
            <a href="/dashboard/notifications" class="dashboard-header__btn relative <?php echo $requestUri ===
            '/dashboard/notifications'
                ? 'notification--active'
                : ''; ?>" id="notificationBtn">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
              </svg>
              <span class="notification-badge" id="notificationBadge">3</span>
            </a>
          <?php } ?>
          
          <div class="dashboard-user-menu">
            <button id="userMenuTrigger" class="dashboard-user-menu__trigger" data-dropdown="userDropdown">
              <div class="dashboard-avatar" id="userAvatar">AB</div>
              <span class="hidden sm-inline" id="userName">Azizul Bappy</span>
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            
            <div class="dropdown" id="userDropdown">
              <div class="dropdown__content">
                <div class="dropdown__label">My Account</div>
                <a href="/dashboard/profile" class="dropdown__item">
                  <svg class="dropdown__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  Profile Settings
                </a>
                <div class="dropdown__separator"></div>
                <a href="/api/auth/logout"  class="dropdown__item text-red-600">
                  <svg class="dropdown__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  Logout
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Navigation -->
        <div class="dashboard-tabs">
            <?php foreach ($tabs as $tab) { ?>
                <?php
                $isActive = $requestUri === $tab['path'];
                $activeClass = $isActive ? 'dashboard-tab--active' : '';
                ?>
                
                <a href="<?php echo $tab[
                    'path'
                ]; ?>" class="dashboard-tab <?php echo $activeClass; ?>">
                    <svg class="dashboard-tab__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php echo $tab['icon']; ?>
                    </svg>
                    <?php echo $tab['label']; ?>
                </a>
            <?php } ?>
        </div>
    </div>
  </header>