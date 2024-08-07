

function viewModal2() {
    const checkboxes = document.querySelectorAll('.student_subject:checked');
    const subjectsContainer = document.getElementById('subjectsContainer');

    subjectsContainer.innerHTML = '';

    checkboxes.forEach(checkbox => {
        const subjectId = checkbox.getAttribute('data-subject-id');
        const subjectName = checkbox.getAttribute('data-subject-name');
        const score = checkbox.getAttribute('data-score');
        const inputHtml = `
        <div class="mb-3 col-6">
            <label for="score-${subjectId}" class="form-label">${subjectName}</label>
            <input type="text" class="form-control" id="score-${subjectId}" name="scores[${subjectId}]" value="${score}"/>
            <span class="text-danger" id="error-${subjectId}"></span>
        </div>`
    ;
        subjectsContainer.insertAdjacentHTML('beforeend', inputHtml);
    });

    var myModal = new bootstrap.Modal(document.getElementById('updateScoreModal'), {});
    myModal.show();
}

function validator() {
    const form = document.getElementById('updateScoreForm');
    const inputs = form.querySelectorAll('input[name^="scores"]');
    let isValid = true;

    inputs.forEach(input => {
        const value = input.value.trim();
        const subjectId = input.id.split('-')[1];
        const errorSpan = document.getElementById(`error-${subjectId}`);

        errorSpan.textContent = '';

        if (!value) {
            isValid = false;
            errorSpan.textContent = 'Không được bỏ trống.';
            input.classList.add('is-invalid');
        } else if (isNaN(value) || Number(value) <= 0 || Number(value) > 10) {
            isValid = false;
            errorSpan.textContent = 'Điểm phải là số từ 0 đến 10.';
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}
