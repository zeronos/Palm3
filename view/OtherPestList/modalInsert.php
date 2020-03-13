<!-- addModal -->
<div class="modal fade" id="insert" name="addModal" tabindex="-1" role="dialog">
    <form action="upload.php" method="post" enctype="multipart/form-data" id="form-insert">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: #006664;">
                    <h4 class="modal-title" id="largeModalLabel" style="color:white">เพิ่มชนิดศัตรูพืช</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="main">
                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>ชื่อ <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <input type='text' id='name_insert' name='name_insert' class='form-control' placeholder="ชื่อศัตรูพืช" required="" oninput="setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>ชื่อทางการ <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <input type='text' id='alias_insert' name='alias_insert' class='form-control' placeholder="ชื่อวิทยาศาสตร์" required="" oninput="setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>ลักษณะ <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <textarea type="text" rows="2" class="form-control mb-2" name='charactor_insert' id="charactor_insert" placeholder="ลักษณะ" required="" oninput="setCustomValidity('')"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>อันตราย <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <textarea type="text" rows="2" class="form-control mb-2" name='danger_insert' id="danger_insert" placeholder="อันตราย" required="" oninput="setCustomValidity('')"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>รูปศัตรูพืช <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>

                                    <div class="img-reletive">
                                        <img width="100px" height="100px" id="img-pic-logo" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                        <input type="file" id="pic-logo" name="icon_insert" accept=".jpg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>รูปลักษณะ <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div id="grid-pic-style-char" class="grid-img-multiple">

                                        <div class="img-reletive">
                                            <img width="100px" height="100px" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                            <input type="file" id="pic-style-char" name="picstyle_insert[]" accept=".jpg,.png" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3  col-xs-6 form-control-label text-right'>
                                <label>รูปลักษณะการทำลาย <span class="text-danger"> *</span></label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div id="grid-p_photo" class="grid-img-multiple">

                                        <div class="img-reletive">
                                            <img width="100px" height="100px" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                            <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="crop-img">
                        <center>
                            <!-- <input id='pic-logo' type='file' class='item-img file center-block' name='icon_insert' /> -->
                            <!-- <img id="img-insert" src="https://via.placeholder.com/200x200.png" alt="" width="200" height="200"> -->
                            <div class="center-block upload-demo2"></div>
                        </center>
                    </div>


                    <input type="hidden" id="hidden_id" name="request" value="insert" />

                    <div class="modal-footer normal-button">
                        <button type="submit" class="btn btn-success waves-effect insertSubmit" name="save" id="add-data" value="insert">ยืนยัน</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ยกเลิก</button>
                    </div>
                    <div class="modal-footer crop-button">
                        <button type="button" class="btn btn-success btn-crop">ยืนยัน</button>
                        <button type="button" class="btn btn-danger btn-cancel-crop">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function imagesPreview(input, img_prepend, first_img, className) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    // $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    $(img_prepend).prepend(`<div class="card" width="70px" hight="70px">
                                        <div class="card-body" style="padding:0;">
                                            <img class="${className}" src = "${event.target.result}" id="img-${first_img+(+new Date)}" width="100%" hight="100%" />
                                        </div>
                                        <div class="card-footer">
                                            <button  type="button" class="btn btn-warning edit-img">แก้ไข</button>
                                            <button  type="button" class="btn btn-danger delete-img">ลบ</button>
                                        </div>
                                    </div>`)
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
        $(input).val('')
    }

    function cropImage(input) {
        let rawImg
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                let rawImg = e.target.result;
                cropImg(rawImg, 'circle');
            }
            reader.readAsDataURL(input.files[0]);
        }
        $(input).val('')
    }

    function cropImg(url, type) {
        $('.main').hide()
        $('.normal-button').hide()
        $('.crop-img').show()
        $('.crop-button').show()

        let UC = $('.upload-demo2').croppie({
            viewport: {
                width: 200,
                height: 200,
                type: type
            },
            enforceBoundary: false,
            enableExif: true
        });
        UC.croppie('bind', {
            url: url
        }).then(function() {
            console.log('jQuery bind complete');
        });
    }

    function submitCrop(output) {
        $('.upload-demo2').croppie('result', {
                type: 'canvas',
                size: 'viewport'
            })
            .then(function(r) {
                $('.main').show()
                $('.normal-button').show()
                $('.crop-img').hide()
                $('.crop-button').hide()
                $('#' + output).attr('src', r)
            });
        $('.upload-demo2').croppie('destroy')
    }
    let idImg;
    $('#pic-logo').on('change', function() {
        cropImage(this)
        idImg = 'img-pic-logo'

    })
    $('#p_photo').on('change', function() {
        //alert('change')
        imagesPreview(this, '#grid-p_photo', 'p_photo', 'pic-photo');

    });
    $('#pic-style-char').on('change', function() {
        //alert('change')
        imagesPreview(this, '#grid-pic-style-char', 'pic-style-char', 'pic-SC');

    });
    $(document).on('click', '.delete-img', function() {
        $(this).parent().parent().remove()
    })
    $('.crop-img').hide()
    $('.crop-button').hide()

    $(document).on('click', '.edit-img', function() {
        let url = $(this).parent().prev().children().attr('src')
        idImg = $(this).parent().prev().children().attr('id')
        cropImg(url, 'square')

    })
    $(document).on('click', '.btn-crop', function(ev) {
        submitCrop(idImg)
    });
    $(document).on('click', '.btn-cancel-crop', function() {
        $('.main').toggle()
        $('.normal-button').toggle()
        $('.crop-img').toggle()
        $('.crop-button').toggle()
        $('.upload-demo2').croppie('destroy')
    })
</script>