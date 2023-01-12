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
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="w-100">
                <h3 class="card-title">
                    Map Health Facility Auditor Form
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('facility-management/mapping-auditor') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <form
                action="<?= $isEdit ? base_url('facility-management/mapping-auditor/'.$healthFacility->id.'/update') : base_url('facility-management/mapping-auditor/store') ?>"
                method="POST">
                <?= csrf_field() ?>

                <!-- HealthFacility -->
                <div class="form-group">
                    <label for="health-facilities">Health Facilities</label>
                    <input type="text" class="form-control " id="name" placeholder="Enter name" disabled
                        value="<?= old('name') ? old('name') : (isset($healthFacility) ? $healthFacility->name : null) ?>">
                    <input type="hidden" class="form-control " name="health_facility_id" id="name" placeholder="Enter name"
                        value="<?= old('name') ? old('name') : (isset($healthFacility) ? $healthFacility->id : null) ?>">
                </div>

                <!-- Auditor -->
                <div class="form-group">
                    <label for="facilities">Auditor</label>
                    <select name="user_id[]" id="facilities" class="form-control" multiple>
                        <?php foreach ($user as $a): ?>
                            <option value="<?= $a->id ?>" <?=(old('user_id[]') ? old('user_id[]') : (isset($mappingAuditor) ? in_array($a->id, $mappingAuditor) : null)) ? 'selected' : '' ?>>
                                <?= $a->name ?>
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