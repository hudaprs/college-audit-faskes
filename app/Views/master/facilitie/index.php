<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Facilities</h1>
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
                <h3 class="card-title">Facilities List</h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('master/facilitie/create') ?>" class="btn btn-primary">
                    Create Facilitie
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facilitie as $fac): ?>
                        <tr>
                            <td><?= $fac->name ?></td>
                            <td><?= $fac->created_at ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("master/facilitie/$fac->id") ?>" class="btn btn-success">
                                    <em class="fa fa-eye"></em>
                                </a>
                                <a href="<?= base_url("master/facilitie/$fac->id/edit") ?>" class="btn btn-secondary">
                                    <em class="fa fa-edit"></em>
                                </a>
                                <a href="<?= base_url("master/facilitie/$fac->id/delete") ?>" class="btn btn-danger">
                                    <em class="fa fa-trash"></em>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
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