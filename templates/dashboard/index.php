<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-dark font-weight-bold">Pharmacy Dashboard</h1>
    <div class="input-group w-25">
        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Search index metrics...">
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 border-start border-primary border-4 bg-white h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-light text-primary rounded-circle me-3"><i class="fa-solid fa-prescription-bottle fa-2x"></i></div>
                <div>
                    <h6 class="text-muted small uppercase mb-1">Total Products</h6>
                    <h3 class="mb-0 fw-bold"><?= $stats['total_products'] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 border-start border-success border-4 bg-white h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-light text-success rounded-circle me-3"><i class="fa-solid fa-boxes-stacked fa-2x"></i></div>
                <div>
                    <h6 class="text-muted small uppercase mb-1">Total Active Lots</h6>
                    <h3 class="mb-0 fw-bold"><?= $stats['total_lots'] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 border-start border-warning border-4 bg-white h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-light text-warning rounded-circle me-3"><i class="fa-solid fa-hourglass-half fa-2x"></i></div>
                <div>
                    <h6 class="text-muted small uppercase mb-1">Expiring 90 Days</h6>
                    <h3 class="mb-0 fw-bold"><?= $stats['expiring_90'] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 border-start border-danger border-4 bg-white h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-light text-danger rounded-circle me-3"><i class="fa-solid fa-triangle-exclamation fa-2x"></i></div>
                <div>
                    <h6 class="text-muted small uppercase mb-1">Expired Lots</h6>
                    <h3 class="mb-0 fw-bold"><?= $stats['expired'] ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card bg-white p-3 h-100">
            <h5 class="card-title text-danger mb-3 fw-bold"><i class="fa-solid fa-circle-exclamation me-2"></i>Critical Tracking Index (&lt; 30 Days Remaining)</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>Product</th><th>Lot #</th><th>Expiry</th><th>Qty</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php if(empty($criticalLots)): ?><tr><td colspan="5" class="text-center text-muted small py-3">No immediate critical expiration hazards reported.</td></tr><?php endif; ?>
                        <?php foreach($criticalLots as $lot): 
                            $prod = $productRepo->findById($lot->getProductId()); ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($prod ? $prod->getName() : 'Unknown') ?></strong></td>
                                <td><code class="text-dark"><?= htmlspecialchars($lot->getLotNumber()) ?></code></td>
                                <td class="text-danger fw-semibold"><?= $lot->getExpirationDate() ?></td>
                                <td><?= $lot->getQuantity() ?></td>
                                static <td><span class="badge <?= $lot->getStatus()->getBadgeClass() ?>"><?= $lot->getStatus()->value ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card bg-white p-3 h-100">
            <h5 class="card-title text-warning mb-3 fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Warning Tracking Index (30 - 90 Days Remaining)</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>Product</th><th>Lot #</th><th>Expiry</th><th>Qty</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php if(empty($warningLots)): ?><tr><td colspan="5" class="text-center text-muted small py-3">No warning metrics identified across structural indexes.</td></tr><?php endif; ?>
                        <?php foreach($warningLots as $lot): 
                            $prod = $productRepo->findById($lot->getProductId()); ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($prod ? $prod->getName() : 'Unknown') ?></strong></td>
                                <td><code class="text-dark"><?= htmlspecialchars($lot->getLotNumber()) ?></code></td>
                                <td class="text-warning fw-semibold"><?= $lot->getExpirationDate() ?></td>
                                <td><?= $lot->getQuantity() ?></td>
                                <td><span class="badge <?= $lot->getStatus()->getBadgeClass() ?>"><?= $lot->getStatus()->value ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>