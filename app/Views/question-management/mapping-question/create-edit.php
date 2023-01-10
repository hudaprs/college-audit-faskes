<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Mapping Question Item</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="w-100">
                <h3 class="card-title">
                    Map Question Form
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="/question-management/mapping-question" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <form
            action="<?= $isEdit ? base_url('question-management/mapping-question/1/update') : base_url('question-management/mapping-question/store') ?>"
            method="POST"
        >
            <?= csrf_field() ?>
            <div class="card-body">
                <!-- Flash Message -->
                <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

                <div class="row">
                    <div class="col-12 col-md-4 pr-2 pr-md-3 border-right">
                        <div class="form-group">
                            <label for="audit-criteria">Audit Criteria</label>
                            <input type="hidden" class="form-control" value="1" name="audit_criteria_id">
                            <input type="text" class="form-control" value="Criteria 1" disabled>
                        </div>
                        <div class="form-group">
                            <label for="audit-description">Audit Description</label>
                            <textarea class="form-control" id="audit-description" disabled>Ini adalah kriteria audit untuk....</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 pl-2 pl-md-3">
                        <div id="question-list">
                            <!-- Appended by jQuery -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    let auditQuestionItems = JSON.parse('<?= json_encode($auditQuestionItems) ?>')

    $(function () {
        let questionLength = 0

        /**
         * @description Make question
         * 
         * @return {string} string
         */
        function makeQuestion() {
            const questionEl = `
                <div class="row wrapper-question" id="wrapper-question-${questionLength}">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="question${questionLength}" class="question-label">Question ${questionLength + 1}</label>
                            <input type="text" name="questions[]" class="form-control" id="question${questionLength}">
                            <input type="hidden" name="audit_question_item_id[]" class="form-control" id="auditQuestionItemId${questionLength}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="d-flex w-100 h-100">
                            <button type="button" class="btn btn-success mt-auto mb-3 w-100 add-question ${questionLength === 0 ? '' : 'd-none'}">
                                <em class="fas fa-plus"></em>
                            </button>
                            <button type="button" class="btn btn-danger mt-auto mb-3 w-100 ${questionLength === 0 ? 'd-none' : ''} remove-question" data-id="${questionLength}">
                                <em class="fas fa-times"></em>
                            </button>
                        </div>
                    </div>
                </div>
            `

            return questionEl
        }

        /**
         * @description Render question list
         * 
         * @param {boolean} isFirstTime
         * @param {string} newQuestion
         * 
         * @return {void} void
         */
        function renderQuestionList(isFirstTime = false, newQuestion = '') {
            // Append to DOM
            $('#question-list').append(isFirstTime ? makeQuestion(0) : newQuestion)
        }

        // Start ender question list for the first time
        renderQuestionList(true)


        // Add another question
        $('body').on('click', '.add-question', function (event) {
            questionLength++

            renderQuestionList(false, makeQuestion())
        })

        auditQuestionItems.forEach((auditQuestionItem, idx) => {
            if(idx != 0) {
                questionLength++
                
                renderQuestionList(true, makeQuestion())
            }

            $(`#question${idx}`).val(auditQuestionItem.question)
            $(`#auditQuestionItemId${idx}`).val(auditQuestionItem.id)
        })

        // Remove question
        $('body').on('click', '.remove-question', function (event) {
            const elId = $(this).attr('data-id')

            // Remove element
            $(`body #wrapper-question-${elId}`).remove()

            // Decrease question length
            questionLength--

            $('.wrapper-question').each(function (index, element) {
                // Update wrapper
                $(element).attr('id', `wrapper-question-${index}`)

                // Update question label 
                $(element).find('.question-label').text(`Question ${index + 1}`)

                // Update index
                $(element).find('.remove-question').attr('data-id', index)

                // Update remove button
            })
        })
    })
</script>
<?= $this->endSection() ?>