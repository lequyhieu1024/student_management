$(document).ready(function () {
    $("#updateForm").on("submit", function (event) {
        event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống

        var formData = new FormData(this);
        var form = $(this);
        var actionUrl = form.attr("action"); // Lấy URL từ thuộc tính action của form
        console.log(formData);
        $.ajax({
            url: actionUrl,
            type: "PUT",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                alert(response.success);
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    console.log(errors[key]);
                }
            },
        });
    });
});
