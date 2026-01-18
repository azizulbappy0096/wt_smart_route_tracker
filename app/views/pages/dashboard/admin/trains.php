<?php
$metadata['title'] = 'Admin Dashboard - Trains | Smart Route Tracker';
$metadata['styles'][] = '/assets/css/modal.css';
include_once BASE_PATH . '/app/views/layouts/dashboard/header/admin.php';
?>

<main class="dashboard-main">
    <div class="dashboard-content space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Train Management</h2>
                <p class="text-gray-500">Manage train schedules, routes, and real-time tracking</p>
            </div>
            <button class="btn btn--default" id="addTrainButton">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>
                Add Train
            </button>
        </div>

        <div class="grid gap-4" id="trainsContainer">
            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-semibold">Express Northeast</h3>
                                <span class="badge badge--outline">Express</span>
                                <span class="badge badge--green">ON TIME</span>
                            </div>
                            <p class="text-sm text-gray-500">Train #EX-101</p>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="btn btn--ghost btn--icon"
                          
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    ></path>
                                </svg>
                            </button>
                            <button
                                class="btn btn--ghost btn--icon"
                            >
                                <svg
                                    class="h-4 w-4 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="train-card__route mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <svg
                                class="h-4 w-4 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">Central Station</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <span class="text-gray-500">2 stops</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <svg
                                class="h-4 w-4 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">South Station</span>
                        </div>
                    </div>

                    <div class="grid sm-grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Current Location</p>
                            <p class="font-medium">Central Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Speed</p>
                            <p class="font-medium">110 km/h</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Next Station</p>
                            <p class="font-medium">Penn Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">ETA</p>
                            <p class="font-medium">09:30</p>
                        </div>
                    </div>

                    <div class="train-card__status-buttons">
                        <span class="train-card__status-label">Update Status:</span>
                        <button
                            class="btn btn--default btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            On Time
                        </button>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Delayed
                        </button>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Stopped
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-semibold">Local Commuter</h3>
                                <span class="badge badge--outline">Local</span>
                                <span class="badge badge--yellow">DELAYED</span>
                            </div>
                            <p class="text-sm text-gray-500">Train #LC-205</p>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="btn btn--ghost btn--icon"
                              
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    ></path>
                                </svg>
                            </button>
                            <button
                                class="btn btn--ghost btn--icon"
                            >
                                <svg
                                    class="h-4 w-4 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="train-card__route mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <svg
                                class="h-4 w-4 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">Penn Station</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <span class="text-gray-500">0 stops</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <svg
                                class="h-4 w-4 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">Central Station</span>
                        </div>
                    </div>

                    <div class="grid sm-grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Current Location</p>
                            <p class="font-medium">Penn Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Speed</p>
                            <p class="font-medium">65 km/h</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Next Station</p>
                            <p class="font-medium">Central Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">ETA</p>
                            <p class="font-medium">12:10</p>
                        </div>
                    </div>

                    <div class="train-card__status-buttons">
                        <span class="train-card__status-label">Update Status:</span>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            On Time
                        </button>
                        <button
                            class="btn btn--default btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Delayed
                        </button>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Stopped
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-semibold">Super Fast Express</h3>
                                <span class="badge badge--outline">Super Fast</span>
                                <span class="badge badge--green">ON TIME</span>
                            </div>
                            <p class="text-sm text-gray-500">Train #SF-301</p>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="btn btn--ghost btn--icon"
                            
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    ></path>
                                </svg>
                            </button>
                            <button
                                class="btn btn--ghost btn--icon"
                            >
                                <svg
                                    class="h-4 w-4 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="train-card__route mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <svg
                                class="h-4 w-4 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">Union Terminal</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <span class="text-gray-500">0 stops</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <svg
                                class="h-4 w-4 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">Central Station</span>
                        </div>
                    </div>

                    <div class="grid sm-grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Current Location</p>
                            <p class="font-medium">Union Terminal</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Speed</p>
                            <p class="font-medium">130 km/h</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Next Station</p>
                            <p class="font-medium">Central Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">ETA</p>
                            <p class="font-medium">19:00</p>
                        </div>
                    </div>

                    <div class="train-card__status-buttons">
                        <span class="train-card__status-label">Update Status:</span>
                        <button
                            class="btn btn--default btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            On Time
                        </button>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Delayed
                        </button>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Stopped
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__content p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-semibold">Passenger Special</h3>
                                <span class="badge badge--outline">Passenger</span>
                                <span class="badge badge--red">STOPPED</span>
                            </div>
                            <p class="text-sm text-gray-500">Train #PAS-405</p>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="btn btn--ghost btn--icon"
                           
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    ></path>
                                </svg>
                            </button>
                            <button
                                class="btn btn--ghost btn--icon"
                            >
                                <svg
                                    class="h-4 w-4 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="train-card__route mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <svg
                                class="h-4 w-4 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">Gateway Station</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <span class="text-gray-500">0 stops</span>
                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                            <svg
                                class="h-4 w-4 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                            </svg>
                            <span class="font-medium">South Station</span>
                        </div>
                    </div>

                    <div class="grid sm-grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Current Location</p>
                            <p class="font-medium">Gateway Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Speed</p>
                            <p class="font-medium">0 km/h</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Next Station</p>
                            <p class="font-medium">South Station</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">ETA</p>
                            <p class="font-medium">20:15</p>
                        </div>
                    </div>

                    <div class="train-card__status-buttons">
                        <span class="train-card__status-label">Update Status:</span>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            On Time
                        </button>
                        <button
                            class="btn btn--outline btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Delayed
                        </button>
                        <button
                            class="btn btn--default btn--sm"
                        >
                            <svg
                                class="h-3 w-3 mr-1"
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
                            Stopped
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="dialog-overlay" id="trainDialog">
    <div class="dialog dialog--xlarge">
        <button class="dialog__close" onclick="closeModal('trainDialog')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>

        <div class="dialog__header">
            <h2 class="dialog__title" id="dialogTitle">Add New Train</h2>
            <p class="dialog__description">
                Configure train details, route, and schedule with automatic ETA calculation
            </p>
        </div>

        <div class="dialog__content">
            <form id="trainForm">
                <div class="form-section">
                    <h3 class="form-section__title">Basic Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="label" for="trainNumber">Train Number *</label>
                            <input
                                type="text"
                                id="trainNumber"
                                class="input"
                                placeholder="EX-101"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label class="label" for="trainName">Train Name *</label>
                            <input
                                type="text"
                                id="trainName"
                                class="input"
                                placeholder="Express Northeast"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label class="label" for="trainType">Type</label>
                            <select id="trainType" class="input">
                                <option value="Express">Express</option>
                                <option value="Super Fast">Super Fast</option>
                                <option value="Local">Local</option>
                                <option value="Passenger">Passenger</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label" for="trainSpeed">Average Speed (km/h)</label>
                            <input type="number" id="trainSpeed" class="input" value="80" min="1" />
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section__title">Route Configuration</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="label" for="startStation">Start Station *</label>
                            <select id="startStation" class="input" required>
                                <option value="">Select start station</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label" for="endStation">Destination Station *</label>
                            <select id="endStation" class="input" required>
                                <option value="">Select destination</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label" for="departureTime">Departure Time *</label>
                            <input type="time" id="departureTime" class="input" required />
                        </div>
                        <div class="form-group">
                            <label class="label" for="intermediateStation"
                                >Add Intermediate Stations</label
                            >
                            <select
                                id="intermediateStation"
                                class="input"
                                onchange="addIntermediateStation()"
                            >
                                <option value="">Add stations to route</option>
                            </select>
                        </div>
                    </div>

                    <div id="selectedStationsContainer" class="hidden">
                        <label class="label">Intermediate Stations (in order)</label>
                        <div class="selected-stations" id="selectedStations"></div>
                    </div>

               
                </div>

                <div id="routePreviewSection" class="form-section hidden">
                    <h3 class="form-section__title">Generated Route Schedule</h3>
                    <div class="route-preview" id="routePreview"></div>
                    <div class="route-summary">
                        <p class="route-summary__text" id="routeSummary"></p>
                    </div>
                </div>
            </form>
        </div>

        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" onclick="closeModal('trainDialog')">
                Cancel
            </button>
            <button type="button" class="btn btn--default">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
                    />
                </svg>
                <span id="saveButtonText">Save Train</span>
            </button>
        </div>
    </div>
</div>

<script src="/assets/js/dashboard/admin/trains.js"></script>
<?php include_once BASE_PATH . '/app/views/layouts/dashboard/footer.php'; ?>
