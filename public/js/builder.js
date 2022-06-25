/*!
 * Builder.js
 */
var newhref = '';
var oldhref = '';
$(document).on('click', '.collS', function () {
    newhref = $(this).attr('href');
    var l = $('.collapse.show').length;
    if (l > 0) {
        var colid = $('.collapse.show').attr('id');
        $('#' + colid).attr('class', '');
        $('#' + colid).attr('class', 'panel-collapse chapter-body collapse');
    }


});
$(document).on('click', '.uploadNewFile', function () {
    var lectureId = $(this).attr('lectureId');
    var lactureType = $(this).attr('data-lacture-type');
    if(lactureType=='scorm'){
        $("#scorm_lecture_id").val(lectureId);
        $.ajax({
            url: '/scorm/file/data',
            type: 'GET',
            data: {},
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.success){
                    $("#scorm_wraper").html('');
                    $("#scorm_wraper").append(response.html);
                    $('#scormFileUpload').modal('show');
                }
            },
            error: function (xhr, status, error) {
                toastr.error(error, "Oops!");
            }
        });
    }
    else{
        $("#lectureId").val(lectureId);
        $('#fileUploadModal').modal('show');
    }
});


$(document).ready(function () {
    initSortable();
});


/*
 *  Initialize sortable
 */
function initSortable() {
    $(".chapter-holder, .chapter-lecture-holder").sortable({
        stop: function (event, ui) {
            indexing();
        }
    });
}


/*
 *  check if builder is ready
 */
function builderReady() {
    if (!jQuery.isReady) {
        toastr.warning("Some assests are still loading.", "A moment please!");
        return false;
    }
}

/*
 *  delete a chapter or lecture
 */
$(".chapter-holder").on("click", ".manage-class.delete-item", function (event) {
    event.preventDefault();
    var selectedItem = $(this).closest(".panel");
    var selectedChapter = $(this).closest(".chapter");
    itemType = $(this).attr("data-type");
    itemId = $(this).attr("data-id");
    $("#destroytype").val(itemType);
    $("#curriculumId").val(itemId);
    $('#destroy').modal('show');

});


/*
 *  Check if section is empty
 */
function emptySection() {
    if (!$(".chapter").length) {
        $(".chapter-holder").html('<div class="empty-section empty-chapter"><i class="mdi mdi-clipboard-text"></i><h5>No chapters here, add a new one!</h5></div>');
    }
}


/*
 *  Add a new lecture
 */


$(".chapter-holder").on("click", ".add-lecture", function (event) {
    var chapter = $(this).attr("data-chapter");
    var lectureType = $(this).attr("data-type");
    var certify = $(this).attr("data-certify");
    $("#certify_id").val(certify);
    $("#chapter_id").val(chapter);
    $("#contentType").val(lectureType);
    $("#lectureForm").html('');
    if (lectureType == "text") {
        $("#lectureForm").append('<textarea class="form-control" id="summary-ckeditor" name="content" placeholder="Lecture Content" rows="5" required></textarea>');
    } else if (lectureType == "link") {
        $("#lectureForm").append('<input type="url" class="form-control" id="summary-ckeditor" name="content" placeholder="Lecture Content">');

    } else if (lectureType == "downloads") {
        $("#lectureForm").append('<input type="file" accept="video/mp4" name="content" class="form-control">');

    } else if (lectureType == "video") {
        $("#lectureForm").append('<input type="file" accept="video/mp4" name="content" class="form-control">');

    } else if (lectureType == "pdf") {
        $("#lectureForm").append('<input type="file" accept="application/pdf, application/vnd.ms-excel" name="content" class="form-control">');

    } else if (lectureType == "scorm") {
		
		var ScromPath= path;
		
        $.ajax({
            url: ScromPath,
            type: 'GET',
            data: {},
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.success){
                    $("#lectureForm").append(response.html);
                }
            },
            error: function (xhr, status, error) {
                toastr.error(error, "Oops!");
            }
        });
        //$("#lectureForm").append('<input type="file" accept="application/zip" name="content" class="form-control">');

    } else if (lectureType == "aws_video") {

    } else if (lectureType == "aws_audio") {

    }
    $('#lectureModal').modal('show');
});

