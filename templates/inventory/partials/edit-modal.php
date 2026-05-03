<?php use App\Config\Helpers; ?>
<div class="modal" id="edit-<?= $p['id'] ?>">
    <div class="modal-box">
        <button class="modal-close" data-close type="button">&times;</button>
        <h2>Edit Item</h2>
        <form method="post" action="<?= Helpers::url('/products/' . $p['id'] . '/update') ?>" class="form-stack">
            <?php include __DIR__ . '/product-form-fields.php'; ?>
            <button class="primary-btn" type="submit">Save Changes</button>
        </form>
    </div>
</div>
