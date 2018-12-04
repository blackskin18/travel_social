$(function () {
    $("div.btn_comment").click(function () {
        var articleId = $(this).data('article-id');
        $("div#comment_box_" + articleId).css("display", "block");
        $("div#comment_box_" + articleId+">.list_comment").html("");

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });

        $.ajax({
            url: '/comment/get',
            type: 'GET',
            data: {post_id: articleId},
            success: function (response) {
                var data = response.data;
                for (var i in data) {
                    var commentElement = `
                        <div class="row">
                            <div class="avatar_comment_box col-lg-1">
                                <img class="avatar_image" src="${window.location.origin}/asset/images/avatar/${data[i].user.id}/${data[i].user.avatar}" alt="">
                            </div>
                                <div class="comment">
                                    <a href="/user/personal-page/${data[i].user_id}">
                                        ${data[i].user.name}
                                    </a>
                                    <div style="display: inline-block;">
                                        <p>${data[i].content}</p>
                                    </div>
                                </div>
                        </div>`;
                    $("div#comment_box_" + articleId+">.list_comment").append(commentElement);
                }
            }
        });

    });

    $("input.comment_input").keypress(function (event) {
        if (event.which === 13) {
            var articleId = $(this).data('article-id');
            var message = $(this).val();
            $(this).val("");

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });

            $.ajax({
                url: '/comment/send',
                type: 'POST',
                data: {comment_content: message, post_id: articleId},
                success: function (data) {
                    // console.log(data);
                }
            });
        }
    });
});
