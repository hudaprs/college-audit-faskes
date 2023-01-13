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
    <!-- Flash Message -->
    <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

    <div class="card">
        <div class="card-header">
            <div class="w-100">
                <h3 class="card-title">Mapping Auditor List</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Health Facility</th>
                            <th>Code</th>
                            <th>Created At</th>
                            <!-- <th>Updated At</th> -->
                            <th class="text-center" width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($health_facilities) > 0): ?>
                            <?php foreach($health_facilities as $healthFacility): ?>
                            <tr>
                                <td><?= $healthFacility->name ?></td>
                                <td><?= $healthFacility->code ?></td>
                                <td><?= $healthFacility->created_at ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url("facility-management/mapping-auditor/$healthFacility->id/edit") ?>" class="btn btn-secondary">
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