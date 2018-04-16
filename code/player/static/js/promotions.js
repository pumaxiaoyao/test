$(function () {
    $("#Discount").css({ "color": "#0099ff", "background": "#e0efff" });
    setInterval(function () {
        autoPlay("banner");
    }, 10000);
});

function changeImg(next, type) {
    $(".mi_" + type + "_ctrl").find(".mi_select").removeClass("mi_select");
    $("[" + type + "_ctrl='" + next + "']").addClass("mi_select");

    $("[" + type + "_crt='1']").each(function () {
        $(this).attr(type + "_crt", "0");
        $(this).stop(true, false).animate({ "opacity": 0 }, 1000, function () {
            $(this).css({ "display": "none" });
        });
    });
    $("[view_" + type + "='" + next + "']").each(function () {
        $(this).attr(type + "_crt", "1");
        $(this).css({ "display": "block" });
        $(this).stop(true, false).animate({ "opacity": 1 }, 1000, function () {
        });
    });
}

function autoPlay(type) {
    console.log("auto playing");
    var index = $(".mi_" + type + "_ctrl").find(".mi_select").attr(type + "_ctrl");
    index = parseInt(index, 10);
    var next;
    if (type == "banner") {
        next = (index + 1) % 3;
    }
    changeImg(next, type);
}