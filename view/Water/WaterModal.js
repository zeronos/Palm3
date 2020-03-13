function RainModalTemp(subName, startTime, endTime, length, volume, date) {
    let modal =
        `
    <div class="modal fade" id="RainModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รายละเอียดแปลงที่ฝนตก</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อแปลง</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${subName}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ช่วงเวลาฝนเริ่มตก</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${startTime}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ช่วงเวลาฝนหยุดตก</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${endTime}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ระยะเวลาฝนตก</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${length}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ปริมาณฝน (ลบ.ม.)</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${volume}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>วันที่</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${date}>
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

    return modal;
}

function NonRainModalTemp(subName, startTime, endTime, date) {
    let modal =
        `
    <div class="modal fade" id="RainModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รายละเอียดแปลงที่ฝนทิ้งช่วง</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อแปลง</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${subName}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ช่วงเวลาฝนเริ่มทิ้งช่วง</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${startTime}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ช่วงเวลาฝนหยุดทิ้งช่วง</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${endTime}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>วันที่</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${date}>
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

    return modal;
}

function SystemModalTemp(subName, startTime, endTime, length, date) {
    let modal =
        `
    <div class="modal fade" id="SystemModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รายละเอียดแปลงระบบให้น้ำ</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อแปลง</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${subName}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>เวลาให้น้ำ</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${startTime}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>เวลาหยุดให้น้ำ</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${endTime}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ระยะเวลาให้น้ำ (นาที)</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${length}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>วันที่</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${date}>
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

    return modal;
}

function ManualModalTemp(subName, car, date) {
    let modal =
        `
    <div class="modal fade" id="ManualModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รายละเอียดแปลงระบบให้น้ำ</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อแปลง</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${subName}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>จำนวนรถ</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${car}>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>วันที่</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="rank" value=${date}>
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

    return modal;
}




function getByOne() {
    let test = [{
            title: `ชื่อแปลง : ไลอ้อน 1
                    ปริมาณ : 200 ลบ.ม.`,
            start: new Date(2019, 04, 26, 12, 0),
            end: new Date(2019, 04, 29, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 1
                    ปริมาณ : 200 ลบ.ม.`,
            start: new Date(2019, 05, 01, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 2
                    ปริมาณ : 2000 ลบ.ม.`,
            start: new Date(2019, 05, 05, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    ปริมาณ : 150 ลบ.ม.`,
            start: new Date(2019, 05, 06, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    ปริมาณ : 100 ลบ.ม.`,
            start: new Date(2019, 05, 08, 12, 0),
            allDay: true,
            className: 'important',
            color: '#05acd3',
            textColor: 'white'
        },
    ];

    return test;
}

function getByOneHalf() {
    let test = [{
            title: `ชื่อแปลง : ไลอ้อน 1
                    ปริมาณ : 200 ลบ.ม.`,
            start: new Date(2019, 04, 30, 12, 0),
            end: new Date(2019, 04, 31, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 1
                    ปริมาณ : 200 ลบ.ม.`,
            start: new Date(2019, 05, 02, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 2
                    ปริมาณ : 2000 ลบ.ม.`,
            start: new Date(2019, 05, 03, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    ปริมาณ : 150 ลบ.ม.`,
            start: new Date(2019, 05, 04, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    ปริมาณ : 100 ลบ.ม.`,
            start: new Date(2019, 05, 07, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
    ];

    return test;
}

function getByTwo() {
    let test = [{
            title: `ชื่อแปลง : ไลอ้อน 1
                    ระยะเวลา : 120 นาที`,
            start: new Date(2019, 04, 29, 12, 0),
            end: new Date(2019, 04, 31, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 1
                    ระยะเวลา : 290 นาที`,
            start: new Date(2019, 05, 04, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 2
                    ระยะเวลา : 10 นาที`,
            start: new Date(2019, 05, 05, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    ระยะเวลา : 20 นาที`,
            start: new Date(2019, 05, 06, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    ระยะเวลา : 200 นาที`,
            start: new Date(2019, 05, 07, 12, 0),
            allDay: true,
            className: 'important',
            color: '#00ce68',
            textColor: 'white'
        },
    ];

    return test;
}

function getByThree() {
    let test = [{
            title: `ชื่อแปลง : ไลอ้อน 1
                    จำนวนรถ : 1 คัน`,
            start: new Date(2019, 04, 28, 12, 0),
            end: new Date(2019, 04, 29, 12, 0),
            allDay: true,
            className: 'important',
            color: '#f6c23e',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 1
                    จำนวนรถ : 12 คัน`,
            start: new Date(2019, 05, 01, 12, 0),
            allDay: true,
            className: 'important',
            color: '#f6c23e',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 2
                    จำนวนรถ : 2 คัน`,
            start: new Date(2019, 05, 03, 12, 0),
            allDay: true,
            className: 'important',
            color: '#f6c23e',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    จำนวนรถ : 20 คัน`,
            start: new Date(2019, 05, 06, 12, 0),
            allDay: true,
            className: 'important',
            color: '#f6c23e',
            textColor: 'white'
        },
        {
            title: `ชื่อแปลง : ไลอ้อน 3
                    จำนวนรถ : 10 คัน`,
            start: new Date(2019, 05, 08, 12, 0),
            allDay: true,
            className: 'important',
            color: '#f6c23e',
            textColor: 'white'
        },
    ];

    return test;
}