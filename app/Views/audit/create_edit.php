<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit Audit' : ($isDetail ? 'Detail Audit' : 'Create Audit') ?>
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
                    <?= $isDetail ? 'User Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('audits/index') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form action="<?= $isEdit ? base_url('audits/' . $audit->id . '/update') : base_url('audits/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Health Facility</label>
                    <select name="health_facility" id="health-facility-list" style="width: 100%;">
                        <?php foreach ($healthFacilityList as $healthFacility): ?>
                            <option value="<?= $healthFacility->id ?>" <?=(old('health_facility') ? old('health_facility') : (isset($audit) ? $audit->health_facility_id : null)) === $healthFacility->id ? 'selected' : '' ?>>
                                <?= $healthFacility->name ?> - <?= $healthFacility->code ?>
                            </option>
                        <?php endforeach; ?>
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

<?= $this->section('javascript') ?>
<script>
    $(function () {
        $('#health-facility-list').select2()
    })
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>