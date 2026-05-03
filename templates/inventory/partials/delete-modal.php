<?php use App\Config\Helpers; ?>
<div class="modal" id="delete-<?= $p['id'] ?>">
    <div class="modal-box" style="width:min(420px,96vw)">
        <button class="modal-close" data-close type="button">&times;</button>
        <h2>Delete Item</h2>
        <p class="confirm-text">Are you sure you want to delete <b><?= htmlspecialchars($p['name_en']) ?></b>? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="secondary-btn" data-close type="button">Cancel</button>
            <form method="post" action="<?= Helpers::url('/products/' . $p['id'] . '/delete') ?>">
                <button class="danger-btn" type="submit">Delete</button>
            </form>
        </div>
    </div>
</div>
