<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-5 border-b border-gray-200 mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Monthly Loss & Write-off Audits</h1>
    <button class="mt-3 sm:mt-0 inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors" onclick="window.print()">
        <i class="fa-solid fa-print mr-2"></i> Print Dossier
    </button>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
    <div class="bg-white p-5 rounded-xl border-l-4 border-red-600 shadow-sm">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Financial Write-off Cumulative Value</p>
        <p class="text-2xl font-extrabold text-red-600 mt-1">$<?= number_format($monthlyLoss, 2) ?></p>
    </div>
    <div class="bg-white p-5 rounded-xl border-l-4 border-gray-400 shadow-sm">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Non-Conforming Expired Batches</p>
        <p class="text-2xl font-extrabold text-gray-700 mt-1"><?= $expiredCount ?> Lots Affected</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">Product Definition</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Lot Tag Ref</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Expiry Boundary</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Defunct Qty</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Loss Financial Value</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php if(empty($reportData)): ?>
                    <tr><td colspan="5" class="text-center py-6 text-sm text-gray-400 font-medium">Excellent. No expired batch metrics caught in localized system state loops.</td></tr>
                <?php endif; ?>
                <?php foreach($reportData as $row): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3.5 font-semibold text-gray-900"><?= htmlspecialchars($row['product_name']) ?></td>
                        <td class="px-4 py-3.5 font-mono text-xs text-gray-600"><code><?= htmlspecialchars($row['lot_number']) ?></code></td>
                        <td class="px-4 py-3.5 text-gray-500"><?= htmlspecialchars($row['expiry_date']) ?></td>
                        <td class="px-4 py-3.5 text-gray-700"><?= htmlspecialchars((string)$row['quantity']) ?></td>
                        <td class="px-4 py-3.5 text-red-600 font-semibold">$<?= number_format($row['lost_value'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>