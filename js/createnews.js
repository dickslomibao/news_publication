$(document).ready(function () {
    $("#mydropdownlist").val(``);
    $("#openmodal").click(function () {
        $('#exampleModal').modal('show');
    });
    $("#add").click(function () {
        if ($("#newsid").length) {
            updateSaveNews('published');
        }
        else {
            addnews("add");
        }
    });
    $("#save").click(function () {
        if ($("#newsid").length) {
            updateSaveNews('save');
        }
        else {
            addnews("save");
        }
    });
});

function addnews(status) {
    let title = $("#title").val();
    let category = $("#category").val();
    let image = $("#image").val();
    let content = $('#summernote').summernote('code');
    if (title == "") {
        alert("Title is required");
    } else if (category == "") {
        alert("Category is required");
    } else if ($('#summernote').summernote('isEmpty') || content.trim() == "") {
        alert("Content is required");
    } else {
        let breaking = 0;
        let featured = 0;

        if ($("#breaking").prop("checked") === true) {
            breaking = 1;
        }
        if ($("#featured").prop("checked") === true) {
            featured = 1
        }
        $.ajax({
            url: "create_news.php",
            type: "POST",
            data: {
                'add': status,
                'title': title,
                'category': category,
                'content': content,
                'breaking': breaking,
                'featured': featured,
                'image':image,
            },
            success: function (response) {
                if (response.trim() == "200") {
                    window.location.href = "dashboard.php";
                } else {
                    alert(response.trim());
                }
            }
        });
    }
}

function updateSaveNews(status) {
    let title = $("#title").val();
    let category = $("#category").val();
    let image = $("#image").val();

    let content = $('#summernote').summernote('code');
    let newsid = $("#newsid").val();
    if (title == "") {
        alert("Title is required");
    } else if (category == "") {
        alert("Category is required");
    } else if ($('#summernote').summernote('isEmpty') || content.trim() == "") {
        alert("Content is required");
    } else {
        let breaking = 0;
        let featured = 0;

        if ($("#breaking").prop("checked") === true) {
            breaking = 1;
        }
        if ($("#featured").prop("checked") === true) {
            featured = 1
        }
        $.ajax({
            url: "create_news.php",
            type: "POST",
            data: {          
                'update': status,
                'id':newsid,
                'title': title,
                'category': category,
                'content': content,
                'breaking': breaking,
                'featured': featured,
                'image':image,
            },
            success: function (response) {
                if (response.trim() == "200") {
                    window.location.href = "dashboard.php";
                } else {
                    alert(response.trim());
                }
            }
        });
    }
}