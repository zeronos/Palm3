class Milkey {

    constructor(obj, size) {
        this.check = true;
        this.stringHtml = "";
        this.obj = obj;
        this.id = Math.floor(100000 + Math.random() * 900000);
        this.objID = obj.attr('id');

        if (typeof (this.obj) == "object") {
            obj.addClass("main-canvas");

            if (size) {
                obj.css("width", size + "px");
                obj.css("height", size + "px");
            }
            else {
                obj.css("width", 300 + "px");
                obj.css("height", 300 + "px");
            }
        }
        else {
            alert("LION");
        }
    }

    createTopLeft(type, value) {
        if (type == "green") {
            if(value == 0)
            {
                value = "0";
            }

            this.stringHtml += `<div class="half-img-tl" id="img_tl_${this.id}" style="background-color:#30f663;"></div>
                                <div class="half-text-tl" id="text_tl_${this.id}">${value? value : ""}</div>`;
        }
        else if (type == "red") {
            this.stringHtml += `<div class="half-img-tl" id="img_tl_${this.id}" style="background-color:#e74a3b;"></div>
                                <div class="half-text-tl" id="text_tl_${this.id}">${value? value : ""}</div>`;
        }
        else {
            this.check = false;
        }
    }
    createTopRight(type, value) {
        if (type == "green") {
            if(value == 0)
            {
                value = "0";
            }
            this.stringHtml += `<div class="half-img-tr" id="img_tr_${this.id}" style="background-color:#30f663;"></div>
                                <div class="half-text-tr" id="text_tr_${this.id}">${value? value : ""}</div>`;
        }
        else if (type == "red") {
            this.stringHtml += `<div class="half-img-tr" id="img_tr_${this.id}" style="background-color:#e74a3b;"></div>
                                <div class="half-text-tr" id="text_tr_${this.id}">${value? value : ""}</div>`;
        }
        else {
            this.check = false;
        }
    }
    createBottomLeft(type, value) {
        if (type == "green") {
            if(value == 0)
            {
                value = "0";
            }
            this.stringHtml += `<div class="half-img-bl" id="img_bl_${this.id}" style="background-color:#30f663;"></div>
                                <div class="half-text-bl" id="text_bl_${this.id}">${value? value : ""}</div>`;
        }
        else if (type == "red") {
            this.stringHtml += `<div class="half-img-bl" id="img_bl_${this.id}" style="background-color:#e74a3b;"></div>
                                <div class="half-text-bl" id="text_bl_${this.id}">${value? value : ""}</div>`;
        }
        else {
            this.check = false;
        }
    }
    createBottomRigth(type, value) {
        if (type == "green") {
            if(value == 0)
            {
                value = "0";
            }
            this.stringHtml += `<div class="half-img-br" id="img_br_${this.id}" style="background-color:#30f663;"></div>
                                <div class="half-text-br" id="text_br_${this.id}">${value? value : ""}</div>`;
        }
        else if (type == "red") {
            this.stringHtml += `<div class="half-img-br" id="img_br_${this.id}" style="background-color:#e74a3b;"></div>
                                <div class="half-text-br" id="text_br_${this.id}">${value? value : ""}</div>`;
        }
        else {
            this.check = false;
        }
    }

    renderImage() {

        if (this.check) {
            this.obj.append(this.stringHtml);

            var parentSize = $("#" + this.objID).css('width').replace('px', '');

            $("#text_tl_" + this.id).css("font-size", parentSize / 2.5 + "px");
            $("#text_tr_" + this.id).css("font-size", parentSize / 2.5 + "px");
            $("#text_bl_" + this.id).css("font-size", parentSize / 2.5 + "px");
            $("#text_br_" + this.id).css("font-size", parentSize / 2.5 + "px");

            var w = $("#text_tl_" + this.id).css("width").replace('px', '');
            var h = $("#text_tl_" + this.id).css("height").replace('px', '');
            var top = parentSize / 4 - h / 2;
            var left = parentSize / 4 - w / 2;

            $("#text_tl_" + this.id).css("top", top);
            $("#text_tl_" + this.id).css("left", left);

            var w = $("#text_tr_" + this.id).css("width").replace('px', '');
            var h = $("#text_tr_" + this.id).css("height").replace('px', '');
            var top = parentSize / 4 - h / 2;
            var right = parentSize / 4 - w / 2;

            $("#text_tr_" + this.id).css("top", top);
            $("#text_tr_" + this.id).css("right", right);

            var w = $("#text_bl_" + this.id).css("width").replace('px', '');
            var h = $("#text_bl_" + this.id).css("height").replace('px', '');
            var bottom = parentSize / 4 - h / 2;
            var left = parentSize / 4 - w / 2;

            $("#text_bl_" + this.id).css("bottom", bottom);
            $("#text_bl_" + this.id).css("left", left);

            var w = $("#text_br_" + this.id).css("width").replace('px', '');
            var h = $("#text_br_" + this.id).css("height").replace('px', '');
            var bottom = parentSize / 4 - h / 2;
            var right = parentSize / 4 - w / 2;

            $("#text_br_" + this.id).css("bottom", bottom);
            $("#text_br_" + this.id).css("right", right);
        }
        else {
            alert("LION");
        }

    }
}