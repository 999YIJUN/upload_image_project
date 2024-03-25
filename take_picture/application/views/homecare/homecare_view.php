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
            <h1>居家照護</h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">居家照護</li>
                </ol>
            </nav> -->
        </div>
        <div class="row g-3 mb-4">
            <div class="col-sm-3">
                <label class="form-label">照護機構:</label>
                <select name="care_center_select" id="care_center_select" class="form-select">
                    <option value="全部" selected>全部</option>
                    <?php foreach ($home_care as $care_center) : ?>
                        <option value="<?= $care_center->center_name; ?>"><?php echo $care_center->center_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label class="form-label">身分證字號:</label>
                <input type="text" id="personal_ID" class="form-control">
            </div>
            <div class="col-sm-1">
                <input type="text" id="isEnd" class="form-control" value="0" style="visibility: hidden;">
            </div>
            <div class="col-sm-4 d-grid gap-2 d-md-flex justify-content-md-end align-items-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#insertModal"><i class="bi bi-house-add-fill"></i> 新增</button>
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
                                        <th id="col_care_center">照護機構</th>
                                        <th>收案日期</th>
                                        <th id="col_personal_ID">身分證字號</th>
                                        <th>姓名</th>
                                        <th id="col_is_end">結案</th>
                                        <th id="">病歷號</th>
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
    <?php $this->load->view('homecare/housecare_add_modal'); ?>
    <?php $this->load->view('homecare/homecare_end_modal'); ?>
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
                "ajax": {
                    "url": "<?php echo site_url('homecare/get_data_homecare'); ?>",
                },
                "language": {
                    "url": "<?php echo base_url('wwwroot/js/Chinese-traditional.json'); ?>"
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
                        "targets": 4,
                        "visible": false,
                    },
                    {
                        "targets": 5,
                        "visible": false,
                    },
                    {
                        "targets": 6,
                        "responsivePriority": 1,
                    },
                    {
                        "targets": "_all",
                        "className": "text-center" // 添加 text-center 類
                    }
                ]
            });

            // filter
            let homecareVal = $('#care_center_select').val();
            let personalIDtVal = $('#accountFilter').val();
            let isEndVal = $('#isEnd').val();
            if (isEndVal) {
                table.column('#col_is_end').search(isEndVal, true).draw();
            }

            $('#personal_ID').on('change', function() {
                personalIDtVal = $(this).val();
                table.column('#col_personal_ID').search(personalIDtVal).draw();
            })

            $('#care_center_select').on('change', function() {
                homecareVal = $(this).val();
                if (homecareVal == '全部') {
                    table.column('#col_care_center').search('').draw();
                } else {
                    table.column('#col_care_center').search(homecareVal).draw();
                }
            })
            // end filter

            $('#datatable').on('click', '.btnCaseEnd', function() {
                let patient_id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('homecare/get_homecare_data'); ?>',
                    type: 'POST',
                    data: {
                        patient_id: patient_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#e_patient_name').val(response.patient_name);
                        if (response.gender == 'male') {
                            $('#e_gender').val('男');
                        } else {
                            $('#e_gender').val('女');
                        }
                        $('#e_age').val(response.age);
                        $('#e_care_center').val(response.care_center);
                        $('#e_start_date').val(response.start_date);
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $('#datatable').on('click', '.btnTakePicture', function() {
                var recordNumber = $(this).data('record_number');
                $.ajax({
                    url: '<?= site_url('patient/patient_data'); ?>',
                    type: 'POST',
                    data: {
                        recordNumber: recordNumber,
                        source: '居家照護'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "<?= site_url('image/index'); ?>";
                        }
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