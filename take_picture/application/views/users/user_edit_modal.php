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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit_modal">修改</h5>
                        <button type="button" class="btn-close" id="btnClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('姓名', 'e_username', ['class' => 'form-label']); ?>
                                    <input type="text" name="e_username" id="e_username" class="form-control form-control-lg" disabled readonly>
                                    <div id="usernameError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('帳號', 'e_account', ['class' => 'form-label']); ?>
                                    <input type="text" name="e_account" id="e_account" class="form-control form-control-lg" disabled readonly>
                                    <div id="accountError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('職稱', 'e_title', ['class' => 'form-label']);
                                    ?>
                                    <select name="e_title" id="e_title" class="form-select form-select-lg" disabled>
                                        <option value="" disabled selected hidden></option>
                                        <option value="醫師">醫師</option>
                                        <option value="護理師">護理師</option>
                                    </select>
                                    <div id="titleError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('權限', 'e_permission', ['class' => 'form-label']);
                                    ?>
                                    <select name="e_permission" id="e_permission" class="form-select form-select-lg" <?php echo ($user->permission != 'admin') ? 'disabled' : ''; ?>>
                                        <option value="" disabled selected hidden></option>
                                        <option value="general">一般使用者</option>
                                        <option value="advance">進階使用者</option>
                                        <option value="admin">系統管理員</option>
                                    </select>
                                    <div id="permissionError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('密碼', 'e_password', array('class' => 'form-label')); ?>
                                    <?= form_password(array(
                                        'name' => 'e_password',
                                        'id' => 'e_password',
                                        'class' => 'form-control form-control-lg',
                                        'value' => '',
                                        'placeholder' => '',
                                        'required' => 'required'
                                    )); ?>
                                    <div id="passwordError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('密碼確認', 'e_password_confirm', array('class' => 'form-label')); ?>
                                    <?= form_password(array(
                                        'name' => 'e_password_confirm',
                                        'id' => 'e_password_confirm',
                                        'class' => 'form-control form-control-lg',
                                        'value' => '',
                                        'placeholder' => '',
                                        'required' => 'required'
                                    )); ?>
                                    <div id="passwordConfirmError" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnExit" data-bs-dismiss="modal">關閉</button>
                        <button type="submit" class="btn btn-primary" id="BtnSave">儲存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#BtnSave').click(function(e) {
                e.preventDefault();
                const formData = $('form').serialize();
                axios.post("<?= site_url('user/edit'); ?>", formData)
                    .then(function(response) {
                        const get_data = response.data;
                        if (get_data.success) {
                            $('#btnExit').click();

                            // 使用 setTimeout 延遲顯示 alert
                            setTimeout(function() {
                                Swal.fire({
                                    title: "成功!",
                                    text: "已完成修改!",
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
                            // $('#accountError').html(response.data.errors.account);
                            // $('#titleError').html(response.data.errors.title);
                            $('#passwordError').html(response.data.errors.password);
                            $('#passwordConfirmError').html(response.data.errors.password_confirm);
                        }
                    })
                    .catch(function(error) {
                        console.error('錯誤', error);
                    });
            });

            $('#btnExit, #btnClose').click(function(e) {
                init();
            });

            function init() {
                $('#usernameError, #accountError, #titleError, #passwordError, #passwordConfirmError').html('');
            }
        })
    </script>
</body>

</html>