$(function () {
    var myMap = new MapCustom();

    $("#btn_create_map").click(function () {
        // initMap();
        myMap.initMap();
        myMap.addListenerCreatePost("div#marker_info_box");
        $("div.map_box").css("display", "block");
    });

    $("#btn_create_trip").click(function () {
        $("#create_trip_box").toggle("slow", function () {
            $("#check_create_trip").prop('checked', true);
        });
    });

    var submitFormListener = $("#btn_create_post").click(function () {
        $(".alert").remove();
        var countError = 0;
        if($("#check_create_trip").is(":checked")) {
            let timeStart =  (new Date($("#time_start_input").val())).getTime();
            let timeEnd =  (new Date($("#time_end_input").val())).getTime();
            let timeNow = (new Date()).getTime();

            if(timeStart < timeNow) {
                $("#form_create_post").prepend(`<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> Thời gian bắt đầu chuyến đi phải sau thời điểm tạo bài viết .
                    </div>`);
            }

            if(timeStart && timeEnd) {
                if(timeStart > timeEnd) {
                    countError++;
                    $("#form_create_post").prepend(`<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> Thời gian đi phải sớm hơn thời gian kết thúc.
                    </div>`);
                }
            }
            if(!$("#trip_title_input").val()) {
                countError++;
                $("#form_create_post").prepend(`<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> bạn cần phải nhập tên chuyến đi.
                    </div>`);
            }
        }
        if(countError === 0) {
            $(this).off('click');
            $(this).prepend(`<span class="spinner-border spinner-border-sm"></span>`);
            $("#form_create_post").submit();
        }
    })

});
