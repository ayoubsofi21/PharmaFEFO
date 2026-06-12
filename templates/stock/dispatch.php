<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h4 class="text-lg font-bold text-gray-900 mb-2 flex items-center"><i class="fa-solid fa-truck-moving mr-2 text-blue-600"></i>Stock Dispatch (FEFO Allocation Engine)</h4>
        <p class="text-xs text-gray-500 mb-6">Auto-picks active items according to the optimal shelf-life expiration matrix parameters sequentially.</p>
        <hr class="border-gray-200 mb-6">

        <?php if($success): ?>
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm p-3 rounded-lg"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg flex items-center"><i class="fa-solid fa-triangle-exclamation mr-2"></i><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="index.php?route=stock_dispatch" method="POST" class="space-y-5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Select Product Target</label>
                <select name="product_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <?php foreach($products as $p): ?>
                        <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getName()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity Requested for Dispatch</label>
                <input type="number" name="quantity" min="1" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. 50">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Process FEFO Resolution Dispatch
                </button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>