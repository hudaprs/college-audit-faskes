<?php if (!empty(session()->getFlashdata('error'))): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error'); ?>
</div>
<?php endif; ?>

<?php if (!empty(session()->getFlashdata('success'))): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success'); ?>
</div>
<?php endif; ?>