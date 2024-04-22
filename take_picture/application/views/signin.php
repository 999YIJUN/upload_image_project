<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php $this->load->view('common/style'); ?>
    <style>
        html,
        body {
            height: 100%;
            background: #f6f9ff;
            color: #444444;
        }

        .footer {
            border-top: 1px solid #cddfff;
            position: fixed;
            bottom: 0;
            width: 100%;
            /* background-color: #333; */
            text-align: center;
            color: #012970;
            padding: 20px 0;
        }
    </style>
</head>

<body class="d-flex flex-column bg-light">
    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"> -->
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-5 d-flex align-items-center pt-3 justify-content-center">
                            <div class="text-center">
                                <img src="<?= base_url('wwwroot/logo.png') ?>" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <div class="text-center mb-3">
                                </div>
                                <h1 class="fs-3 fw-normal text-center text-secondary mb-4">登入</h1>
                                <form action="post" id="loginForm">
                                    <div class="row gy-2 overflow-hidden">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <?= form_input(array(
                                                    'type' => 'text',
                                                    'name' => 'account',
                                                    'id' => 'account',
                                                    'class' => 'form-control',
                                                    'placeholder' => '',
                                                    'required' => 'required'
                                                )) ?>
                                                <?= form_label('帳號', 'account', array('class' => 'form-label')); ?>
                                            </div>
                                            <div id="accountError" class="text-danger"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <?= form_password(array(
                                                    'name' => 'password',
                                                    'id' => 'password',
                                                    'class' => 'form-control',
                                                    'value' => '',
                                                    'placeholder' => '',
                                                    'required' => 'required'
                                                )) ?>
                                                <?= form_label('密碼', 'password', array('class' => 'form-label')); ?>
                                            </div>
                                            <div id="passwordError" class="text-danger"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid my-3">
                                                <?= form_submit(array(
                                                    'name' => 'btnSignIn',
                                                    'id' => 'btnSignIn',
                                                    'class' => 'btn btn-primary btn-lg',
                                                    'value' => '登入'
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; Copyright <strong><span>衛生福利部豐原醫院</span></strong>. All Rights Reserved
                </div>
            </div>
        </div>
    </footer>

    <?php $this->load->view('common/script'); ?>
    <script>
        $(function() {
            $("#btnSignIn").click(function(event) {
                event.preventDefault();
                // var id = $(this).data("id");
                const postData = $('form').serialize();
                axios.post("<?= site_url('user/signin'); ?>", postData)
                    .then(function(response) {
                        const get_data = response.data;
                        // console.log(get_data);
                        if (get_data.success) {
                            const permission = get_data.permission;
                            if (permission == 'admin') {
                                window.location.href = '<?php echo site_url("user/user_view"); ?>';
                            } else {
                                window.location.href = '<?php echo site_url("opd/opd_view"); ?>';
                            }
                        } else {
                            $('#accountError').html('');
                            $('#passwordError').html('');
                            $('#accountError').html(get_data.errors.account);
                            $('#passwordError').html(get_data.errors.password);
                        }
                    })
                    .catch(function(error) {
                        console.error('錯誤:', error);
                    });
            });
        });
    </script>
</body>

</html>