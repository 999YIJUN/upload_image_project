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
                        <h5 class="modal-title" id="insert_modal">新增使用者</h5>
                        <button type="button" class="btn-close" id="btnClose_Insert" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <?= form_label('姓名', 'username', ['class' => 'form-label']); ?>
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="">
                                    <div id="usernameErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('帳號', 'account', ['class' => 'form-label']); ?>
                                    <input type="text" name="account" id="account" class="form-control form-control-lg" placeholder="">
                                    <div id="accountErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('職稱', 'title', ['class' => 'form-label']);
                                    ?>
                                    <select name="title" id="title" class="form-select form-select-lg">
                                        <option value="" disabled selected hidden></option>
                                        <option value="醫師">醫師</option>
                                        <option value="護理師">護理師</option>
                                    </select>
                                    <div id="titleErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('密碼', 'password', array('class' => 'form-label')); ?>
                                    <?= form_password(array(
                                        'name' => 'password',
                                        'id' => 'password',
                                        'class' => 'form-control form-control-lg',
                                        'value' => '',
                                        'placeholder' => '',
                                        'required' => 'required'
                                    )); ?>
                                    <div id="passwordErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <?= form_label('密碼確認', 'password_confirm', array('class' => 'form-label')); ?>
                                    <?= form_password(array(
                                        'name' => 'password_confirm',
                                        'id' => 'password_confirm',
                                        'class' => 'form-control form-control-lg',
                                        'value' => '',
                                        'placeholder' => '',
                                        'required' => 'required'
                                    )); ?>
                                    <div id="passwordConfirmErrorInsert" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnExit_Insert" data-bs-dismiss="modal">關閉</button>
                        <button type="submit" class="btn btn-primary" id="BtnSave_Insert">儲存</button>
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
                axios.post("<?= site_url('user/insert'); ?>", postData)
                    .then(function(response) {
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
                            $('#usernameErrorInsert').html(response.data.errors.username);
                            $('#accountErrorInsert').html(response.data.errors.account);
                            $('#titleErrorInsert').html(response.data.errors.title);
                            $('#passwordErrorInsert').html(response.data.errors.password);
                            $('#passwordConfirmErrorInsert').html(response.data.errors.password_confirm);
                        }
                    })
                    .catch(function(error) {
                        console.error('錯誤', error);
                    });
            });

            $('#btnExit_Insert, #btnClose_Insert').click(function(e) {
                init();
            });

            function init() {
                $('#username, #account, #password, #password_confirm').val('');
                $('#title option[value=""]').prop('selected', true);
                $('#usernameErrorInsert, #accountErrorInsert, #titleErrorInsert, #passwordErrorInsert, #passwordConfirmErrorInsert').html('');
            }
        })
    </script>
</body>

</html>