<?php use App\Config\Helpers; ?>
<div class="modal" id="delete-<?= $p['id'] ?>">
    <div class="modal-box" style="width:min(420px,96vw)">
        <button class="modal-close" data-close type="button">&times;</button>
        <h2><?= t('modal_delete_title') ?></h2>
        <p class="confirm-text">
            <?= t('delete_confirm_pre') ?> <b><?= htmlspecialchars($p['name_en']) ?></b><?= t('delete_confirm_post') ?>
        </p>
        <div class="modal-actions">
            <button class="secondary-btn" data-close type="button"><?= t('btn_cancel') ?></button>
            <form method="post" action="<?= Helpers::url('/products/' . $p['id'] . '/delete') ?>">
                <button class="danger-btn" type="submit"><?= t('btn_delete') ?></button>
            </form>
        </div>
    </div>
</div>
