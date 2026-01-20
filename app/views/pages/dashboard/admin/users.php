<?php
$metadata['title'] = 'Admin Dashboard - Monitor | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/admin.php';
$badgeClasses = [
    'admin' => 'badge--default',
    'user' => 'badge--secondary',
];
?>

<main class="dashboard-main">
    <div class="dashboard-content space-y-6">
        <div>
            <h2 class="text-2xl font-bold">User Management</h2>
            <p class="text-gray-600">Manage user accounts and permissions</p>
        </div>

        <div id="usersContainer" class="space-y-4">
            <?php foreach ($users as $user) { ?>
            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div
                                    class="avatar__fallback avatar__fallback--blue"
                                    style="width: 3rem; font-size: 1.125rem"
                                >
                                    <?php
                                    $initials = strtoupper(
                                        substr($user['full_name'], 0, 1) .
                                            substr(explode(' ', $user['full_name'])[1] ?? '', 0, 1),
                                    );
                                    echo $initials;
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-semibold"><?php echo htmlspecialchars(
                                        $user['full_name'],
                                    ); ?></h3>
                                    <span class="badge <?php echo $badgeClasses[
                                        $user['user_type']
                                    ] ?? 'badge--default'; ?>">
                                        <svg
                                            class="h-3 w-3 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            style="display: inline-block; vertical-align: middle"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                            ></path>
                                        </svg>
                                        <?php echo htmlspecialchars($user['user_type']); ?>
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg
                                            class="h-3 w-3"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            ></path>
                                        </svg>
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </span>
                                    <span>📞 <?php echo htmlspecialchars($user['phone']); ?></span>
                                    <span>Joined <?php echo date(
                                        'm/d/Y',
                                        strtotime($user['created_at']),
                                    ); ?></span>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <?php } ?>
       

        </div>
    </div>
</main>


<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
