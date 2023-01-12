<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit Mapping Facility' : ($isDetail ? 'Detail Mapping Facility' : 'Create Mapping Facility') ?>
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
                    <?= $isDetail ? 'Mapping Facility Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('facility-management/mapping-facility') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form
                action="<?= $isEdit ? base_url('facility-management/mapping-facility/'.$mappingFacility->id.'/update') : base_url('facility-management/mapping-facility/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Health Facilities -->
                <div class="form-group">
                    <label for="name">Health Facilities</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"
                        value="<?= old('health_facility_id') ? old('health_facility_id') : (isset($mappingFacility) ? $mappingFacility->health_facility_id : null) ?>" <?= $isDetail ? 'disabled' : '' ?> disabled>
                        <input type="hidden" class="form-control" name="name" id="name" placeholder="Enter name"
                        value="<?= old('health_facility_id') ? old('health_facility_id') : (isset($mappingFacility) ? $mappingFacility->health_facility_id : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>

                <!-- Facilities -->
                <div class="form-group">
                    <label for="facilities">Facilities</label>
                    <select name="facilities" id="facilities" class="form-control" multiple>
                        <?php foreach ($facilities as $f) : ?>
                        <option value="<?= old('facility_id') ? old('facility_id') : (isset($mappingFacility) ? $mappingFacility->facility_id : null) ?>" <?= $isDetail ? 'disabled' : '' ?>><?= $f->name ?></option>
                        <?php endforeach ?>
                    </select>
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