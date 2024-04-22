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

        #date_clear:hover {
            cursor: pointer;
            background-color: #e9ecef;
            border-color: #ced4da;
        }
    </style>
</head>

<body>
    <?php $this->load->view('main'); ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>門診</h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">門診</li>
                </ol>
            </nav> -->
        </div>
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <label class="form-label">門診日期:</label>
                <div class="input-group">
                    <input type="text" id="date" class="form-control" value="<?= $today; ?>">
                    <span class="input-group-text" id="date_clear" data-toggle="tooltip"><i class="bi bi-x-lg" style="color: #f64747;"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-label">午別:</label>
                <select name="category_select" id="category_select" class="form-select">
                    <option value="all">全日</option>
                    <option value="morning">上午</option>
                    <option value="afternoon">下午</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label class="form-label">科別:</label>
                <select name="department_select" id="department_select" class="form-select">
                    <option value="all">全部</option>
                    <?php foreach ($department as $d) : ?>
                        <option value="<?= $d->department ?>"><?= $d->department ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label class="form-label">醫師</label>
                <input type="text" id="doctor" class="form-control" value="<?php if ($user->title === '醫師') : ?><?= $user->username; ?><?php endif; ?>">
            </div>
            <div class="col-sm-4">
                <label class="form-label">病歷號</label>
                <input type="text" id="record_no" class="form-control">
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
                                        <th id="col_doctor">醫生</th>
                                        <th id="col_record_no">病歷號</th>
                                        <th>姓名</th>
                                        <th id="col_date">日期</th>
                                        <th id="col_category">午別</th>
                                        <th id="col_department">科別</th>
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
    <script>
        $(function() {
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
                    "url": "<?php echo site_url('opd/get_data_opd'); ?>",
                },
                "language": {
                    "url": "<?php echo base_url('wwwroot/js/Chinese-traditional.json'); ?>"
                },
                "columnDefs": [{
                        "targets": [3, 4],
                        "visible": false
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

            let datepicker = flatpickr("#date", {
                dateFormat: "Y-m-d", // 日期格式 Y-m-d H:i
                mode: "single", // multiple, range
                locale: "zh_tw",
                // minDate: "2024-01-01",
                // maxDate: "2024-12-31", 
                // inline: true
            });

            $('#date_clear').on('click', function() {
                datepicker.clear();
            });

            // filter
            let doctorVal = $('#doctor').val();
            let dateVal = $('#date').val();
            let recordVal = $('#record_no').val();
            let categoryVal = $(`select[name='category_select']`).val();
            let departmentVal = $(`select[name='department_select']`).val();

            if (dateVal && categoryVal != 'all') {
                table.column('#col_date').search(dateVal, true).draw();
                table.column('#col_category').search(categoryVal).draw();
                if (doctorVal) {
                    table.column('#col_doctor').search(doctorVal).draw();
                }
                if (departmentVal != 'all') {
                    table.column('#col_department').search(departmentVal).draw();
                }
            } else if (dateVal && categoryVal == 'all' && departmentVal == 'all') {
                table.column('#col_date').search(dateVal, true).draw();
                table.column('#col_doctor').search(doctorVal).draw();
            }

            $('#date').on('change', function() {
                dateVal = $(this).val();
                table.column('#col_date').search(dateVal, true).draw();
            })

            $('#doctor').on('change', function() {
                doctorVal = $(this).val();
                table.column('#col_doctor').search(doctorVal).draw();

            })

            $('#record_no').on('change', function() {
                recordVal = $(this).val();
                table.column('#col_record_no').search(recordVal).draw();

            })

            $('#category_select').on('change', function() {
                categoryVal = $(this).val();
                // table.column('#col_category').search(categoryVal).draw();
                if (categoryVal == 'all') {
                    table.column('#col_category').search('').draw();

                } else {
                    table.column('#col_category').search(categoryVal).draw();
                }
            })

            $('#department_select').on('change', function() {
                departmentVal = $(this).val();
                console.log(departmentVal);
                // table.column('#col_category').search(categoryVal).draw();
                if (departmentVal == 'all') {
                    table.column('#col_department').search('').draw();

                } else {
                    table.column('#col_department').search(departmentVal).draw();
                }
            })
            // end filter

            $('#datatable').on('click', '.btnTakePicture', function() {
                var recordNumber = $(this).data('record_number');
                $.ajax({
                    url: '<?= site_url('patient/patient_data'); ?>',
                    type: 'POST',
                    data: {
                        recordNumber: recordNumber,
                        source: '門診'
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