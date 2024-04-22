<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="assets/img/favicon.png" rel="icon">
    <?php $this->load->view('common/style'); ?>
    <!-- Template Main CSS File -->
    <link href="<?php echo base_url('wwwroot/css/style.css'); ?>" rel="stylesheet">
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <div href="" class="logo d-flex align-items-center">
                <img src="<?= base_url('wwwroot/small_logo.png') ?>" alt="">
                <span class="d-none d-lg-block">拍照上傳系統</span>
            </div>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <!-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div> -->
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <!-- <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li> -->
                <!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <!-- <img src="" alt="" class="rounded-circle"> -->
                        <i class="fa-solid fa-user-large"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user->username; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $user->username; ?></h6>
                            <span><?= $user->title; ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a id="account_edit" class="dropdown-item d-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#editModal" data-user_id="<?= $user->user_id; ?>">
                                <i class="bi bi-gear"></i>
                                <span>帳號管理</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= site_url('user/signout'); ?>">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>登出</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <?php if ($user->permission == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?= site_url('user/user_view'); ?>">
                        <i class="bi bi-person-vcard"></i>
                        <span>使用者管理</span>
                    </a>
                </li><!-- End  Nav -->
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= site_url('opd/opd_view'); ?>">
                    <i class="fa-solid fa-stethoscope"></i></i><span>門診</span>
                </a>
            </li><!-- End  Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= site_url('inpatient/inpatient_view'); ?>">
                    <i class="fa-solid fa-bed"></i></i><span>住院病房</span>
                </a>
            </li><!-- End  Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= site_url('surgery/surgery_view'); ?>">
                    <i class="bi bi-menu-button-wide"></i><span>開刀房</span>
                </a>
            </li><!-- End  Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= site_url('homecare/homecare_view'); ?>">
                    <i class="fa-solid fa-house-medical"></i></i><span>居家照護</span>
                </a>
            </li><!-- End  Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= site_url('image/image_gallery'); ?>">
                    <i class="fa-regular fa-images"></i></i>
                    <span>圖庫</span>
                </a>
            </li><!-- End Login Page Nav -->
        </ul>
    </aside><!-- End Sidebar-->

    <?php $this->load->view('common/script'); ?>
    <?php $this->load->view('users/user_edit_modal'); ?>
    <!-- <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script> -->
    <script src="<?php echo base_url('wwwroot/js/main.js'); ?>"></script>
    <script>
        $(function() {
            $('#account_edit').on('click', function() {
                let user_id = $(this).data('user_id');
                $.ajax({
                    url: '<?= site_url('user/get_user_data'); ?>',
                    type: 'POST',
                    data: {
                        user_id: user_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#e_username').val(response.username);
                        $('#e_account').val(response.account);
                        $('#e_title').val(response.title);
                        $('#e_permission').val(response.permission);
                        // $('#e_password').val(response.password);
                        console.log(response.user_id);
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        })
    </script>
</body>

</html>