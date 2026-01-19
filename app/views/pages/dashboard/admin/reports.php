<?php
$metadata['title'] = 'Admin Dashboard - Monitor | Smart Route Tracker';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/admin.php';
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
                            <p class="text-2xl font-bold" id="totalIssues">0</p>
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
                            <p class="text-2xl font-bold text-orange-600" id="openIssues">0</p>
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
                            <p class="text-2xl font-bold text-blue-600" id="inProgressIssues">0</p>
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
                            <p class="text-2xl font-bold text-green-600" id="resolvedIssues">0</p>
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

            <div class="card">
                <div class="card__content p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">High Priority</p>
                            <p class="text-2xl font-bold text-red-600" id="highPriorityIssues">0</p>
                        </div>
                        <div class="bg-red-100 p-2 rounded-lg">
                            <svg
                                class="h-8 w-8 text-red-400"
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
        </div>

        <div class="card">
            <div class="card__content p-4">
                <div class="grid sm-grid-cols-3 gap-4">
                    <div class="relative">
                        <svg
                            class="absolute left-3 top-3 h-4 w-4 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                        <input
                            type="text"
                            id="searchInput"
                            class="input"
                            placeholder="Search issues..."
                            style="padding-left: 2.5rem"
                            oninput="filterIssues()"
                        />
                    </div>
                    <select id="statusFilter" class="input" onchange="filterIssues()">
                        <option value="all">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="in-progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                    </select>
                    <select id="priorityFilter" class="input" onchange="filterIssues()">
                        <option value="all">All Priorities</option>
                        <option value="high">High Priority</option>
                        <option value="medium">Medium Priority</option>
                        <option value="low">Low Priority</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="issuesContainer" class="space-y-4">
            <div class="card hover-shadow">
                <div class="card__content p-6">
                    <div class="flex items-start gap-4">
                        <div class="mt-1">
                            <svg
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
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge badge--info">In progress</span>
                                        <span class="badge badge--error">HIGH</span>
                                        <span class="badge badge--outline">Platform</span>
                                    </div>
                                    <h3 class="font-semibold text-lg mb-1">Issue #ISS001</h3>
                                    <p class="text-sm text-gray-600" style="white-space: pre-wrap">
                                        Platform 3 display board not working
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 text-sm text-gray-500 mb-4 pb-4"
                                style="border-bottom: 1px solid #e5e7eb"
                            >
                                <span>📝 Reported by <strong>John Doe</strong></span>
                                <span>📅 1/19/2026 at 4:07:23 PM</span>
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
                                    onclick="deleteIssue('ISS001')"
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
            <div class="card hover-shadow">
                <div class="card__content p-6">
                    <div class="flex items-start gap-4">
                        <div class="mt-1">
                            <svg
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
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge badge--warning">Open</span>
                                        <span class="badge badge--warning">MEDIUM</span>
                                        <span class="badge badge--outline">Cleanliness</span>
                                    </div>
                                    <h3 class="font-semibold text-lg mb-1">Issue #ISS002</h3>
                                    <p class="text-sm text-gray-600" style="white-space: pre-wrap">
                                        Restroom needs cleaning at South Station
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 text-sm text-gray-500 mb-4 pb-4"
                                style="border-bottom: 1px solid #e5e7eb"
                            >
                                <span>📝 Reported by <strong>Jane Smith</strong></span>
                                <span>📅 1/19/2026 at 2:07:23 PM</span>
                            </div>

                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Status:</span>
                                    <select
                                        class="input"
                                        style="width: 10rem"
                                        onchange="updateStatus('ISS002', this.value)"
                                    >
                                        <option value="open" selected="">Open</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Priority:</span>
                                    <select
                                        class="input"
                                        style="width: 8rem"
                                        onchange="updatePriority('ISS002', this.value)"
                                    >
                                        <option value="low">Low</option>
                                        <option value="medium" selected="">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>

                                <button
                                    class="btn btn--ghost btn--sm text-red-600"
                                    style="margin-left: auto"
                                    onclick="deleteIssue('ISS002')"
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
            <div class="card hover-shadow">
                <div class="card__content p-6">
                    <div class="flex items-start gap-4">
                        <div class="mt-1">
                            <svg
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
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge badge--success">Resolved</span>
                                        <span class="badge badge--error">HIGH</span>
                                        <span class="badge badge--outline">Safety</span>
                                    </div>
                                    <h3 class="font-semibold text-lg mb-1">Issue #ISS003</h3>
                                    <p class="text-sm text-gray-600" style="white-space: pre-wrap">
                                        Emergency exit light not functioning
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 text-sm text-gray-500 mb-4 pb-4"
                                style="border-bottom: 1px solid #e5e7eb"
                            >
                                <span>📝 Reported by <strong>Admin User</strong></span>
                                <span>📅 1/18/2026 at 7:07:23 PM</span>
                            </div>

                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Status:</span>
                                    <select
                                        class="input"
                                        style="width: 10rem"
                                        onchange="updateStatus('ISS003', this.value)"
                                    >
                                        <option value="open">Open</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="resolved" selected="">Resolved</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Priority:</span>
                                    <select
                                        class="input"
                                        style="width: 8rem"
                                        onchange="updatePriority('ISS003', this.value)"
                                    >
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high" selected="">High</option>
                                    </select>
                                </div>

                                <button
                                    class="btn btn--ghost btn--sm text-red-600"
                                    style="margin-left: auto"
                                    onclick="deleteIssue('ISS003')"
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
        </div>
    </div>
</main>


<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
