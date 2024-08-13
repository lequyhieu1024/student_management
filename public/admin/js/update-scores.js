function listSubject(id) {
    console.log(id);
    return new Promise((resolve, reject) => {
        $(document).ready(function () {
            let subjectUrl = BASE_URL + '/admin/list-subject-ajax/'+id;
            $.ajax({
                url: subjectUrl,
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        const subjects = response.subjects;
                        resolve(subjects);
                    } else {
                        alert(response.message);
                        reject(response.message);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    console.log('An error occurred. Please try again.');
                    reject('An error occurred.');
                }
            });
        });
    });
}

async function viewModal2(id) {
    const checkboxes = document.querySelectorAll('.student_subject:checked');
    const subjectsContainer = document.getElementById('subjectsContainer');
    subjectsContainer.innerHTML = '';

    const subjects = await listSubject(id);
    let selectedSubjectIds = Array.from(checkboxes).map(checkbox => checkbox.getAttribute('data-subject-id'));
    console.log('từ checkbox: ', selectedSubjectIds);
    checkboxes.forEach(checkbox => {
        const subjectId = checkbox.getAttribute('data-subject-id');
        const subjectName = checkbox.getAttribute('data-subject-name');
        const score = checkbox.getAttribute('data-score');

        let optionsHtml = '';
        subjects.forEach(subject => {
            optionsHtml += `<option value="${subject.id}" ${subject.id == subjectId ? 'selected' : ''}>${subject.name}</option>`;
        });

        const inputHtml = `
        <div class="mb-1 form_option">
            <div class="d-flex justify-content-center subjects gap-2 p-2">
                <div class="col-8">
                    <select class="form-control subject-data" name="scores[${subjectId}]" id="score-${subjectId}">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="score-${subjectId}" name="scores[${subjectId}]" value="${score}"/>
                </div>
                <div class="col-1">
                    <a id="${subjectId}" class="removeBtn text-white btn btn-danger">x</a>
                </div>
            </div>
            <span class="text-danger" id="error-${subjectId}"></span>
        </div>
        `;
        subjectsContainer.insertAdjacentHTML('beforeend', inputHtml);
    });

    //bấm nút +
    $('.addBtn').on('click', function () {
        render(selectedSubjectIds);
    });

    subjectsContainer.addEventListener('change', function (event) {
        if (event.target && event.target.classList.contains('subject-data')) {
            const selectElement = event.target;
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const selectedValue = selectedOption.value;

            if (selectedValue) {
                selectElement.id = `score-${selectedValue}`;
                selectElement.name = `scores[${selectedValue}]`;
                const inputElement = selectElement.closest('.form_option').querySelector('input');
                const errorElement = selectElement.closest('.form_option').querySelector('span');
                const removeElement = selectElement.closest('.form_option').querySelector('a');
                if (inputElement) {
                    inputElement.id = `score-${selectedValue}`;
                    inputElement.name = `scores[${selectedValue}]`;
                    errorElement.id = `error-${selectedValue}`;
                    removeElement.id = selectedValue;
                }
                selectedSubjectIds.push(selectedValue);
                // console.log('sau select: ', selectedSubjectIds);
            }
        }
    });


    // bấm nút x
    subjectsContainer.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('removeBtn')) {
            const parentDiv = event.target.closest('.form_option');
            if (parentDiv) {
                parentDiv.remove();
                const subjectId = event.target.getAttribute('id');
                selectedSubjectIds = selectedSubjectIds.filter(item => item !== subjectId)
                // console.log('sau remove: ', selectedSubjectIds);
            }
        }
    });

    function render(selectedSubjectIds){
        let optionsHtml = '<option>Chọn 1 môn học</option>';
        subjects.forEach(subject => {
            if (!selectedSubjectIds.includes(String(subject.id))) {
                optionsHtml += `<option value="${subject.id}">${subject.name}</option>`;
            }
        });
        const newFormHtml = `
        <div class="mb-1 form_option">
            <div class="d-flex justify-content-center subjects gap-2 p-2">
                <div class="col-8">
                    <select class="form-control subject-data" name="scores[new]" id="score-new">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="score-new" name="scores[new]" value=""/>
                </div>
                <div class="col-1">
                    <a id="new" class="removeBtn text-white btn btn-danger">x</a>
                </div>
            </div>
            <span class="text-danger" id="error-new"></span>
        </div>
        `;
        subjectsContainer.insertAdjacentHTML('beforeend', newFormHtml);
    }

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
