<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Image</title>
    <style>
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
            <h1>圖庫</h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">圖庫</li>
                </ol>
            </nav> -->
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">病歷號</span>
                    <input type="text" id="record_number" name="record_number" class="form-control" value="<?= $patient_data->record_number; ?>" disabled readonly>
                    <div id="recordNumberError" class="text-danger"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">姓名</span>
                    <input type="text" id="patient_name" name="patient_name" class="form-control" value="<?= $patient_data->patient_name; ?>" disabled readonly>
                    <div id="patientNameError" class="text-danger"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">性別</span>
                    <input type="text" id="gender" name="gender" class="form-control" <?php if ($patient_data->gender == 'male') : ?> value="男" <?php else : ?>value="女" <?php endif; ?> disabled readonly>
                    <div id="genderError" class="text-danger"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">年齡</span>
                    <input type="text" id="age" name="age" class="form-control" value="<?= $patient_data->age; ?>" disabled readonly>
                    <div id="ageError" class="text-danger"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?php echo site_url('image/image_gallery') ?>" class="btn btn-primary"><i class="bi bi-arrow-90deg-left"></i> 返回</a>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <label class="form-label">上傳日期:</label>
                <div class="input-group">
                    <input type="text" id="date" class="form-control">
                    <span class="input-group-text" id="date_clear" data-toggle="tooltip"><i class="bi bi-x-lg" style="color: #f64747;"></i></span>
                </div>
            </div>
            <div class="col-sm-4">
                <label class="form-label">來源:</label>
                <select name="care_center_select" id="care_center_select" class="form-select">
                    <option value="全部" selected>全部</option>
                    <option value="門診">門診</option>
                    <option value="住院病房">住院病房</option>
                    <option value="開刀房">開刀房</option>
                    <option value="居家照護">居家照護</option>
                </select>
            </div>
            <!-- <div class="col-sm-4">
                <label class="form-label">類別:</label>
                <input type="text" id="record_no" class="form-control">
            </div> -->
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($image_data)) : ?>
                <?php foreach ($image_data as $image) : ?>
                    <div class="col">
                        <div class="card mb-2">
                            <div class="card-body">
                                <img src="<?php echo $image['path']; ?>" alt="<?php echo $image['name']; ?>" class="img-fluid image_manage" data-source="<?php echo $image['source']; ?>" data-date="<?php echo $image['date']; ?>">
                            </div>
                        </div>
                        <button class="btn btn-danger image_delete" data-image_name="<?= $image['name']; ?>">刪除</button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No images available</p>
            <?php endif; ?>
        </div>
    </main>
    <?php $this->load->view('footer'); ?>
    <script>
        $(function() {
            $('.image_delete').on('click', function() {
                const image_name = $(this).data('image_name');
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
                            url: '<?= site_url('image/delete_image'); ?>',
                            type: 'POST',
                            data: {
                                image_name: image_name
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log('成功:', response);
                                $('.image_delete[data-image_name="' + image_name + '"]').closest('.col').remove();
                            },
                            error: function(xhr, status, error) {
                                console.error('錯誤:', error);
                            }
                        });
                    }
                });
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
            let source = $('#care_center_select').val();
            let date = $('#date').val();
            var cards = $('.col');
            $('#care_center_select').on('change', function() {
                // let source = $('#care_center_select').val();
                source = $('#care_center_select').val();
                console.log(source);
                console.log(date);
                console.log(cards.length);
                console.log((source == '全部' && date == '') ? true : false);
                if (source == '全部' && date == '') {
                    cards.show();
                } else if (source !== '全部' && date == '') {
                    filter_match_source();
                } else if (source == '全部' && date != '') {
                    filter_match_date();
                } else {
                    filter_match_all();
                }
            });


            $('#date').on('change', function() {
                // let date = $('#date').val();
                date = $('#date').val();
                console.log(date);
                console.log(source);
                console.log(cards.length);
                console.log((source == '全部' && date == '') ? true : false);
                if (source == '全部' && date == '') {
                    cards.show();
                } else if (source == '全部' && date != '') {
                    filter_match_date();
                } else if (source !== '全部' && date == '') {
                    filter_match_source();
                } else {
                    filter_match_all();
                }
            });

            function filter_match_all() {
                cards.each(function() {
                    let source_filter = $(this).find('.image_manage').data('source');
                    let date_filter = $(this).find('.image_manage').data('date');
                    // console.log(
                    //     (source_filter === source) ? true : false);
                    if (source_filter === source && date_filter === date) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                })
            }

            function filter_match_source() {
                cards.each(function() {
                    let source_filter = $(this).find('.image_manage').data('source');
                    if (source_filter === source) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            function filter_match_date() {
                cards.each(function() {
                    let date_filter = $(this).find('.image_manage').data('date');
                    if (date_filter === date) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    </script>
</body>

</html>