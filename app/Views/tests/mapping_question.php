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
                <a href="#" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="parent-question">Parent Question</label>
                <select name="parent-question" id="parent-question" class="form-control">
                    <option value="">Pertanyaan 1</option>
                    <option value="">Pertanyaan 2</option>
                    <option value="">Pertanyaan 3</option>
                </select>
            </div>

            <div id="question-list">
                <!-- Appended by jQuery -->
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
        let questionLength = 0

        /**
         * @description Make question
         * 
         * @return {string} string
         */
        function makeQuestion() {
            const questionEl = `
                <div class="row align-items-center wrapper-question" id="wrapper-question-${questionLength}">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="description" class="question-label">Question ${questionLength + 1}</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="d-flex text-center justify-content-center align-items-center">
                            <button type="button" class="btn btn-success btn-sm add-question">
                                <em class="fas fa-plus"></em>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm ml-2 ${questionLength === 0 ? 'd-none' : ''} remove-question" data-id="${questionLength}">
                                <em class="fas fa-minus"></em>
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

<?= $this->endSection() ?>