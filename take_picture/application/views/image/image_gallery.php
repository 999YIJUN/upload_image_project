<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <style>
        .card_personal {
            display: none;
        }

        .card-text {
            font-size: 18px;
            font-weight: 400;
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
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <label class="form-label">病歷號/身分證字號:</label>
                <input type="text" id="search" name="search" class="form-control" value="">
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php foreach ($record_numbers as $record_number) : ?>
                <div class="col">
                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="card-title text-center"><?= $record_number->patient_name; ?></p>
                            <p class="card-text text-center text-secondary"><?= $record_number->record_number; ?></p>
                            <p class="card_personal"><?= $record_number->personal_id; ?></p>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary btnData" data-record_number="<?= $record_number->record_number; ?>">詳細資訊</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php $this->load->view('footer'); ?>
    <script>
        $(function() {
            $('.btnData').on('click', function() {
                const recordNumber = $(this).data('record_number');
                $.ajax({
                    url: '<?php echo site_url('image/image_data'); ?>',
                    type: 'POST',
                    data: {
                        recordNumber: recordNumber
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "<?= site_url('image/display'); ?>";
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                })
            });

            $('#search').on('input', function() {
                var searchValue = $(this).val().trim(); // this.val.trim();
                var cards = $('.col'); // document.querySelectorAll('.col');
                if (searchValue === '') {
                    // 如果搜索框為空，顯示所有卡片
                    cards.show();
                } else {
                    cards.each(function() {
                        var recordNumberText = $(this).find('.card-text').text();
                        var personalIDText = $(this).find('.card_personal').text();
                        if (recordNumberText === searchValue || personalIDText === searchValue) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });

        })
    </script>
</body>

</html>