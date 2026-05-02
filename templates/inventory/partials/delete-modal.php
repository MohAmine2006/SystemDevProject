<?php use App\Config\Helpers; ?>
<div class="modal" id="delete-<?= $p['id'] ?>">
    <div class="modal-content confirm-modal">
        <button class="close" data-close>&times;</button>
        <h2>Delete Product</h2>
        <p>Are you sure you want to delete <b><?= htmlspecialchars($p['name_en']) ?></b>?</p>
        <div class="modal-actions">
            <button class="secondary-btn" data-close type="button">Cancel</button>
            <form method="post" action="<?= Helpers::url('/products/' . $p['id'] . '/delete') ?>"><button class="danger-btn">Delete</button></form>
        </div>
    </div>
</div>
