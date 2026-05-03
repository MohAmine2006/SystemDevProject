<?php use App\Config\Helpers; ?>
<?php $p = []; ?>
<div class="modal" id="addModal">
    <div class="modal-box">
        <button class="modal-close" data-close type="button">&times;</button>
        <h2><?= t('modal_add_title') ?></h2>
        <form method="post" action="<?= Helpers::url('/products') ?>" class="form-stack">
            <?php include __DIR__ . '/product-form-fields.php'; ?>
            <button class="primary-btn" type="submit"><?= t('btn_add_item') ?></button>
        </form>
    </div>
</div>
