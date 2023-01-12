<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
                <h1>Mapping Health Facility Auditor</h1>
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
                    Map Facility Form
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
                action="<?= $isEdit ? base_url('facility-management/mapping-facility/'.$healthFacility->id.'/update') : base_url('facility-management/mapping-facility/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Health Facilities -->
                <div class="form-group">
                    <label for="health-facilities">Health Facilities</label>
                    <input type="text" class="form-control " id="name" placeholder="Enter name" disabled
                        value="<?= old('name') ? old('name') : (isset($healthFacility) ? $healthFacility->name : null) ?>">
                    <input type="hidden" class="form-control " name="health_facility_id" id="name" placeholder="Enter name"
                        value="<?= old('name') ? old('name') : (isset($healthFacility) ? $healthFacility->id : null) ?>">
                </div>

                <!-- Facilities -->
                <div class="form-group">
                    <label for="facilities">Facility</label>
                    <select name="facility_id[]" id="facilities" class="form-control" multiple>
                        <?php foreach ($facilities as $f): ?>
                            <option value="<?= $f->id ?>" <?=(old('facility_id[]') ? old('facility_id[]') : (isset($mappingFacility) ? in_array($f->id, $mappingFacility) : null)) ? 'selected' : '' ?>>
                                <?= $f->name ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->section('javascript') ?>
<script>
    $(function () {
        $('#health-facilities').select2()
        $('#facilities').select2()
    })
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>