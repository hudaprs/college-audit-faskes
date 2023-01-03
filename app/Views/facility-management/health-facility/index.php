<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Facility Management</h1>
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
                <h3 class="card-title">Health Facility List</h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('facility-management/health-facility/create') ?>" class="btn btn-primary">
                    Create Healt Facility
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th width="100px">Created By</th>
                            <th>Created At</th>
                            <th class="text-center" width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(sizeof($health_facilities)): ?>
                            <?php foreach($health_facilities as $healthFacility): ?>
                            <tr>
                                <td><?= $healthFacility->name ?></td>
                                <td><?= $healthFacility->code ?></td>
                                <td><?= $healthFacility->type ?></td>
                                <td><?= $healthFacility->address ?></td>
                                <td><?= $healthFacility->created_by ?></td>
                                <td><?= $healthFacility->created_at ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url("facility-management/health-facility/$healthFacility->id") ?>" class="btn btn-success">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url("facility-management/health-facility/$healthFacility->id/edit") ?>" class="btn btn-secondary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url("facility-management/health-facility/$healthFacility->id/delete") ?>" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
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