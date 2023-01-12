<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Audit Request</h1>
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
                <h3 class="card-title">User List</h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('audits/create') ?>" class="btn btn-primary">
                    Create Audit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Health Facility</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($audits) > 0): ?>
                            <?php foreach ($audits as $audit): ?>
                                <tr>
                                    <td><?= $audit['name'] ?></td>
                                    <td><?= $audit['code'] ?></td>
                                    <td><?= $audit['status'] ?></td>
                                    <td><?= $audit['created_by'] ?></td>
                                    <td><?= $audit['created_at'] ?></td>
                                    <td><?= $audit['updated_at'] ?></td>
                                    <td>
                                    <a href="<?= base_url("audits/$audit->id/edit") ?>" class="btn btn-secondary">
                                        <em class="fa fa-edit"></em>
                                    </a>
                                    </td>
                                </tr>
                            <?php endforeach;  ?>
                        <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="100%">
                                    No Record Found
                                </td> 
                            </tr>
                        <?php endif; ?>
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