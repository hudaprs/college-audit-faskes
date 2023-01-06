<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit Health Facility' : ($isDetail ? 'Detail Health Facility' : 'Create Health Facility') ?>
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
                    <?= $isDetail ? 'Health Facility Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('facility-management/health-facility') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form
                action="<?= $isEdit ? base_url('facility-management/health-facility/'.$healthFacility->id.'/update') : base_url('facility-management/health-facility/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"
                        value="<?= old('name') ? old('name') : (isset($healthFacility) ? $healthFacility->name : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>

                <?php if($isDetail): ?>
                <!-- Code -->
                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="Enter code"
                        value="<?= old('code') ? old('code') : (isset($healthFacility) ? $healthFacility->code : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>
                <?php endif ?>

                <!-- Type -->
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" <?= $isDetail ? 'disabled' : '' ?>>
                        <?php foreach ($healthFacilityTypeList as $healthFacilityType): ?>
                            <option value="<?= $healthFacilityType ?>" <?=(old('type') ? old('type') : (isset($healthFacility) ? $healthFacility->type : null)) === $healthFacilityType ? 'selected' : '' ?>>
                                <?= $healthFacilityType ?>
                            </option>
                            <?php endforeach ?>
                    </select>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" placeholder="Enter address" <?= $isDetail ? 'disabled' : '' ?>><?= old('address') ? old('address') : (isset($healthFacility) ? $healthFacility->address : null) ?></textarea>
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