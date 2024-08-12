$(document).ready(function () {
    $('#updateForm').on('submit', function (event) {
        event.preventDefault();

        let form = $(this);
        let formData = new FormData(form[0]);
        formData.append('_method', 'PUT');
        let id = form.data('id');
        $.ajax({
            url: 'students/'+id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    $('#updateStudentModal').modal('hide');
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                console.log('An error occurred. Please try again.');
            }
        });
    });
});
