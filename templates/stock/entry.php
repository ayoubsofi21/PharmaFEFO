<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card bg-white p-4">
            <h4 class="card-title text-primary fw-bold mb-3"><i class="fa-solid fa-square-plus me-2 text-success"></i>Receive Stock Intake</h4>
            <p class="text-muted small">Append modern trace allocations onto relational datastores.</p>
            <hr>

            <?php if($success): ?>
                <div class="alert alert-success">Batch lot ingestion operation committed to central register repository storage.</div>
            <?php endif; ?>
            <?php if(isset($errors['global'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errors['global']) ?></div>
            <?php endif; ?>

            <form action="/index.php?route=stock_entry" method="POST" novalidate>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Product Catalog Profile</label>
                    <select name="product_id" class="form-select <?= isset($errors['product_id']) ? 'is-invalid' : '' ?>">
                        <option value="0">Choose registered chemical definition target...</option>
                        <?php foreach($products as $p): ?>
                            <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getName()) ?> ($<?= number_format($p->getUnitPrice(), 2) ?>/unit)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= $errors['product_id'] ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Batch Lot Identification Label</label>
                    <input type="text" name="lot_number" class="form-control <?= isset($errors['lot_number']) ? 'is-invalid' : '' ?>" placeholder="e.g. LOT-2026-XYZ">
                    <div class="invalid-feedback"><?= $errors['lot_number'] ?? '' ?></div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-secondary small">Pack Volume Intake Quantity</label>
                        <input type="number" name="quantity" class="form-control <?= isset($errors['quantity']) ? 'is-invalid' : '' ?>" min="1" value="100">
                        <div class="invalid-feedback"><?= $errors['quantity'] ?? '' ?></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-secondary small">Expiration Threshold Limit</label>
                        <input type="date" name="expiration_date" class="form-control <?= isset($errors['expiration_date']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback"><?= $errors['expiration_date'] ?? '' ?></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm w-100">Log Intake Records</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>