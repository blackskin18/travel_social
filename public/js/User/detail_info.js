$(function () {
    var lastEdit = null;
    $(".edit_info_btn").click(function () {
        var elementId =$(this).prop('id');
        var valuePanel = $(this).parent().parent().children().eq(1);
        var oldValue = valuePanel.text();
        var buttonEdit = $(this);


        $(".submit").remove();
        $(".cancel").remove();
        $(".edit_info_btn").css('display', 'block')
        $(".edit_info_btn").prop("disabled", false);
        if(lastEdit) {
            if($("#"+lastEdit).parent().parent().children().eq(1).children().eq(0)) {
                var lastEditValue = $("#"+lastEdit).parent().parent().children().eq(1).children().eq(0).val();
                $("#"+lastEdit).parent().parent().children().eq(1).html(lastEditValue);
            }
            $("#"+lastEdit).parent().children().eq(1).remove();
            $("#"+lastEdit).parent().children().eq(1).remove();
        }

        lastEdit = elementId;


        $(this).css('display', 'none');
        $(this).prop("disabled", true);

        //change text to input tag
        if (elementId === 'edit_gender') {
            $(this).parent().parent().children().eq(1).html(`<select name="" class="content" style="border: 1px solid #b0d4f1">
                                                            <option value="Nam">Nam</option>
                                                            <option value="Nữ">Nữ</option>
                                                            <option value="Khác">Khác</option>
                                                    </select> `);
        } else {
            $(this).parent().parent().children().eq(1).html(`<input type="text" class="content" value="${oldValue}" style="border: 1px solid #b0d4f1">`);
        }

        var newButtonElement = `<button class="button small primary fit submit">Gửi</button> <button class="button small primary fit cancel" style="display:block"> Hủy</button>`
        $(this).parent().append(newButtonElement);

        $("button.cancel").click(function () {
            $(this).parent().parent().children().eq(1).html(oldValue);
            $(this).parent().children().eq(1).remove();
            $(this).parent().children().eq(1).remove();
            buttonEdit.css('display', 'block');
            buttonEdit.prop("disabled", false);
        });

        $("button.submit").click(function () {
            var that = $(this);
            var value = $(this).parent().parent().children().eq(1).children().eq(0).val();

            $(this).parent().children().eq(2).remove();
            $(this).parent().children().eq(1).remove();
            buttonEdit.css('display', 'block');
            buttonEdit.prop("disabled", false);

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });

            $.ajax({
                url: '/user/edit/'+elementId,
                type: 'post',
                data: {value: value},
                success: function (responese) {
                    var data = JSON.parse(responese).data;
                    valuePanel.children()[0].remove();
                    console.log(data);
                    valuePanel.text(data);
                },
                error: function () {
                    
                }
            });

        });

    });


});
