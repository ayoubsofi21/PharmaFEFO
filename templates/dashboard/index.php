<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Smart Pharmacy Stock Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .active-nav { @apply bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex z-50">
        <div>
            <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                <div class="bg-emerald-600 text-white p-2 rounded-xl shadow-md shadow-emerald-100">
                    <i data-lucide="pill" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-slate-900 tracking-tight">PharmaFEFO</h1>
                    <p class="text-xs text-slate-500 font-medium tracking-wide">FEFO STOCK CONTROL</p>
                </div>
            </div>
            <nav class="p-4 space-y-1">
                <button onclick="switchPage('dashboard')" id="nav-dashboard" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900 active-nav">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </button>
                <button onclick="switchPage('stock-entry')" id="nav-stock-entry" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i> Stock Entry
                </button>
                <button onclick="switchPage('dispatch')" id="nav-dispatch" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <i data-lucide="truck" class="w-5 h-5"></i> FEFO Dispatch
                </button>
                <button onclick="switchPage('alerts')" id="nav-alerts" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900 relative">
                    <i data-lucide="bell" class="w-5 h-5"></i> Alerts
                    <span id="alert-badge-count" class="absolute right-4 bg-rose-500 text-white text-xs px-2 py-0.5 rounded-full font-bold hidden">0</span>
                </button>
                <button onclick="switchPage('reports')" id="nav-reports" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i> Analytics & Reports
                </button>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm">DR</div>
            <div>
                <p class="text-sm font-semibold text-slate-800">Dr. Sarah Alami</p>
                <p class="text-xs text-slate-500">Chief Pharmacist</p>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <header class="bg-white border-b border-slate-200 h-16 px-6 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <button class="md:hidden p-2 text-slate-600" onclick="toggleMobileMenu()">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <h2 id="page-title" class="text-xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h2>
            </div>
            <div id="global-notification-banner" class="hidden md:flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-lg px-4 py-1.5 text-amber-800 text-sm font-medium animate-pulse">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600"></i>
                <span id="banner-text">Attention needed</span>
            </div>
        </header>

        <div class="p-6 md:p-8 flex-1 max-w-7xl w-full mx-auto space-y-8">

            <section id="page-dashboard" class="page-view space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Total Batches</p>
                            <h3 id="metric-total-batches" class="text-3xl font-bold text-slate-800 mt-1">0</h3>
                        </div>
                        <div class="p-3 bg-slate-50 text-slate-500 rounded-xl"><i data-lucide="layers" class="w-6 h-6"></i></div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-emerald-600 uppercase">Safe Stock (>6M)</p>
                            <h3 id="metric-safe" class="text-3xl font-bold text-slate-800 mt-1">0</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl"><i data-lucide="check-circle" class="w-6 h-6"></i></div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-amber-600 uppercase">Expiring Soon (<90D)</p>
                            <h3 id="metric-soon" class="text-3xl font-bold text-slate-800 mt-1">0</h3>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl"><i data-lucide="clock" class="w-6 h-6"></i></div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-rose-600 uppercase">Critical / Expired</p>
                            <h3 id="metric-critical" class="text-3xl font-bold text-slate-800 mt-1">0</h3>
                        </div>
                        <div class="p-3 bg-rose-50 text-rose-600 rounded-xl"><i data-lucide="alert-octagon" class="w-6 h-6"></i></div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row gap-3 items-center justify-between shadow-sm">
                    <div class="relative w-full sm:w-72">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
                        <input type="text" id="filter-search" oninput="renderDashboardTable()" placeholder="Search product or batch..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <button onclick="toggleCriticalFilter()" id="btn-filter-critical" class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-sm font-medium rounded-lg hover:bg-slate-50 transition-all">
                            <i data-lucide="filter" class="w-4 h-4"></i> Show Only Red Alerts
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold tracking-wider text-slate-500 uppercase">
                                    <th class="p-4 pl-6">Medicine / Product Name</th>
                                    <th class="p-4">Batch Number</th>
                                    <th class="p-4">Expiration Date (DLU)</th>
                                    <th class="p-4 text-right">Stock Quantity</th>
                                    <th class="p-4 text-center">FEFO Risk Status</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard-table-body" class="divide-y divide-slate-100 text-sm font-medium">
                                </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="page-stock-entry" class="page-view hidden max-w-xl mx-auto">
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Add New Batch Reception</h3>
                        <p class="text-sm text-slate-500">Log incoming pharmacy inventory items under safety protocol.</p>
                    </div>
                    <form id="stock-entry-form" onsubmit="handleStockSubmit(event)" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Product Name</label>
                            <input type="text" id="form-name" required placeholder="e.g., Amoxicillin 500mg" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Batch Number</label>
                                <input type="text" id="form-batch" required placeholder="e.g., BATCH-2026-A" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Quantity</label>
                                <input type="number" id="form-qty" min="1" required placeholder="500" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Expiration Date (DLU)</label>
                            <input type="date" id="form-date" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div id="form-feedback" class="hidden p-3 rounded-lg text-sm font-medium"></div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-lg shadow-md transition-all flex items-center justify-center gap-2">
                            <i data-lucide="check" class="w-5 h-5"></i> Securely Save Batch
                        </button>
                    </form>
                </div>
            </section>

            <section id="page-dispatch" class="page-view hidden space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">FEFO Automated Dispatch System</h3>
                        <p class="text-sm text-slate-500">Select medicine to safely dispatch. The oldest stock is chosen automatically.</p>
                    </div>
                    <div class="w-full sm:w-64">
                        <select id="dispatch-product-selector" onchange="renderDispatchModule()" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium text-sm">
                            </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-slate-200 bg-slate-50/50">
                            <h4 class="font-bold text-sm tracking-wide text-slate-600 uppercase">Available Batches Breakdown</h4>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-200">
                                    <tr>
                                        <th class="p-4 pl-6">Priority Order</th>
                                        <th class="p-4">Batch ID</th>
                                        <th class="p-4">Expiry Date</th>
                                        <th class="p-4 text-right">Remaining Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="dispatch-table-body" class="text-sm font-medium divide-y divide-slate-100">
                                    </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1">
                                <i data-lucide="shield-alert" class="w-3.5 h-3.5"></i> FEFO Enforced Protection
                            </span>
                            <div>
                                <h4 class="text-slate-500 text-xs uppercase tracking-wider font-semibold">Target Batch for Next Outgoing Order</h4>
                                <p id="dispatch-target-name" class="text-xl font-bold text-slate-900 mt-1">-</p>
                                <p id="dispatch-target-batch" class="text-sm text-emerald-600 font-mono mt-0.5">-</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl space-y-2">
                                <div class="flex justify-between text-xs font-medium text-slate-500"><span>Expiry Date:</span> <span id="dispatch-target-expiry" class="font-bold text-slate-800">-</span></div>
                                <div class="flex justify-between text-xs font-medium text-slate-500"><span>Available:</span> <span id="dispatch-target-qty" class="font-bold text-slate-800">-</span></div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Quantity to Release</label>
                                <input type="number" id="dispatch-qty-input" min="1" value="10" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 font-semibold">
                            </div>
                        </div>
                        <button onclick="executeDispatch()" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                            <i data-lucide="package-up" class="w-5 h-5"></i> Approve Dispatch Order
                        </button>
                    </div>
                </div>
            </section>

            <section id="page-alerts" class="page-view hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
                        <div class="p-5 bg-rose-50/50 border-b border-rose-100 flex items-center gap-3">
                            <div class="p-2 bg-rose-500 text-white rounded-lg"><i data-lucide="skull" class="w-5 h-5"></i></div>
                            <div>
                                <h3 class="font-bold text-rose-950">Critical Risk (&lt; 30 Days or Expired)</h3>
                                <p class="text-xs text-rose-700">Must be discarded or applied to immediate treatment scripts.</p>
                            </div>
                        </div>
                        <div class="p-4 divide-y divide-slate-100" id="alerts-critical-list"></div>
                    </div>

                    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
                        <div class="p-5 bg-amber-50/50 border-b border-amber-100 flex items-center gap-3">
                            <div class="p-2 bg-amber-500 text-white rounded-lg"><i data-lucide="amber-alert" class="w-5 h-5"></i></div>
                            <div>
                                <h3 class="font-bold text-amber-950">Near-Term Expiry Warning (&lt; 90 Days)</h3>
                                <p class="text-xs text-amber-700">Flagged for dynamic FEFO prioritization matching.</p>
                            </div>
                        </div>
                        <div class="p-4 divide-y divide-slate-100" id="alerts-warning-list"></div>
                    </div>
                </div>
            </section>

            <section id="page-reports" class="page-view hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <p class="text-xs font-semibold tracking-wider text-slate-400 uppercase">3-Month Predicted Waste Loss</p>
                        <h3 id="report-loss-value" class="text-3xl font-bold text-rose-600 mt-2">$0.00</h3>
                        <p class="text-xs text-slate-500 mt-2">Based on current unit valuation across expiring batches.</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <p class="text-xs font-semibold tracking-wider text-slate-400 uppercase">FEFO Efficiency Rating</p>
                        <h3 class="text-3xl font-bold text-emerald-600 mt-2">98.4%</h3>
                        <p class="text-xs text-slate-500 mt-2">Operational accuracy benchmark rating score.</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-end">
                        <button onclick="alert('Report data exported successfully to standard CSV/PDF standard formats (Simulation).')" class="w-full border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-4 rounded-xl text-sm flex items-center justify-center gap-2 transition-all">
                            <i data-lucide="download" class="w-4 h-4"></i> Export Operational Records
                        </button>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div>
                        <h4 class="font-bold text-slate-900">Estimated Loss Distribution Chart</h4>
                        <p class="text-xs text-slate-500">Visual breakdown forecasting inventory shrinkage risk across upcoming quarters.</p>
                    </div>
                    <div class="h-64 flex items-end gap-6 pt-6 px-4">
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-rose-500/20 hover:bg-rose-500/30 transition-all rounded-t-lg relative group" style="height: 85%;">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white font-bold text-xs px-2 py-1 rounded shadow opacity-0 group-hover:opacity-100 transition-all">$4,250</div>
                            </div>
                            <span class="text-xs font-bold text-slate-500">Current Month</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-amber-500/20 hover:bg-amber-500/30 transition-all rounded-t-lg relative group" style="height: 45%;">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white font-bold text-xs px-2 py-1 rounded shadow opacity-0 group-hover:opacity-100 transition-all">$2,100</div>
                            </div>
                            <span class="text-xs font-bold text-slate-500">Next Month</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full bg-emerald-500/20 hover:bg-emerald-500/30 transition-all rounded-t-lg relative group" style="height: 15%;">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white font-bold text-xs px-2 py-1 rounded shadow opacity-0 group-hover:opacity-100 transition-all">$620</div>
                            </div>
                            <span class="text-xs font-bold text-slate-500">+2 Months Out</span>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <div id="mobile-menu" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all">
        <div class="w-64 bg-white h-full p-6 flex flex-col justify-between">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-emerald-600">
                        <i data-lucide="pill" class="w-6 h-6"></i>
                        <span class="font-bold text-lg text-slate-900">PharmaFEFO</span>
                    </div>
                    <button onclick="toggleMobileMenu()" class="p-1 text-slate-400"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>
                <nav class="space-y-2" id="mobile-nav-links"></nav>
            </div>
        </div>
    </div>

    <script>
        // MOCK DATABASE STORES USING SYSTEM TIME CONTEXT DATA
        let stockInventory = [
            { id: 1, name: "Amoxicillin 500mg", batch: "AMX-9082", expiry: "2026-06-15", qty: 450, unitPrice: 2.5 },
            { id: 2, name: "Lipitor (Atorvastatin)", batch: "LIP-1123", expiry: "2026-07-20", qty: 180, unitPrice: 5.0 },
            { id: 3, name: "Metformin 850mg", batch: "MET-4410", expiry: "2026-08-05", qty: 900, unitPrice: 1.2 },
            { id: 4, name: "Paracetamol 500mg", batch: "PAR-5561", expiry: "2027-04-12", qty: 1200, unitPrice: 0.5 },
            { id: 5, name: "Amoxicillin 500mg", batch: "AMX-9100", expiry: "2026-12-01", qty: 300, unitPrice: 2.5 },
            { id: 6, name: "Ibuprofen 400mg", batch: "IBU-3321", expiry: "2026-06-02", qty: 50, unitPrice: 1.1 }
        ];

        let displayOnlyCritical = false;

        // LIFE-CYCLE INITIALIZATION RUNNER
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            calculateAndRefreshState();
            populateDispatchSelectors();
            switchPage('dashboard');
            
            // Build out mobile dynamic navigation mirror clone
            document.getElementById('mobile-nav-links').innerHTML = document.querySelector('nav').innerHTML;
        });

        // RE-CALCULATE RE-USABLE METRICS & TRACKING STATUSES
        function calculateAndRefreshState() {
            const today = new Date("2026-06-09"); // Set fixed reference date based on system context
            let criticalCount = 0;
            let soonCount = 0;
            let safeCount = 0;
            let expectedLossValuation = 0;

            stockInventory.forEach(item => {
                const expiryDate = new Date(item.expiry);
                const timeDiff = expiryDate - today;
                const daysToExpiry = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

                if (daysToExpiry <= 30) {
                    item.statusClass = "bg-rose-100 text-rose-800 ring-rose-600/20";
                    item.statusText = "Critical (<30 Days)";
                    criticalCount++;
                    if(item.qty > 0) expectedLossValuation += (item.qty * item.unitPrice);
                } else if (daysToExpiry <= 90) {
                    item.statusClass = "bg-amber-100 text-amber-800 ring-amber-600/20";
                    item.statusText = "Warning (<90 Days)";
                    soonCount++;
                } else {
                    item.statusClass = "bg-emerald-100 text-emerald-800 ring-emerald-600/20";
                    item.statusText = "Safe (>6 Months)";
                    safeCount++;
                }
                item.daysRemaining = daysToExpiry;
            });

            // Refresh UI Badges & App Counters Globals
            document.getElementById('metric-total-batches').innerText = stockInventory.length;
            document.getElementById('metric-safe').innerText = safeCount;
            document.getElementById('metric-soon').innerText = soonCount;
            document.getElementById('metric-critical').innerText = criticalCount;
            document.getElementById('report-loss-value').innerText = `$${expectedLossValuation.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

            const badge = document.getElementById('alert-badge-count');
            if (criticalCount > 0) {
                badge.innerText = criticalCount;
                badge.classList.remove('hidden');
                document.getElementById('global-notification-banner').classList.remove('hidden');
                document.getElementById('banner-text').innerText = `${criticalCount} Batch items require immediate critical attention`;
            } else {
                badge.classList.add('hidden');
                document.getElementById('global-notification-banner').classList.add('hidden');
            }

            renderDashboardTable();
            renderAlertsLists();
        }

        // NAVIGATION MODULE ROUTER
        function switchPage(pageId) {
            document.querySelectorAll('.page-view').forEach(view => view.classList.add('hidden'));
            document.getElementById(`page-${pageId}`).classList.remove('hidden');

            // Manage nav focus highlights styling layout mappings
            document.querySelectorAll('nav button').forEach(btn => {
                btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-r-4', 'border-emerald-600');
            });
            const targetNav = document.getElementById(`nav-${pageId}`);
            if (targetNav) targetNav.classList.add('bg-emerald-50', 'text-emerald-700', 'border-r-4', 'border-emerald-600');

            // Format Context Heading Window Titles
            const titles = {
                dashboard: "Dashboard Overview",
                'stock-entry': "New Inventory Stock Intake Entry",
                dispatch: "FEFO Automation Dynamic Queue Dispensation",
                alerts: "System Safety Vulnerabilities & Alert Center",
                reports: "Financial Optimization Forecasts & Metrics"
            };
            document.getElementById('page-title').innerText = titles[pageId] || "Dashboard";
            
            if(pageId === 'dispatch') renderDispatchModule();
            
            // Auto close mobile layout overlay tracking safety menus
            const mobileMenu = document.getElementById('mobile-menu');
            if(!mobileMenu.classList.contains('hidden')) toggleMobileMenu();
        }

        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        // PAGE 1 LOGIC: RENDER & FILTERS FOR STOCK DASHBOARD
        function renderDashboardTable() {
            const query = document.getElementById('filter-search').value.toLowerCase();
            const container = document.getElementById('dashboard-table-body');
            container.innerHTML = "";

            let processedList = stockInventory;
            if (displayOnlyCritical) {
                processedList = processedList.filter(i => i.daysRemaining <= 30);
            }
            if (query) {
                processedList = processedList.filter(i => i.name.toLowerCase().includes(query) || i.batch.toLowerCase().includes(query));
            }

            if(processedList.length === 0) {
                container.innerHTML = `<tr><td colspan="5" class="p-8 text-center text-slate-400 font-medium">No inventory elements matched filtering properties.</td></tr>`;
                return;
            }

            processedList.forEach(item => {
                container.innerHTML += `
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 pl-6 font-semibold text-slate-900">${item.name}</td>
                        <td class="p-4 font-mono text-xs text-slate-600">${item.batch}</td>
                        <td class="p-4 text-slate-700">${item.expiry} <span class="text-xs text-slate-400 block">${item.daysRemaining} days remaining</span></td>
                        <td class="p-4 text-right font-bold text-slate-900">${item.qty.toLocaleString()} units</td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset ${item.statusClass}">
                                ${item.statusText}
                            </span>
                        </td>
                    </tr>
                `;
            });
        }

        function toggleCriticalFilter() {
            displayOnlyCritical = !displayOnlyCritical;
            const btn = document.getElementById('btn-filter-critical');
            if (displayOnlyCritical) {
                btn.classList.add('bg-rose-50', 'text-rose-700', 'border-rose-200');
            } else {
                btn.classList.remove('bg-rose-50', 'text-rose-700', 'border-rose-200');
            }
            renderDashboardTable();
        }

        // PAGE 2 LOGIC: RECEPTION VALIDATION STORAGE INTAKE
        function handleStockSubmit(event) {
            event.preventDefault();
            const name = document.getElementById('form-name').value;
            const batch = document.getElementById('form-batch').value;
            const qty = parseInt(document.getElementById('form-qty').value);
            const dateStr = document.getElementById('form-date').value;
            const feedback = document.getElementById('form-feedback');

            const selectedDate = new Date(dateStr);
            const today = new Date("2026-06-09");

            if (selectedDate <= today) {
                feedback.className = "p-3 rounded-lg text-sm font-medium bg-rose-50 text-rose-800 border border-rose-200";
                feedback.innerText = "Error: Expiration date cannot be in the past or current intake processing processing day.";
                feedback.classList.remove('hidden');
                return;
            }

            // Append item mock entry securely to store collection tracking allocations
            stockInventory.push({
                id: stockInventory.length + 1,
                name: name,
                batch: batch,
                expiry: dateStr,
                qty: qty,
                unitPrice: 3.50 // Default automated baseline proxy value assignment
            });

            feedback.className = "p-3 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-800 border border-emerald-200";
            feedback.innerText = `Success: Registered batch ${batch} securely. Automated FEFO active monitoring tracking operational routines live.`;
            feedback.classList.remove('hidden');

            document.getElementById('stock-entry-form').reset();
            calculateAndRefreshState();
            populateDispatchSelectors();
        }

        // PAGE 3 LOGIC: FEFO PROCESSING SELECTION AND DISPATCH EXECUTIONS
        function populateDispatchSelectors() {
            const select = document.getElementById('dispatch-product-selector');
            const uniqueNames = [...new Set(stockInventory.map(item => item.name))];
            select.innerHTML = uniqueNames.map(name => `<option value="${name}">${name}</option>`).join('');
        }

        function renderDispatchModule() {
            const selectedProduct = document.getElementById('dispatch-product-selector').value;
            if(!selectedProduct) return;

            // Enforce FEFO Rule: Sort inventory options dynamically by nearest expiration date first
            const batches = stockInventory
                .filter(item => item.name === selectedProduct && item.qty > 0)
                .sort((a, b) => new Date(a.expiry) - new Date(b.expiry));

            const tableBody = document.getElementById('dispatch-table-body');
            tableBody.innerHTML = "";

            if(batches.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="p-6 text-center text-slate-400">Out of Stock item status exception loop error.</td></tr>`;
                document.getElementById('dispatch-target-name').innerText = "None Available";
                document.getElementById('dispatch-target-batch').innerText = "-";
                document.getElementById('dispatch-target-expiry').innerText = "-";
                document.getElementById('dispatch-target-qty').innerText = "-";
                return;
            }

            batches.forEach((b, index) => {
                const isFEFOPick = index === 0; // The first item in the sorted list is always the FEFO choice
                tableBody.innerHTML += `
                    <tr class="${isFEFOPick ? 'bg-amber-50/70 font-bold border-l-4 border-l-amber-500' : ''} hover:bg-slate-50 transition-colors">
                        <td class="p-4 pl-6 flex items-center gap-2">
                            ${isFEFOPick ? '<span class="bg-amber-500 text-white text-[10px] uppercase font-black px-2 py-0.5 rounded-md tracking-wider">USE NEXT (FEFO)</span>' : `<span class="text-slate-400 font-normal">Queue Rank #${index + 1}</span>`}
                        </td>
                        <td class="p-4 font-mono text-xs">${b.batch}</td>
                        <td class="p-4">${b.expiry}</td>
                        <td class="p-4 text-right">${b.qty.toLocaleString()} units</td>
                    </tr>
                `;
            });

            // Primary Target UI Hook bindings mapping fields layout display info updates
            const targetBatch = batches[0];
            document.getElementById('dispatch-target-name').innerText = targetBatch.name;
            document.getElementById('dispatch-target-batch').innerText = `Batch Ref: ${targetBatch.batch}`;
            document.getElementById('dispatch-target-expiry').innerText = targetBatch.expiry;
            document.getElementById('dispatch-target-qty').innerText = `${targetBatch.qty} units standard packaging config`;
            
            // Tag global object reference reference to operational dispatch trigger actions
            window.activeFEFOTargetID = targetBatch.id;
        }

        function executeDispatch() {
            const targetId = window.activeFEFOTargetID;
            const releaseQtyInput = document.getElementById('dispatch-qty-input');
            const releaseQty = parseInt(releaseQtyInput.value);

            if(!targetId) {
                alert("Operation failed. No viable active target item configuration sets selected context.");
                return;
            }

            const matchedInventoryIndex = stockInventory.findIndex(item => item.id === targetId);
            if(matchedInventoryIndex === -1) return;

            if (releaseQty > stockInventory[matchedInventoryIndex].qty) {
                alert(`Error: Insufficient stock available in current FEFO priority batch to support total order size. Please reduce amount or dispatch remaining available batch units (${stockInventory[matchedInventoryIndex].qty}).`);
                return;
            }

            // Deduct requested balance allocation inventory configuration states
            stockInventory[matchedInventoryIndex].qty -= releaseQty;
            
            alert(`Approved System Dispensation Transaction Confirmed:\nSuccessfully dispatched ${releaseQty} units from priority batch: ${stockInventory[matchedInventoryIndex].batch}.`);
            
            calculateAndRefreshState();
            renderDispatchModule();
        }

        // PAGE 4 LOGIC: POPULATE SEPARATED DLU RISK ALERTS CHANNELS
        function renderAlertsLists() {
            const criticalContainer = document.getElementById('alerts-critical-list');
            const warningContainer = document.getElementById('alerts-warning-list');

            criticalContainer.innerHTML = "";
            warningContainer.innerHTML = "";

            const criticals = stockInventory.filter(i => i.daysRemaining <= 30);
            const warnings = stockInventory.filter(i => i.daysRemaining > 30 && i.daysRemaining <= 90);

            if(criticals.length === 0) {
                criticalContainer.innerHTML = `<p class="p-4 text-sm text-slate-400 text-center">Zero critical expiration threats localized.</p>`;
            } else {
                criticals.forEach(c => {
                    criticalContainer.innerHTML += `
                        <div class="p-3 flex justify-between items-center text-sm">
                            <div>
                                <h4 class="font-bold text-slate-900">${c.name}</h4>
                                <p class="text-xs text-slate-500 font-mono">Batch: ${c.batch}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-rose-600 font-bold text-xs block">${c.daysRemaining <= 0 ? 'EXPIRED' : `${c.daysRemaining} Days Left`}</span>
                                <span class="text-xs font-medium text-slate-500">${c.qty} remaining units</span>
                            </div>
                        </div>
                    `;
                });
            }

            if(warnings.length === 0) {
                warningContainer.innerHTML = `<p class="p-4 text-sm text-slate-400 text-center">Zero warning level expiration events registered.</p>`;
            } else {
                warnings.forEach(w => {
                    warningContainer.innerHTML += `
                        <div class="p-3 flex justify-between items-center text-sm">
                            <div>
                                <h4 class="font-bold text-slate-900">${w.name}</h4>
                                <p class="text-xs text-slate-500 font-mono">Batch: ${w.batch}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-amber-600 font-bold text-xs block">${w.daysRemaining} Days Left</span>
                                <span class="text-xs font-medium text-slate-500">${w.qty} units</span>
                            </div>
                        </div>
                    `;
                });
            }
        }
    </script>
</body>
</html>