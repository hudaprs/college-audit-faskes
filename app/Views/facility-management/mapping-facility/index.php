<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Mapping Facility</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <!-- Flash Message -->
    <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="w-100">
                <h3 class="card-title">Mapping Facility List</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Health Facilities</th>
                            <th>Facilities</th>
                            <th>Created At</th>
                            <th class="text-center" width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(sizeof($mappingFacilities)): ?>
                            <?php foreach($mappingFacilities as $mappingFacility): ?>
                            <tr>
                                <td><?= $mappingFacility->health_facility_id ?></td>
                                <td><?= $mappingFacility->facility_id ?></td>
                                <td><?= $mappingFacility->created_at ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url("facility-management/mapping-facility/$mappingFacility->id/edit") ?>" class="btn btn-secondary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="100%">Tidak Ada Data</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <?= $pagination->links() ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>