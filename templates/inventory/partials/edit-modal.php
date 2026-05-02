<?php use App\Config\Helpers; ?>
<div class="modal" id="edit-<?= $p['id'] ?>">
    <div class="modal-content small-modal">
        <button class="close" data-close>&times;</button>
        <h2>Edit Product</h2>
        <form method="post" action="<?= Helpers::url('/products/' . $p['id'] . '/update') ?>" class="form-stack">
            <?php include __DIR__ . '/product-form-fields.php'; ?>
            <button class="primary-btn">Save Changes</button>
        </form>
    </div>
</div>
