<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
</head>

<body>
    <?php $this->load->view('main'); ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>使用者管理</h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">使用者管理</li>
                </ol>
            </nav> -->
        </div>
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <label class="form-label">職稱:</label>
                <select name="job_title_select" id="job_title_select" class="form-select">
                    <option value="全部">全部</option>
                    <option value="醫師">醫師</option>
                    <option value="護理師">護理師</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label class="form-label">帳號:</label>
                <input type="text" id="accountFilter" class="form-control">
            </div>
            <div class="col-sm-4 d-grid gap-2 d-md-flex justify-content-md-end align-items-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#insertModal"><i class="fa-solid fa-user-plus"></i> 新增</button>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>使用者編號</th>
                                        <th>使用者名稱</th>
                                        <th id="col_account">帳號</th>
                                        <th id="col_job_title">職稱</th>
                                        <th id="col_permission">權限</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php $this->load->view('footer'); ?>
    <?php $this->load->view('users/user_add_modal'); ?>

    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "processing": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "全部"]
                ],
                "order": [
                    [0, "asc"]
                ],
                "searching": true,
                "responsive": true,
                // "info": false,
                "ajax": {
                    "url": "<?php echo site_url('user/get_data_user'); ?>",
                },
                "language": {
                    "url": "<?php echo base_url('wwwroot/js/Chinese-traditional.json'); ?>",
                },
                "responsive": {
                    breakpoints: [{
                            name: 'desktop',
                            width: Infinity
                        },
                        {
                            name: 'tablet-l',
                            width: 1024
                        },
                        {
                            name: 'tablet-p',
                            width: 767
                        },
                        {
                            name: 'mobile-l',
                            width: 480
                        },
                        {
                            name: 'mobile-p',
                            width: 320
                        }
                    ]
                },
                "columnDefs": [{
                        "targets": 0,
                        "visible": false
                    },
                    {
                        "targets": 5,
                        "responsivePriority": 1,
                    },
                    {
                        "targets": "_all",
                        "className": "text-center" // 添加 text-center 類
                    }
                ]
            });

            // filter
            let titleVal = $('#job_title_select').val();
            let accountVal = $('#accountFilter').val();

            // if (accountVal) {
            //     table.column('#col_account').search(accountVal, true).draw();
            // }

            $('#accountFilter').on('change', function() {
                accountVal = $(this).val();
                table.column('#col_account').search(accountVal).draw();

            })

            $('#job_title_select').on('change', function() {
                titleVal = $(this).val();
                if (titleVal == '全部') {
                    table.column('#col_job_title').search('').draw();

                } else {
                    table.column('#col_job_title').search(titleVal).draw();
                }
            })
            // end filter

            $('#datatable').on('click', '.btnDelete', function() {
                var userId = $(this).data('user_id');
                Swal.fire({
                    title: '警告',
                    text: '刪除後資料將消失',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= site_url('user/delete'); ?>',
                            type: 'POST',
                            data: {
                                userId: userId
                            },
                            success: function(response) {
                                console.log('成功:', response);
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.error('錯誤:', error);
                            }
                        });
                    }
                });
            });

            $('#datatable').on('click', '.btnEdit', function() {
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
        });
    </script>
</body>

</html>