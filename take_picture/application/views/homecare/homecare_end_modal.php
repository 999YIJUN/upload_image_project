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
    <div class="modal fade" id="caseEndModal" tabindex="-1" aria-labelledby="case_end_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="case_end_modal">修改</h5>
                        <button type="button" class="btn-close" id="e_btnClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="s_patient_name">姓名</span>
                                    <input type="text" id="e_patient_name" name="e_patient_name" class="form-control" aria-describedby="s_patient_name" disabled readonly>
                                    <div id="patientIDError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="s_gender">性別</span>
                                    <input type="text" id="e_gender" name="e_gender" class="form-control" aria-describedby="s_gender" disabled readonly>
                                    <div id="genderError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="s_age">年齡</span>
                                    <input type="text" id="e_age" name="e_age" class="form-control" aria-describedby="s_age" disabled readonly>
                                    <div id="ageError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="s_care_center">照護機構</span>
                                    <input type="text" id="e_care_center" name="e_care_center" class="form-control" aria-describedby="s_care_center" disabled readonly>
                                    <div id="careCenterError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="s_start_date">收案日</span>
                                    <input type="text" id="e_start_date" name="e_start_date" class="form-control" aria-describedby="s_start_date" disabled readonly>
                                    <div id="startDateError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="s_end_date">結案日</span>
                                    <input type="text" id="e_end_date" name="e_end_date" class="form-control" aria-describedby="s_end_date">
                                    <div id="endDateError" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="e_btnExit" data-bs-dismiss="modal">關閉</button>
                        <button type="submit" class="btn btn-primary" id="e_btnSave">儲存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#e_btnSave').click(function(e) {
                e.preventDefault();
                const formData = $('form').serialize();
                axios.post("<?= site_url('homecare/edit'); ?>", formData)
                    .then(function(response) {
                        const get_data = response.data;
                        if (get_data.success) {
                            $('#e_btnExit').click();

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
                            // $('#usernameError').html(response.data.errors.username);
                        }
                    })
                    .catch(function(error) {
                        console.error('錯誤', error);
                    });
            });

            let datepicker = flatpickr("#e_end_date", {
                dateFormat: "Y-m-d", // 日期格式 Y-m-d H:i
                mode: "single", // multiple, range
                locale: "zh_tw",
            });

            // $('#date_clear').on('click', function() {
            //     datepicker.clear();
            // });

            $('#e_btnExit, #e_btnClose').click(function(e) {
                init();
            });

            function init() {
                $('#e_end_date').val('');
            }
        })
    </script>
</body>

</html>