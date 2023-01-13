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
                <h3 class="card-title">Mapping Question List</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Criteria</th>
                            <th>Questions</th>
                            <th class="text-center" width="180px">Mapping Question</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($auditCriterias) > 0): ?>
                            <?php foreach ($auditCriterias as $auditCriteria): ?>
                                <tr>
                                    <td>
                                        <?= $auditCriteria->criteria ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($auditCriteria->question_list)): ?>
                                            <ul class="pl-3">
                                                <?php foreach ($auditCriteria->question_list as $question): ?>
                                                    <li><?= $question->question ?></li>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php else: ?>
                                            -
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/question-management/mapping-question/<?= $auditCriteria->id ?>/edit"
                                            class="btn btn-secondary">
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

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>