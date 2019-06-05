window.onload = function () {
    var myMap = new MapCustom();
    $("#btn_create_map").click(function () {
        myMap.initMap();
        myMap.addListenerCreatePost("div#marker_info_box");
        $("div.map_box").css("display", "block");
    });

    $("#btn_create_trip").click(function () {
        $(".alert").remove();
        var countError = 0;
        let timeStart =  (new Date($("#time_start_input").val())).getTime();
        let timeEnd =  (new Date($("#time_end_input").val())).getTime();
        let timeNow = (new Date()).getTime();

        console.log(timeStart, timeEnd, timeNow, $("#time_start_input"), 1111);

        if(timeStart < timeNow) {
            $("#form_create_trip").prepend(`<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error!</strong> Thời gian bắt đầu chuyến đi phải sau thời điểm tạo bài viết .
                </div>`);
        }

        if(timeStart && timeEnd) {
            if(timeStart > timeEnd) {
                countError++;
                $("#form_create_trip").prepend(`<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error!</strong> Thời gian đi phải sớm hơn thời gian kết thúc.
                </div>`);
            }
        }
        if(!$("#trip_title_input").val()) {
            countError++;
            $("#form_create_trip").prepend(`<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error!</strong> bạn cần phải nhập tên chuyến đi.
                </div>`);
        }
        if(countError === 0) {
            $(this).off('click');
            $(this).prepend(`<span class="spinner-border spinner-border-sm"></span>`);
            $("#form_create_trip").submit();
        }
    });

};
