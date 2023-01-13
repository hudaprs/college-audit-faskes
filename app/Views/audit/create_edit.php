<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit Audit' : ($isDetail ? 'Detail Audit' : 'Create Audit') ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="w-100">
                <h3 class="card-title">
                    <?= $isDetail ? 'User Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('audits') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form action="<?= $isEdit ? base_url('audits/' . $audit->id . '/update') : base_url('audits/store') ?>"
                method="post">
                <?= csrf_field() ?>
                <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />


                <!-- Health Facility -->
                <div class="form-group">
                    <label for="name">Health Facility</label>
                    <select name="health_facility" id="health-facility-list" style="width: 100%;" <?= $isEdit ? 'disabled' : '' ?>>
                        <option>--Select Health Facility--</option>
                        <?php foreach ($healthFacilityList as $healthFacility): ?>
                            <option value="<?= $healthFacility->id ?>" <?=(old('health_facility') ? old('health_facility') : (isset($audit) ? $audit->health_facility_id : null)) == $healthFacility->id ? 'selected' : '' ?>>
                                <?= $healthFacility->name ?> - <?= $healthFacility->code ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($isEdit): ?>
                    <?php foreach ($facilityDetail as $itemDetailIndex => $itemDetail): ?>
                        <!-- Facility -->
                        <div class="row wrapper-content" id="wrapper-content-${contentLength}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="d-flex align-items-center mb-2">
                                        <label for="facility-${contentLength}" class="facility-label">Facility <?= $itemDetailIndex + 1 ?></label>
                                    </div>
                                    <input type="text" class="form-control" value="<?= $itemDetail->name ?>" disabled />
                                </div>
                            </div>
                        </div>

                        <?php foreach ($auditCriteriaList as $auditCriteria): ?>
                            <?php if ($auditCriteria->facility_id === $itemDetail->id): ?>
                                <!-- Criteria -->
                                <div class="row wrapper-criteria" style="margin-left: 15px;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="<?= $auditCriteria->criteria ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question -->
                                <?php foreach ($questionDetail as $questionIndex => $question): ?>
                                    <?php if ($itemDetail->id === $auditCriteria->facility_id && $auditCriteria->id === $question->audit_item_id): ?>
                                        <div class="row wrapper-question" style="margin-left: 30px;">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="question-<?= $questionIndex ?>">Question</label>
                                                    <input type="text" class="form-control question" id="question-<?= $questionIndex ?>"
                                                        data-id="<?= $question->id ?>" class="form-control" value="<?= $question->question ?>"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="observation-<?= $questionIndex ?>">Observation</label>
                                                    <input type="text" id="observation-<?= $questionIndex ?>" class="form-control observation"
                                                        value="<?= $question->observation ?>" data-id="<?= $question->id ?>"
                                                        <?= $audit->status === \App\Helpers\AuditHelper::ON_PROGRESS ? '' : 'disabled' ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="browse_document-<?= $questionIndex ?>">Browse Document</label>
                                                    <input type="text" id="browse_document-<?= $questionIndex ?>" data-id="<?= $question->id ?>"
                                                        class="form-control browse_document" value="<?= $question->browse_document ?>"
                                                        <?= $audit->status === \App\Helpers\AuditHelper::ON_PROGRESS ? '' : 'disabled' ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="field_fact-<?= $questionIndex ?>">Field Fact</label>
                                                    <input type="text" id="field_fact-<?= $questionIndex ?>" data-id="<?= $question->id ?>"
                                                        class="form-control field_fact" value="<?= $question->field_fact ?>"
                                                        <?= $audit->status === \App\Helpers\AuditHelper::ON_PROGRESS ? '' : 'disabled' ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="findings-<?= $questionIndex ?>">Findings</label>
                                                    <input type="text" id="findings-<?= $questionIndex ?>" data-id="<?= $question->id ?>"
                                                        class="form-control findings" value="<?= $question->findings ?>"
                                                        <?= $audit->status === \App\Helpers\AuditHelper::ON_PROGRESS ? '' : 'disabled' ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="recommendation-<?= $questionIndex ?>">Recommendation</label>
                                                    <input type="text" id="recommendation-<?= $questionIndex ?>" data-id="<?= $question->id ?>"
                                                        class="form-control recommendation" value="<?= $question->recommendation ?>"
                                                        <?= $audit->status === \App\Helpers\AuditHelper::ON_PROGRESS ? '' : 'disabled' ?>>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!$isEdit): ?>
                    <!-- Facility List -->
                    <div id="facility-list">
                        <!-- Appended By Jquery -->
                    </div>
                <?php endif; ?>


                <div class="<?= $isDetail ? 'd-none' : 'd-flex' ?> justify-content-end">
                    <?php if (isset($audit)): ?>
                        <button type="submit" class="btn btn-primary" <?= $audit->status === \App\Helpers\AuditHelper::DONE ? 'disabled' : '' ?>>
                            <?= $isEdit && $audit->status === \App\Helpers\AuditHelper::PENDING ? 'Start' : ($audit->status === \App\Helpers\AuditHelper::ON_PROGRESS ? 'Done' : 'Completed') ?>
                        </button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $(function () {
        let contentLength = 0
        let criteriaLength = 0
        let facilityList = []
        let criteriaList = JSON.parse('<?= json_encode($auditCriteriaList) ?>')


        $('#health-facility-list').select2()

        // Watch any change in health facility list
        $('#health-facility-list').on('change', async function (event) {
            $("body .wrapper-content").remove()
            $("body .criteria-list-wrapper").remove()
            contentLength = 0
            let criteriaLength = 0

            if ($(this).val() !== '--Select Health Facility--') {
                $.ajax({
                    url: `<?= base_url('/audits/create') ?>?health_facility_id=${$(this).val()}`,
                    success: function (result) {
                        facilityList = result.facilityList.map(facilityList => ({
                            ...facilityList,
                            facility_id: parseInt(facilityList.facility_id)
                        }))

                        renderContent(true, makeContent())

                        activateDynamicSelect2()

                        handleAddFacilityButton()
                    }
                })
            }
        })

        function activateDynamicSelect2() {
            $(`body #facility-${contentLength}`).select2()
        }

        function handleAddFacilityButton() {
            const el = $('body .add-content')

            if (contentLength + 1 === facilityList.length) {
                el.hide()
            } else {
                el.show()
            }
        }

        /**
         * @description Make content
         * 
         * @return {string} string
         */
        function makeContent() {
            handleAddFacilityButton()

            const contentEl = `
                <div class="row wrapper-content" id="wrapper-content-${contentLength}">
                    <div class="col-md-11">
                        <div class="form-group">
                            <div class="d-flex align-items-center mb-2">
                                <label for="facility-${contentLength}" class="facility-label">Facility ${contentLength + 1}</label>
                                <button type="button" class="btn btn-success mt-auto ml-3 btn-sm add-content ${contentLength === 0 ? '' : 'd-none'}">
                                    <em class="fas fa-plus"></em>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm mt-auto ml-3 ${contentLength === 0 ? 'd-none' : ''} remove-facility" data-id="${contentLength}">
                                    <em class="fas fa-times"></em>
                                </button>
                            </div>
                            <select name="facility[]" class="form-control facility-select-option" id="facility-${contentLength}">
                                <option value="">--Select Facility--</option>
                                ${facilityList.map(facility => {
                return `<option value="${facility.facility_id}">${facility.facility_name}</option>`
            })}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="d-flex w-100 h-100">
                        <button type="button" class="btn btn-success mt-auto mb-3 btn-sm add-criteria d-none" id="add-criteria-${contentLength}" data-id="${contentLength}">
                            Add Criteria
                        </button>
                        </div>
                    </div>
                </div>
                
                <div class="criteria-list-wrapper" id="criteria-list-${contentLength}">
                    <!-- Appended By Jquery -->
                </div>
            `


            return contentEl
        }

        /**
         * @description Make criteria
         * 
         * @param {number} contentIndex
         * 
         * @return {string} string
         */
        function makeCriteria(contentIndex) {
            const contentEl = `
                <div class="row wrapper-criteria" id="wrapper-criteria-${criteriaLength}" style="margin-left: 60px;">
                    <div class="col-md-11">
                        <div class="form-group">
                            <select name="criteria[]" class="form-control criteria-select-option" id="criteria-list-${criteriaLength}">
                                <option value="">--Select Criteria--</option>
                                ${criteriaList.map(criteria => {
                return `<option value='${parseInt($(`#facility-${contentIndex}`).val())}-${criteria.id}' class="criteria-value-${contentIndex}">${criteria.criteria}</option>`
            })}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="d-flex w-100 h-100">
                            <button type="button" class="btn btn-danger btn-sm mt-auto mb-3 ${criteriaLength === 0 ? 'd-none' : ''} remove-criteria" data-id="${criteriaLength}">
                                <em class="fas fa-times"></em>
                            </button>
                        </div>
                    </div>
                </div>
            `

            return contentEl
        }

        /**
         * @description Render content list
         * 
         * @param {boolean} isFirstTime
         * @param {string} newContent
         * 
         * @return {void} void
         */
        function renderContent(isFirstTime = false, newContent = '') {
            if (isFirstTime) {
                $("body #facility-list .wrapper-content").remove()
            }

            // Append to DOM
            $('#facility-list').append(isFirstTime ? makeContent(0) : newContent)
        }

        // Add another content
        $('body').on('click', '.add-content', function (event) {
            contentLength++

            renderContent(false, makeContent())
            activateDynamicSelect2()
        })

        // Remove content
        $('body').on('click', '.remove-facility', function (event) {
            const elId = $(this).attr('data-id')

            // Remove element
            $(`body #wrapper-content-${elId}`).remove()

            // Decrease content length
            contentLength--

            handleAddFacilityButton()

            $('.wrapper-content').each(function (index, element) {
                // Update wrapper
                $(element).attr('id', `wrapper-content-${index}`)

                // Update content label 
                $(element).find('.facility-label').text(`Facility ${index + 1}`)

                // Update remove button index
                $(element).find('.remove-facility').attr('data-id', index)
            })
        })

        // Add Criteria
        $('body').on('click', '.add-criteria', function (event) {
            criteriaLength++

            const elId = $(this).attr('data-id')

            $(`body #criteria-list-${elId}`).append(makeCriteria(elId))
        })

        // Remove Criteria
        $('body').on('click', '.remove-criteria', function (event) {
            const elId = $(this).attr('data-id')

            // Remove element
            $(`body #wrapper-criteria-${elId}`).remove()

            // Decrease content length
            criteriaLength--

            $('.wrapper-criteria').each(function (index, element) {
                // Update wrapper
                $(element).attr('id', `wrapper-criteria-${index}`)

                // Update remove button index
                $(element).find('.remove-criteria').attr('data-id', index)
            })
        })

        // Watch Facility List
        $('body').on('change', '.facility-select-option', function (event) {
            const elId = $(this).attr('id')?.split('-')?.[1]

            $(`.criteria-value-${elId}`).val(`${$(this).val()}-${$(`.criteria-value-${elId}`).val()?.split('-')?.[1]}`)


            if ($(this).val()) {
                $(`#add-criteria-${elId}`).removeClass('d-none')
            } else {
                $(`#add-criteria-${elId}`).addClass('d-none')
            }
        })

        // Watch fields
        $('body').on('blur', '.question, .observation, .browse_document, .field_fact, .findings, .recommendation', function (event) {
            $.ajax({
                url: `<?= base_url('audits/') ?>/${$(this).attr('data-id')}/update-audit-fields`,
                method: 'POST',
                dataType: 'json',
                data: { [$(this).prop('id').split('-')[0]]: $(this).val(), csrf_token_name: $('.txt_csrfname').val() },
                success: function (response) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(response.token);
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>