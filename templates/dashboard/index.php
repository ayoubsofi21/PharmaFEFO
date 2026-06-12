<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-5 border-b border-gray-200 mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Pharmacy Dashboard</h1>
    <div class="mt-3 sm:mt-0 relative max-w-xs w-full">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
        </div>
        <input type="text" class="block w-full pl-9 pr-3 py-1.5 bg-white border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" placeholder="Search metrics...">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-5 rounded-xl border-l-4 border-blue-600 shadow-sm flex items-center">
        <div class="p-3 bg-blue-50 text-blue-600 rounded-full mr-4"><i class="fa-solid fa-prescription-bottle text-xl"></i></div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Products</p>
            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?= $stats['total_products'] ?></p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border-l-4 border-emerald-600 shadow-sm flex items-center">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-full mr-4"><i class="fa-solid fa-boxes-stacked text-xl"></i></div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Lots</p>
            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?= $stats['total_lots'] ?></p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border-l-4 border-amber-50 shadow-sm flex items-center">
        <div class="p-3 bg-amber-50 text-amber-600 rounded-full mr-4"><i class="fa-solid fa-hourglass-half text-xl"></i></div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Expiring 90 Days</p>
            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?= $stats['expiring_90'] ?></p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border-l-4 border-red-600 shadow-sm flex items-center">
        <div class="p-3 bg-red-50 text-red-600 rounded-full mr-4"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Expired Lots</p>
            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?= $stats['expired'] ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
        <h5 class="text-base font-bold text-red-600 mb-4 flex items-center"><i class="fa-solid fa-circle-exclamation mr-2"></i>Critical Index (&lt; 30 Days Remaining)</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Product</th>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Lot #</th>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Expiry</th>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php if(empty($criticalLots)): ?><tr><td colspan="4" class="text-center text-gray-400 text-xs py-4">No immediate critical hazards reported.</td></tr><?php endif; ?>
                    <?php foreach($criticalLots as $lot): $prod = $productRepo->findById($lot->getProductId()); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-3 font-semibold text-gray-900"><?= htmlspecialchars($prod ? $prod->getName() : 'Unknown') ?></td>
                            <td class="px-3 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($lot->getLotNumber()) ?></td>
                            <td class="px-3 py-3 text-red-600 font-medium"><?= $lot->getExpirationDate() ?></td>
                            <td class="px-3 py-3 text-gray-700"><?= $lot->getQuantity() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
        <h5 class="text-base font-bold text-amber-500 mb-4 flex items-center"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Warning Index (30 - 90 Days Remaining)</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Product</th>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Lot #</th>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Expiry</th>
                        <th class="px-3 py-2.5 font-semibold text-gray-600">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php if(empty($warningLots)): ?><tr><td colspan="4" class="text-center text-gray-400 text-xs py-4">No warning metrics identified across tracking arrays.</td></tr><?php endif; ?>
                    <?php foreach($warningLots as $lot): $prod = $productRepo->findById($lot->getProductId()); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-3 font-semibold text-gray-900"><?= htmlspecialchars($prod ? $prod->getName() : 'Unknown') ?></td>
                            <td class="px-3 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($lot->getLotNumber()) ?></td>
                            <td class="px-3 py-3 text-amber-600 font-medium"><?= $lot->getExpirationDate() ?></td>
                            <td class="px-3 py-3 text-gray-700"><?= $lot->getQuantity() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>