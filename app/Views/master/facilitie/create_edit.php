<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit Facilitie' : ($isDetail ? 'Detail Facilitie' : 'Create Facilitie') ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="w-100">
                <h3 class="card-title">
                    <?= $isDetail ? 'Facilitie Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('master/facilitie') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form
                action="<?= $isEdit ? base_url('master/facilitie/' . $facilitie->id . '/update') : base_url('master/facilitie/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"
                        value="<?= old('name') ? old('name') : (isset($facilitie) ? $facilitie->name : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>

                <div class="<?= $isDetail ? 'd-none' : 'd-flex' ?> justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Edit' : 'Submit' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>