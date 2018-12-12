$(function () {
    $(".image_list .image_showed").click(function () {
        var postID = $(this).data('post-id');
        var src = $(this).children().attr('src');
        var index = $(this).data('index');
        console.log(index);
        displayImage(src, postID, index);
    });

    var functionNextImage = function (postId, index) {
        var countImageInList = $("#image_list_" + postId + ">div").length;
        if (index + 1 == countImageInList && countImageInList != 1) {
            index = 0;
        }
        if (countImageInList == 1) {
            index = -1;
        }

        var image = $("#image_list_" + postId + ">div").eq(index + 1).find($("a>img"));
        var imageSrc = image.attr("src");
        displayImage(imageSrc, postId, index + 1);
    };

    var functionPrevImage = function (postId, index) {
        var countImageInList = $("#image_list_" + postId + ">div").length;
        if (index == 0) {
            index = countImageInList - 1;
        }
        if (countImageInList == 1) {
            index = 1;
        }

        var image = $("#image_list_" + postId + ">div").eq(index - 1).find($("a>img"));
        var imageSrc = image.attr("src");
        displayImage(imageSrc, postId, index - 1);
    };

    var displayImage = function (src, postID, index) {
        $(".image_toolbar>a").css("display", "none");
        $(".next_image").unbind();

        var imageElement = `<img src="${src}" alt=""/>`;
        $(".image_displayed_box .popup_content").css({
            width: 0,
            top: $(window).height() / 2,
            left: $(window).width() / 2,
        });
        $(".image_displayed_box").css('display', 'block');
        $(".image_displayed").css('margin', 0);

        $(".image_displayed").children().remove();
        $(".image_displayed").append(imageElement);

        $(".image_displayed").children().css('borderRadius', '11px');

        $(".image_displayed_box .popup_content").animate({
            width: 700,
            top: 75,
            left: ($(window).width() - 700) / 2
        }, "slow", function () {
            var imageHeight = $(".image_displayed_box .popup_content").height();

            $(".image_toolbar>a.next_image").css({
                top: imageHeight / 2 + 75 - 25,
                left: ($(window).width() - 700) / 2 + 700 - 50,
                display: 'block',
            });
            $(".image_toolbar>a.prev_image").css({
                top: imageHeight / 2 + 75 - 25,
                left: ($(window).width() - 700) / 2 + 25,
                display: 'block',
            });
        });


        $(".next_image").click(function () {
            functionNextImage(postID, index);
        });

        $(".prev_image").click(function () {
            functionPrevImage(postID, index);
        });
    }
})
