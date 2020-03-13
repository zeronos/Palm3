
var addProductModal =
    `
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
<form method="post" id="formAdd" name = "formAdd" action="add_OilPalmAreaVol.php"
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">เพิ่มผลผลิต</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อแปลง</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="sub" name="name" class="form-control">
                            <option selected>เลือกแปลง</option>
                            <option>ไลอ้อน 1</option>
                            <option>ไลอ้อน 2</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>วันที่เก็บผลผลิต</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="date" name="date" class="form-control" id="rank">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ผลผลิต (ก.ก.)</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="number" name="weight" class="form-control" id="rank">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ราคาต่อหน่วย</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="number" name="UnitPrice" class="form-control" id="rank">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addOilPalmAreaVol" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                
            </div>
        </div>
        </form>
    </div>
</div>

`;

var addProductModal1 =
    `
<div class="modal fade" id="addProductModal1" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">เพิ่มผลผลิต</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อแปลง</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="sub" class="form-control">
                            <option selected>เลือกแปลง</option>
                            <option>ไลอ้อน 1</option>
                            <option>ไลอ้อน 2</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>วันที่เก็บผลผลิต</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="date" class="form-control" id="rank">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ผลผลิต (ก.ก.)</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="number" class="form-control" id="rank">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ราคาต่อหน่วย</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="number" class="form-control" id="rank">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="addOilPalmAreaVol" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                
            </div>
        </div>
    </div>
</div>

`;



var imageModal =
    `
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">รูปภาพผลผลิต</h4>
            </div>
            <div class="modal-body" id="imageModalBody">
                <div class="container">
                    <div class="row margin-gal">
                        <a href="picture/defaultProductPalm/01.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/01.jpg" class="img-gal">
                        </a>
                        <a href="picture/defaultProductPalm/02.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/02.jpg" class="img-gal">
                        </a>
                        <a href="picture/defaultProductPalm/03.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/03.jpg" class="img-gal">
                        </a>
                        <a href="picture/defaultProductPalm/04.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/04.jpg" class="img-gal">
                        </a>
                    </div>
                    <div class="row margin-gal">
                        <a href="picture/defaultProductPalm/05.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/05.jpg" class="img-gal">
                        </a>
                        <a href="picture/defaultProductPalm/06.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/06.jpg" class="img-gal">
                        </a>
                        <a href="picture/defaultProductPalm/07.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/07.jpg" class="img-gal">
                        </a>
                        <a href="picture/defaultProductPalm/08.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/defaultProductPalm/08.jpg" class="img-gal">
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

`;