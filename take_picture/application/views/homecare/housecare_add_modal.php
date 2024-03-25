<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .form-floating>.form-select {
            padding-top: 0;
            padding-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insert_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="insert_modal">新增個案</h5>
                        <button type="button" class="btn-close" id="btnClose_Insert" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('身分證字號', 'personal_id', ['class' => 'form-label']); ?>
                                    <input type="text" name="personal_id" id="personal_id" class="form-control form-control-lg" placeholder="">
                                    <div id="personalIDErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('病歷號', 'record_number', ['class' => 'form-label']); ?>
                                    <input type="text" name="record_number" id="record_number" class="form-control form-control-lg" placeholder="">
                                    <div id="recordNumberErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('姓名', 'patient_name', ['class' => 'form-label']); ?>
                                    <input type="text" name="patient_name" id="patient_name" class="form-control form-control-lg" disabled>
                                    <div id="patientNameErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('生日', 'birthday', ['class' => 'form-label']); ?>
                                    <input type="text" name="birthday" id="birthday" class="form-control form-control-lg" disabled readonly>
                                    <div id="birthdayErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('性別', 'gender', ['class' => 'form-label']);
                                    ?>
                                    <!-- <select name="gender" id="gender" class="form-select form-select-lg">
                                        <option value="" disabled selected hidden></option>
                                    </select> -->
                                    <input type="text" name="gender" id="gender" class="form-control form-control-lg" disabled readonly>
                                    <div id="genderErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('收案日', 'start_date', array('class' => 'form-label')); ?>
                                    <input type="text" id="start_date" name="start_date" class="form-control form-control-lg">
                                    <div id="startDateErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <?= form_label('照護機構', 'care_center', ['class' => 'form-label']);
                                    ?>
                                    <select name="care_center" id="care_center" class="form-select form-select-lg">
                                        <option value="" disabled selected hidden></option>
                                        <?php foreach ($home_care as $care_center) : ?>
                                            <option value="<?= $care_center->center_name; ?>"><?php echo $care_center->center_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="careCenterErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="alert alert-danger d-none" id="message">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="BtnSave_Insert" disabled>儲存</button>
                        <button type="button" class="btn btn-success" id="btnReset">重新輸入</button>
                        <button type="button" class="btn btn-danger" id="btnExit_Insert" data-bs-dismiss="modal">關閉</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#BtnSave_Insert').click(function(e) {
                e.preventDefault();
                const postData = $('form').serialize();
                axios.post("<?= site_url('homecare/insert'); ?>", postData)
                    .then(response => {
                        const get_data = response.data;
                        if (get_data.success) {
                            $('#btnExit_Insert').click();

                            // 使用 setTimeout 延遲顯示 alert
                            setTimeout(function() {
                                Swal.fire({
                                    title: "成功!",
                                    text: "已完成新增!",
                                    icon: "success",
                                    confirmButtonText: '確定',
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }, 100);

                            console.log('成功:', response.data);
                        } else {
                            // $('#personalIDErrorInsert').html(get_data.errors.personal_id);
                            // $('#recordNumberErrorInsert').html(get_data.errors.record_number);
                            // $('#patientNameErrorInsert').html(get_data.errors.patient_name);
                            // $('#birthdayErrorInsert').html(get_data.errors.birthday);
                            // $('#genderErrorInsert').html(get_data.errors.gender);
                            $('#startDateErrorInsert').html(get_data.errors.start_date);
                            $('#careCenterErrorInsert').html(get_data.errors.care_center);
                        }
                    })
                    .catch(error => {
                        console.error('錯誤', error);
                    });
            });

            $('#personal_id, #record_number').on('change', function() {
                var personalId = $('#personal_id').val();
                var recordNumber = $('#record_number').val();
                if (personalId || recordNumber) {
                    $('#personal_id, #record_number').prop('disabled', true);
                    $.ajax({
                        url: '<?= site_url('homecare/get_patient_data'); ?>',
                        type: 'POST',
                        data: {
                            personalId: personalId,
                            recordNumber: recordNumber
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                const patientData = response.patientData;
                                if (personalId) {
                                    $('#record_number').val(patientData.record_number);
                                }
                                if (recordNumber) {
                                    $('#personal_id').val(patientData.personal_id);
                                }
                                $('#patient_name').val(patientData.patient_name);
                                $('#birthday').val(patientData.birthday);
                                if (patientData.gender == 'male') {
                                    $('#gender').val('男');
                                } else if (patientData.gender == 'female') {
                                    $('#gender').val('女');
                                }
                                $('#BtnSave_Insert').prop('disabled', false);
                            } else {
                                errors(response);

                                function errors(data) {
                                    errorMessage('#message', data.message);
                                }
                                // 處理個別錯誤消息
                                function errorMessage(selector, errorData) {
                                    const errorElement = $(selector);
                                    if (errorData !== '') {
                                        const errorMessageText = $('<div/>').html(errorData).text();
                                        errorElement.text(errorMessageText);
                                        errorElement.toggleClass('d-none', false);
                                    } else {
                                        errorElement.empty().toggleClass('d-none', true);
                                    }
                                }
                                $('#BtnSave_Insert').prop('disabled', true);
                            }

                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

            let datepicker = flatpickr("#start_date", {
                dateFormat: "Y-m-d", // 日期格式 Y-m-d H:i
                mode: "single", // multiple, range
                locale: "zh_tw",
            });

            // $('#date_clear').on('click', function() {
            //     datepicker.clear();
            // });

            $('#btnReset').on('click', function() {
                init();
            });

            $('#btnExit_Insert, #btnClose_Insert').click(function(e) {
                init();
                $('#personalIDErrorInsert, #recordNumberErrorInsert, #patientNameErrorInsert, #birthdayErrorInsert, #genderErrorInsert, #startDateErrorInsert, #careCenterErrorInsert').html('');

            });

            function init() {
                $('#personal_id, #record_number, #patient_name, #birthday, #start_date, #gender').val('');
                $('#care_center option[value=""]').prop('selected', true);
                $('#personal_id, #record_number, #BtnSave_Insert').prop('disabled', false);
                $('#message').empty().toggleClass('d-none', true);
                $('#BtnSave_Insert').prop('disabled', true);
            }
        })
    </script>
</body>

</html>