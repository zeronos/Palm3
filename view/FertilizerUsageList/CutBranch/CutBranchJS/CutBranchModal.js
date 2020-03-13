var imageModal =
`
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">รูปภาพการล้างคอขวด</h4>
            </div>
            <div class="modal-body" id="imageModalBody">
                <div class="row margin-gal">
                    <a href="picture/CutBranch/01.jpg" class="col-xl-3 col-3">
                        <img src="../../picture/CutBranch/01.jpg" class="img-gal">
                    </a>
                    <a href="picture/CutBranch/02.jpg" class="col-xl-3 col-3">
                        <img src="../../picture/CutBranch/02.jpg" class="img-gal">
                    </a>
                    <a href="picture/CutBranch/03.jpg" class="col-xl-3 col-3">
                        <img src="../../picture/CutBranch/03.jpg" class="img-gal">
                    </a>
                  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

`;



function SubImageModalTemp(subName){
    let modal =
    `
    <div class="modal fade" id="CutImageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รูปการล้างคอขวดแปลง ${subName}</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row margin-gal">
                        <a href="picture/CutBranch/01.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/CutBranch/01.jpg" class="img-gal">
                        </a>
                        <a href="picture/CutBranch/02.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/CutBranch/02.jpg" class="img-gal">
                        </a>
                        <a href="picture/CutBranch/03.jpg" class="col-xl-3 col-3">
                            <img src="../../picture/CutBranch/03.jpg" class="img-gal">
                        </a>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    
    `;
    
    return modal;
}


function getByEvent()
{
    let test = [
        {
            title: `ชื่อแปลง : ไลอ้อน 1`,
            start: new Date(2019, 04, 26, 12, 0),
            end: new Date(2019, 04, 29, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 1`,
            start: new Date(2019, 05, 01, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 2`,
            start: new Date(2019, 05, 05, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3`,
            start: new Date(2019, 05, 06, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3`,
            start: new Date(2019, 05, 08, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
    ];

    return test;
}
