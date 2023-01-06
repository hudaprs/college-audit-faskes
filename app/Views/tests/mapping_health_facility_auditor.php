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
                <a href="#" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="health-facilities">Health Facilities</label>
                <select name="health-facilities" id="health-facilities" class="form-control">
                    <option value="">Rumah Sakit</option>
                </select>
            </div>

            <div class="form-group">
                <label for="facilities">Auditor</label>
                <select name="facilities" id="facilities" class="form-control" multiple>
                    <option value="">John Doe</option>
                    <option value="">Jane Doe</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
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