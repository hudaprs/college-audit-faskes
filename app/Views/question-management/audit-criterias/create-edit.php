<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit Audit Criteria' : ($isDetail ? 'Detail Audit Criteria' : 'Create Audit Criteria') ?>
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
                    <?= $isDetail ? 'Audit Criteria Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('question-management/audit-criterias') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form
                action="<?= $isEdit ? base_url('question-management/audit-criterias/'.$auditCriteria->id.'/update') : base_url('question-management/audit-criterias/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Criteria -->
                <div class="form-group">
                    <label for="name">Question</label>
                    <input type="text" class="form-control" name="criteria" id="criteria" placeholder="Enter Criteria"
                        value="<?= old('criteria') ? old('criteria') : (isset($auditCriteria) ? $auditCriteria->criteria : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="address">Description</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Enter Description" <?= $isDetail ? 'disabled' : '' ?>><?= old('description') ? old('description') : (isset($auditCriteria) ? $auditCriteria->description: null) ?></textarea>
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