/*
 *  chapter call back
 */
function chapterCallback() {
    var uniqueKey = random({
        length: 16,
        type: "alphabel",
        case: "upper"
    });
    var newElement = $("body").find(".newly");
    newElement.find(".panel-title a").attr("href", "#div-" + uniqueKey);
    newElement.find(".panel-collapse").attr("id", "div-" + uniqueKey);
    newElement.find(".dropify").dropify();
    newElement.removeClass("newly");
    initSortable();
    indexing();
}

/*
 *  Send to database on checkbox change
 */
$("body").on("change", ".send-to-server-change-checkbox", function (event) {
    event.preventDefault();
    var holder = $(this);
    if (holder.prop("checked")) {
        fieldValue = holder.val();
    } else {
        fieldValue = "";
    }
    var extradata = holder.attr("extradata"),
        url = holder.attr("url"),
        fieldName = holder.attr("name"),
        url = holder.attr("url"),
        loader = true;

    var data = {};
    data[fieldName] = fieldValue;

    if (holder.attr("extradata") !== undefined) {
        // format data
        var dataArray = extradata.split("|");
        dataArray.forEach(function (item) {
            var singleItem = item.split(":");
            data[singleItem[0]] = singleItem[1];
        });
    }
    if (holder.attr("loader") === "true") {
        loader = true;
    } else if (holder.attr("loader") === "false") {
        loader = false;
    }

    server({
        url: url,
        data: data,
        loader: loader
    });
})


/*
 *  chapter & lecture indexing
 */
function indexing() {
    $(".panel.chapter").each(function (index) {
        $(this).find(".panel-title .indexing").text(index + 1 + ".)");
        $(this).find("input.chapter-indexing").val(index + 1);
        $(this).find(".panel.lecture").each(function (i) {
            $(this).find(".panel-title .indexing").text(i + 1 + ".)");
            $(this).find("input.lecture-indexing").val(i + 1);
            $(this).find("input, textarea").each(function () {
                var newName = $(this).attr("original-name") + parseInt(index + 1) + "[]";
                // 			$(this).attr("name", newName);
            });

        });
    });
}

/*
 *  when class name is updated
 */
$(".class-name").keyup(function () {
    $(".page-header h3").text($(this).val());
})

/*
 *  when chapter title is updated
 */
$(".chapter-holder").on("keyup", ".chapter-title", function (event) {
    var title = $(this).val();
    $(this).closest(".panel").find(".panel-label").first().text(title);
})

/*
 *  when chapter title is updated
 */
//  $(".chapter-holder").on("change", ".dropify[type=file]", function (event) {
//  	log(event.target.files[0])
//  	toastr.warning(event.target.files[0].name, "Oops!");
// })


/*
* submit content form
*/
$(".landa-content-form").submit(function (event) {
    event.preventDefault();
    var loader = false;
    if ($(this).attr("loader") === "true") {
        loader = true;
    }
    $(this).parsley().validate();
    if (($(this).parsley().isValid())) {
        if (loader) {
            showLoader();
        }
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (response) {
                if (loader) {
                    hideLoader();
                }
                serverResponse(response);
            },
            error: function (xhr, status, error) {
                if (loader) {
                    hideLoader();
                }
                toastr.error(error, "Oops!");
            }
        });
    } else {
        $(".collapse").collapse("show");
        toastr.warning("Please fill all required fields before saving.", "Oops!");
    }
});

function checked_scorm_provider(finder, scorm_provider) {
    $(".scorm-provider-radio").prop("checked", false);
    $("#" + scorm_provider).prop("checked", true);

    $(".course-provider-logo").removeClass("course-provider-logo-checked");
    $(finder).addClass("course-provider-logo-checked");
}
function changeTitleOfImageUploader(photoElem) {
    var fileName = $(photoElem).val().replace(/C:\\fakepath\\/i, '');
    $(photoElem).siblings('label').text(ellipsis(fileName));
}
function ellipsis(str, length, ending) {
    if (length == null) {
        length = 40;
    }
    if (ending == null) {
        ending = '...';
    }
    if (str.length > length) {
        return str.substring(0, length - ending.length) + ending;
    } else {
        return str;
    }
}
