<?php use App\Config\Helpers; ?>
<?php $p = []; ?>
<div class="modal" id="addModal">
    <div class="modal-content small-modal">
        <button class="close" data-close>&times;</button>
        <h2>Add Product</h2>
        <form method="post" action="<?= Helpers::url('/products') ?>" class="form-stack">
            <?php include __DIR__ . '/product-form-fields.php'; ?>
            <button class="primary-btn">Add Product</button>
        </form>
    </div>
</div>
