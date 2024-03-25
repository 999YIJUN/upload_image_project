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
            <h1>住院病房</h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">住院病房</li>
                </ol>
            </nav> -->
        </div>
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <label class="form-label">醫師</label>
                <input type="text" id="doctor" class="form-control" value="<?php if ($user->title === '醫師') : ?><?= $user->username; ?><?php endif; ?>">
            </div>
            <div class="col-sm-4">
                <label class="form-label">床號</label>
                <input type="text" id="bed_no" class="form-control">
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
                                        <th id="col_bed_no">床號</th>
                                        <th id="col_record_no">病歷號</th>
                                        <th>姓名</th>
                                        <th id="col_doctor">主治醫師</th>
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
                    "url": "<?php echo site_url('inpatient/get_data_inpatient'); ?>",
                },
                "language": {
                    "url": "<?php echo base_url('wwwroot/js/Chinese-traditional.json'); ?>"
                },
                "columnDefs": [{
                    "targets": 4,
                    "responsivePriority": 1,
                }, {
                    "targets": "_all",
                    "className": "text-center" // 添加 text-center 類
                }]
            });

            // filter
            let doctorVal = $('#doctor').val();
            let bedVal = $('#bed_no').val();
            let recordVal = $('#record_no').val();

            // if (bedVal) {
            //     table.column('#col_bed_no').search(bedVal, true).draw();
            if (doctorVal) {
                table.column('#col_doctor').search(doctorVal).draw();
            }
            // }

            $('#bed_no').on('change', function() {
                bedVal = $(this).val();
                table.column('#col_bed_no').search(bedVal, true).draw();

            })

            $('#doctor').on('change', function() {
                doctorVal = $(this).val();
                table.column('#col_doctor').search(doctorVal).draw();

            })

            $('#record_no').on('change', function() {
                recordVal = $(this).val();
                table.column('#col_record_no').search(recordVal).draw();

            })
            // end filter

            $('#datatable').on('click', '.btnTakePicture', function() {
                var recordNumber = $(this).data('record_number');
                $.ajax({
                    url: '<?= site_url('patient/patient_data'); ?>',
                    type: 'POST',
                    data: {
                        recordNumber: recordNumber,
                        source: '住院病房'
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