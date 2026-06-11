<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card bg-white p-4">
            <h4 class="card-title text-primary fw-bold mb-3"><i class="fa-solid fa-truck-moving me-2 text-primary"></i>Stock Dispatch (FEFO Allocation Engine)</h4>
            <p class="text-muted small">Auto-picks active items according to the optimal legal health compliance framework sequencing logic.</p>
            <hr>

            <?php if($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if($error): ?>
                <div class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="/index.php?route=stock_dispatch" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Select Product Target</label>
                    <select name="product_id" class="form-select" required>
                        <?php foreach($products as $p): ?>
                            <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getName()) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Quantity Requested for Dispatch</label>
                    <input type="number" name="quantity" class="form-control" min="1" required placeholder="e.g. 50">
                </div>
                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm w-100">Process FEFO Resolution Dispatch</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>