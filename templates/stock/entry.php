<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h4 class="text-lg font-bold text-gray-900 mb-2 flex items-center"><i class="fa-solid fa-square-plus mr-2 text-emerald-600"></i>Receive Stock Intake</h4>
        <p class="text-xs text-gray-500 mb-6">Append modern batch track profiles onto structural datastores.</p>
        <hr class="border-gray-200 mb-6">

        <?php if($success): ?>
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm p-3 rounded-lg">Batch lot ingestion operation committed successfully.</div>
        <?php endif; ?>
        <?php if(isset($errors['global'])): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg"><?= htmlspecialchars($errors['global']) ?></div>
        <?php endif; ?>

        <form action="index.php?route=stock_entry" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Catalog Profile</label>
                <select name="product_id" class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($errors['product_id']) ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' ?>">
                    <option value="0">Choose registered definition object...</option>
                    <?php foreach($products as $p): ?>
                        <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getName()) ?> ($<?= number_format($p->getUnitPrice(), 2) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <?php if(isset($errors['product_id'])): ?><p class="mt-1 text-xs text-red-600"><?= $errors['product_id'] ?></p><?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Batch Lot Label Reference</label>
                <input type="text" name="lot_number" class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($errors['lot_number']) ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' ?>" placeholder="e.g. LOT-2026-XYZ">
                <?php if(isset($errors['lot_number'])): ?><p class="mt-1 text-xs text-red-600"><?= $errors['lot_number'] ?></p><?php endif; ?>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Pack Intake Quantity</label>
                    <input type="number" name="quantity" min="1" value="100" class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($errors['quantity']) ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' ?>">
                    <?php if(isset($errors['quantity'])): ?><p class="mt-1 text-xs text-red-600"><?= $errors['quantity'] ?></p><?php endif; ?>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Expiration Boundary Date Target</label>
                    <input type="date" name="expiration_date" class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($errors['expiration_date']) ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' ?>">
                    <?php if(isset($errors['expiration_date'])): ?><p class="mt-1 text-xs text-red-600"><?= $errors['expiration_date'] ?></p><?php endif; ?>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Log Intake Records
                </button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>