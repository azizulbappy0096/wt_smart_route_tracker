<?php
$metadata['title'] = 'Admin Dashboard - Monitor | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/admin.php';

$badgeClasses = [
    'status' => [
        'open' => 'badge--warning',
        'in-progress' => 'badge--info',
        'resolved' => 'badge--success',
    ],
    'priority' => [
        'high' => 'badge--error',
        'medium' => 'badge--warning',
        'low' => 'badge--secondary',
    ],
    'category' => [
        'delay' => 'badge--info',
        'cancellation' => 'badge--error',
        'technical' => 'badge--warning',
        'safety' => 'badge--success',
        'other' => 'badge--secondary',
    ],
];

$icon = [
    'in-progress' => '<svg
                                class="h-5 w-5 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>',
    'open' => '<svg
                                class="h-5 w-5 text-orange-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                ></path>
                            </svg>',
    'resolved' => '<svg
                                class="h-5 w-5 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                ></path>
                            </svg>',
];
?>

<main class="dashboard-main">
    <div class="dashboard-content space-y-6">
        <div>
            <h2 class="text-2xl font-bold">Issue Management</h2>
            <p class="text-gray-600">Track and resolve platform issues and user complaints</p>
        </div>

        <div class="grid sm-grid-cols-2 lg-grid-cols-5 gap-4">
            <div class="card">
                <div class="card__content p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Issues</p>
                            <p class="text-2xl font-bold" id="totalIssues"><?= htmlspecialchars(
                                $stats['total'] ?? 0,
                            ) ?></p>
                        </div>
                        <div class="bg-gray-100 p-2 rounded-lg">
                            <svg
                                class="h-8 w-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__content p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Open</p>
                            <p class="text-2xl font-bold text-orange-600" id="openIssues">
                                <?= htmlspecialchars($stats['open'] ?? 0) ?>
                            </p>
                        </div>
                        <div class="bg-orange-100 p-2 rounded-lg">
                            <svg
                                class="h-8 w-8 text-orange-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__content p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">In Progress</p>
                            <p class="text-2xl font-bold text-blue-600" id="inProgressIssues">
                                <?= htmlspecialchars($stats['in_progress'] ?? 0) ?>
                            </p>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg
                                class="h-8 w-8 text-blue-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__content p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Resolved</p>
                            <p class="text-2xl font-bold text-green-600" id="resolvedIssues">
                                <?= htmlspecialchars($stats['resolved'] ?? 0) ?>
                            </p>
                        </div>
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg
                                class="h-8 w-8 text-green-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-4">
            <?php foreach ($reports as $report) { ?>
            <div class="card hover-shadow" data-report-id="<?php echo $report['id']; ?>">
                <div class="card__content p-6">
                    <div class="flex items-start gap-4">
                        <div class="mt-1">
                            <?php echo $icon[$report['status']] ?? ''; ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge <?php echo $badgeClasses['status'][
                                            $report['status']
                                        ] ?? ''; ?>"><?php echo ucfirst(
    $report['status'],
); ?></span>
                                        <span class="badge <?php echo $badgeClasses['priority'][
                                            $report['priority']
                                        ] ?? ''; ?>"><?php echo strtoupper(
    $report['priority'],
); ?></span>
                                        <span class="badge <?php echo $badgeClasses['category'][
                                            $report['category']
                                        ] ?? ''; ?>"><?php echo htmlspecialchars(
    $report['category'],
); ?></span>
                                    </div>
                                    <h3 class="font-semibold text-lg mb-1"><?php echo htmlspecialchars(
                                        $report['title'],
                                    ); ?></h3>
                                    <p class="text-sm text-gray-600" style="white-space: pre-wrap">
                                        <?php echo htmlspecialchars($report['description']); ?>
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 text-sm text-gray-500 mb-4 pb-4"
                                style="border-bottom: 1px solid #e5e7eb"
                            >
                                <span>📝 Reported by <strong><?php echo htmlspecialchars(
                                    $report['reporter_name'],
                                ); ?></strong></span>
                                <span>📅 <?php echo date(
                                    'm/d/Y \a\t h:i:s A',
                                    strtotime($report['created_at']),
                                ); ?></span>
                            </div>

                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Status:</span>
                                    <select
                                        class="input"
                                        style="width: 10rem"
                                        onchange="updateStatus('ISS001', this.value)"
                                    >
                                        <option value="open">Open</option>
                                        <option value="in-progress" selected="">In Progress</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Priority:</span>
                                    <select
                                        class="input"
                                        style="width: 8rem"
                                        onchange="updatePriority('ISS001', this.value)"
                                    >
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high" selected="">High</option>
                                    </select>
                                </div>

                                <button
                                    class="btn btn--ghost btn--sm text-red-600"
                                    style="margin-left: auto"
                                    onclick="deleteReport(<?php echo $report['id']; ?>)"
                                >
                                    <svg
                                        class="h-4 w-4 mr-1"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
       
        </div>
    </div>
</main>


<script>
    function deleteReport(reportId) {
        if (!confirm('Are you sure you want to delete this report?')) {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('delete', '/api/reports/remove?id=' + encodeURIComponent(reportId), true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                const response = JSON.parse(xhr.responseText);
                if (xhr.status === 200 && response.success) {
                    showToast('Report deleted successfully.', 'success');
                    const reportCard = document.querySelector(
                        `.card[data-report-id="${reportId}"]`,
                    );
                    if (reportCard) {
                        reportCard.remove();
                    }
                } else {
                    showToast('Error deleting report: ' + (response.message || 'Unknown error'), 'error');
                }
            }
        };

        xhr.send()

    }
</script>

<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
