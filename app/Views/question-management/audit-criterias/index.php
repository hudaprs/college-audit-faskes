<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Question Management</h1>
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
                <h3 class="card-title">Audit Criteria List</h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('question-management/audit-criterias/create') ?>" class="btn btn-primary">
                    Create Audit Criteria
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Description</th>
                            <th width="100px">Created By</th>
                            <th>Created At</th>
                            <th class="text-center" width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($audit_criteria) > 0): ?>
                            <?php foreach($audit_criteria as $auditCriteria): ?>
                            <tr>
                                <td><?= $auditCriteria->criteria ?></td>
                                <td><?= $auditCriteria->description ?></td>
                                <td><?= $auditCriteria->created_by ?></td>
                                <td><?= $auditCriteria->created_at ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url("question-management/audit-criterias/$auditCriteria->id") ?>" class="btn btn-success">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url("question-management/audit-criterias/$auditCriteria->id/edit") ?>" class="btn btn-secondary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url("question-management/audit-criterias/$auditCriteria->id/delete") ?>" class="btn btn-danger">
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

        </div>
    </div>
</section>

<?= $this->endSection() ?>