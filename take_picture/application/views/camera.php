<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <?php $this->load->view('common/style'); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .camera-controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 400px;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 25px;
            padding: 15px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .material-icons {
            font-size: 40px;
            color: white;
            background-color: black;
            border-radius: 50%;
            padding: 20px;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        .material-icons:hover {
            background-color: #333;
        }

        .webcam-container {
            height: 100vh;
            /* 讓容器佔滿整個螢幕高度 */
        }
    </style>
</head>

<body>
    <main>
        <div class="form-control webcam-start" id="webcam-control">
            <!-- <label class="form-switch"> -->
            <!-- <input type="checkbox" id="webcam-switch">
                <i></i> -->

            <div class="container">
                <span class="badge bg-success" id="webcam-caption">鏡頭關閉中</span>
                <span class="badge bg-warning" id=""><?= $source; ?></span>
                <?php if (!empty($patient_data)) : ?>
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
                            <button id="cameraFlip" class="btn btn-primary me-md-2"><i class="fa-solid fa-camera-rotate"></i></button>
                            <a id="returnPage" class="btn btn-primary" <?php switch ($source) {
                                                                            case '門診':
                                                                                echo 'href="' . site_url('opd/opd_view') . '"';
                                                                                break;
                                                                            case '住院病房':
                                                                                echo 'href="' . site_url('inpatient/inpatient_view') . '"';
                                                                                break;
                                                                            case '開刀房':
                                                                                echo 'href="' . site_url('surgery/surgery_view') . '"';
                                                                                break;
                                                                            case '居家照護':
                                                                                echo 'href="' . site_url('homecare/homecare_view') . '"';
                                                                                break;
                                                                            default:
                                                                                break;
                                                                        } ?>><i class="fa-solid fa-rotate-right"></i> 重新選擇</a>
                        </div>
                    </div>
                <?php else : ?>
                    <p>沒有可用的患者資訊。</p>
                <?php endif; ?>
            </div>
            <!-- </label> -->
        </div>

        <div id="webcam-container" class="webcam-container col-12 d-flex justify-content-center align-items-start p-0 m-0">
            <div class="embed-responsive embed-responsive-16by9">
                <video id="webcam" class="embed-responsive-item" autoplay playsinline style="max-width: 100%; height: auto;"></video>
            </div>
            <canvas id="canvas" class="d-none"></canvas>
            <div class="flash"></div>
            <audio id="snapSound" src="<?php echo base_url('audio/snap.wav'); ?>" preload="auto"></audio>
        </div>

        <div id="cameraControls" class="camera-controls d-flex justify-content-center align-items-center fixed-bottom">
            <a id="exit-app" title="Exit App" class="btn-lg mr-2 d-none" <?php switch ($source) {
                                                                                case '門診':
                                                                                    echo 'href="' . site_url('opd/opd_view') . '"';
                                                                                    break;
                                                                                case '住院病房':
                                                                                    echo 'href="' . site_url('inpatient/inpatient_view') . '"';
                                                                                    break;
                                                                                case '開刀房':
                                                                                    echo 'href="' . site_url('surgery/surgery_view') . '"';
                                                                                    break;
                                                                                case '居家照護':
                                                                                    echo 'href="' . site_url('homecare/homecare_view') . '"';
                                                                                    break;
                                                                                default:
                                                                                    break;
                                                                            } ?>><i class="material-icons">exit_to_app</i></a>
            <a id="take-photo" title="Take Photo" class="btn-lg mr-2"><i class="material-icons">camera_alt</i></a>
            <a id="download-photo" title="Save Photo" class="btn-lg mr-2 d-none"><i class="material-icons">file_download</i></a>
            <a id="resume-camera" title="Resume Camera" class="btn-lg d-none"><i class="material-icons">camera_front</i></a>
        </div>
    </main>
    <?php $this->load->view('common/script'); ?>
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
    <script>
        const webcamElement = document.getElementById('webcam');
        const canvasElement = document.getElementById('canvas');
        const snapSoundElement = document.getElementById('snapSound');
        const webcam = new Webcam(webcamElement, 'user', canvasElement, snapSoundElement);
        let hideElement = true;
        $(function() {
            webcam.start()
                .then(result => {
                    cameraStarted();
                    //console.log("webcam started");
                })
                .catch(err => {
                    displayError();
                });
        });

        $('#returnPage').on('click', function() {
            cameraStopped();
            webcam.stop();
        });
        // $("#webcam-switch").change(function() {
        //     if (this.checked) { // 如果相機啟動，則顯示模態視窗(md - modal)，並開始攝像頭。
        //         $('.md-modal').addClass('md-show');
        //         webcam.start()
        //             .then(result => {
        //                 cameraStarted();
        //                 //console.log("webcam started");
        //             })
        //             .catch(err => {
        //                 displayError();
        //             });
        //     } else { // 如果相機關閉，則停止攝像頭。
        //         cameraStopped();
        //         webcam.stop();
        //         //console.log("webcam stopped");
        //     }
        // });

        $('#cameraFlip').click(function() {
            webcam.flip();
            webcam.start();
        });

        function cameraStarted() {
            // 隱藏錯誤訊息框
            $("#errorMsg").addClass("d-none");
            // 隱藏閃光效果
            $('.flash').hide();
            // 更改攝像頭狀態標籤
            $("#webcam-caption").html("鏡頭啟用中");
            // 移除攝像頭關閉狀態類，添加攝像頭開啟狀態類
            $("#webcam-control").removeClass("webcam-off");
            $("#webcam-control").addClass("webcam-on");
            // 顯示攝像頭容器
            $(".webcam-container").removeClass("d-none");
            // 如果檢測到多於一個攝像頭，顯示攝像頭翻轉按鈕
            if (webcam.webcamList.length > 1) {
                $("#cameraFlip").removeClass('d-none');
            }
            // 如果設置為隱藏特定元素，則隱藏這些元素
            if (hideElement) {
                $("#wpfront-scroll-top-container").addClass("d-none");
                $(".sd-sharing-enabled").addClass("d-none d-lg-block");
                $(".floatingchat-container-wrap-mobi").addClass("d-none");
            }
            // 將頁面滾動至頂部
            window.scrollTo(0, 0);
            // 鎖定頁面垂直滾動
            $('body').css('overflow-y', 'hidden');
        }

        function cameraStopped() {
            // 隱藏錯誤訊息框
            $("#errorMsg").addClass("d-none");
            // 移除攝像頭開啟狀態類，添加攝像頭關閉狀態類
            $("#webcam-control").removeClass("webcam-on");
            $("#webcam-control").addClass("webcam-off");
            // 隱藏攝像頭翻轉按鈕
            $("#cameraFlip").addClass('d-none');
            // 隱藏攝像頭容器
            $(".webcam-container").addClass("d-none");
            // 更改攝像頭狀態標籤
            $("#webcam-caption").html("鏡頭關閉中");
            // 移除模態視窗的顯示類
            $('.md-modal').removeClass('md-show');
            // 如果設置為隱藏特定元素，則顯示這些元素
            if (hideElement) {
                $("#wpfront-scroll-top-container").removeClass("d-none");
                $(".sd-sharing-enabled").removeClass("d-none d-lg-block");
                $(".floatingchat-container-wrap-mobi").removeClass("d-none");
            }
        }
        let picture;
        let filename;
        $("#take-photo").click(function() {
            beforeTakePhoto(); // 在拍照之前，執行一些準備工作。
            picture = webcam.snap(); // 拍照並顯示結果。
            let currentDate = new Date();
            let year = currentDate.getFullYear();
            let month = String(currentDate.getMonth() + 1).padStart(2, '0');
            let day = String(currentDate.getDate()).padStart(2, '0');

            // 生成隨機數字
            let randomCode = Math.floor(Math.random() * 10000); // 可以根據需求調整隨機碼的範圍

            // 組合檔案名稱
            fileName = `img_${year}${month}${day}_${randomCode}`;

            console.log(fileName);
            // 設定下載連結的 href 屬性為照片的資料URL
            // document.querySelector('#download-photo').href = picture;

            // // // 設定下載連結的 download 屬性為檔案名稱
            // document.querySelector('#download-photo').setAttribute('download', fileName);
            afterTakePhoto(); // 在拍照之後，執行一些後處理工作。
        });

        $("#download-photo").click(function() {
            // let fileName = this.getAttribute('download');
            console.log(fileName);
            console.log(picture);
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Image/upload') ?>",
                data: {
                    picture: picture,
                    fileName: fileName,
                },
                success: function(response) {
                    Swal.fire({
                        title: "成功!",
                        text: "已完成照片上傳!",
                        icon: "success",
                        confirmButtonText: '確定',
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        webcam.stream()
                            .then(facingMode => {
                                removeCapture();
                            });
                    });

                    console.log("檔案名稱已存入資料庫！");
                },
                error: function(xhr, status, error) {
                    console.error("存入資料庫時發生錯誤：", error);
                }
            });
        });

        $("#resume-camera").click(function() {
            webcam.stream()
                .then(facingMode => {
                    removeCapture();
                });
        });

        function beforeTakePhoto() {
            $('.flash')
                .show()
                .animate({
                    opacity: 0.3
                }, 500)
                .fadeOut(500)
                .css({
                    'opacity': 0.7
                });
            window.scrollTo(0, 0);
            // $('#webcam-control').addClass('d-none');
            $('#cameraControls').addClass('d-none');
        }

        function afterTakePhoto() {
            // 停止攝像頭
            webcam.stop();
            // 顯示照片容器
            $('#canvas').removeClass('d-none');
            $('#webcam').addClass('d-none');
            $("#cameraFlip").addClass('d-none');
            // 隱藏拍照按鈕
            $('#take-photo').addClass('d-none');
            // 顯示退出應用程序、下載照片、恢復攝像頭按鈕
            $('#exit-app').removeClass('d-none');
            $('#download-photo').removeClass('d-none');
            $('#resume-camera').removeClass('d-none');
            // 顯示攝像頭控制
            $('#cameraControls').removeClass('d-none');
        }

        function removeCapture() {
            // 隱藏照片容器
            $('#canvas').addClass('d-none');
            $('#webcam').removeClass('d-none');
            $("#cameraFlip").removeClass('d-none');
            // 顯示攝像頭控制和拍照控制
            $('#webcam-control').removeClass('d-none');
            $('#cameraControls').removeClass('d-none');
            // 顯示拍照按鈕，隱藏退出應用程序、下載照片、恢復攝像頭按鈕
            $('#take-photo').removeClass('d-none');
            $('#exit-app').addClass('d-none');
            $('#download-photo').addClass('d-none');
            $('#resume-camera').addClass('d-none');
        }
    </script>
</body>

</html>