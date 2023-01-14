<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Audit DPF</title>

        <style>
            .text-left {
                text-align: left;
            }
            
            .w-100 {
                width: 100%;
            }

            table {
                border-collapse: collapse;
            }

            table, td, th {
                border: 1px solid;
            }

            td, th {
                padding: 4px;
            }
        </style>
    </head>

    <body>
        <div>
            <div class="w-100">
                <div class="w-100">
                    <div style="width: 180px; display: inline-block;"><b>Kode</b></div>
                    <div style="display: inline-block;">: <?= $audit->code ?></div>
                </div>
                <div class="w-100">
                    <div style="width: 180px; display: inline-block;"><b>Nama unit yang diaudit</b></div>
                    <div style="display: inline-block;">: <?= $healthFacility->name ?></div>
                </div>
                <div class="w-100">
                    <div style="width: 180px; display: inline-block;"><b>Auditor</b></div>
                    <div style="display: inline-block;">: <?= implode(', ', $auditors) ?></div>
                </div>
                <div class="w-100">
                    <div style="width: 180px; display: inline-block;"><b>Waktu pelaksanaan</b></div>
                    <div style="display: inline-block;">: <?= date('d M Y, H:i') ?></div>
                </div>
            </div>
        </div>
        <br>
        <div>
            <b>Instrumen Audit:</b>
        </div>
        <div>
            <table class="text-left w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit</th>
                        <th>Kritedia Audit</th>
                        <th>Daftar Pertanyaan</th>
                        <th>Observasi</th>
                        <th>Telusur <br> Dokumen</th>
                        <th>Fakta <br> Lapangan</th>
                        <th>Temuan <br> Audit</th>
                        <th>Rekomendasi <br> Audit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    <?php foreach($auditQuestions as $auditQuestion): ?>
                        <?php $auditQuestionIdx = 0; ?>
                        <?php foreach($auditQuestion['criterias'] as $criteria): ?>
                            <?php $criteriaIdx = 0; ?>
                            <?php foreach($criteria['questions'] as $idx => $question): ?>
                                <tr>
                                    <th><?= $auditQuestionIdx == 0 ? $no : '' ?></th>
                                    <td><?= $auditQuestionIdx == 0 ? $auditQuestion['facility_name'] : '' ?></td>
                                    <td><?= $criteriaIdx == 0 ? $criteria['criteria'] : '' ?></td>
                                    <td><?= $question['question'] ?></td>
                                    <td><?= $question['observation'] ?></td>
                                    <td><?= $question['browse_document'] ?></td>
                                    <td><?= $question['field_fact'] ?></td>
                                    <td><?= $question['findings'] ?></td>
                                    <td><?= $question['recommendation'] ?></td>
                                </tr>

                                <?php $auditQuestionIdx += 1; ?>
                                <?php $criteriaIdx += 1; ?>
                            <?php endforeach ?>
                        <?php endforeach ?>

                        <?php $no += 1 ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </body>
</html>