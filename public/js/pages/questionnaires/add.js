'use strict'
const form_body = document.getElementById('form-body')

const add_question_btn = document.getElementById('add_question_btn')

const addQuestions = function () {
	const newRow = document.createElement("div")
	newRow.classList.add("row","mb-1","additional_option")

	const newColDiv = document.createElement("div")
	newColDiv.classList.add("col-sm-12")

	const newColFormGroup = document.createElement("div")
	newColFormGroup.classList.add('form-group')


	const newLabel = document.createElement('label')
	newLabel.classList.add("fs-5","fw-bold")
	newLabel.textContent = 'Question *'

	const removeBtn = document.createElement('i')
	removeBtn.classList.add("float-end","fas", "fa-times","mr-2","remove_btn","text-danger","fs-3")

	const newSelect = document.createElement('select')
	newSelect.classList.add("form-select","rounded-0")
	newSelect.name="questions[]"

	const staticOption = document.createElement('option')
	staticOption.setAttribute('selected','selected')
	staticOption.setAttribute('disabled','disabled')
	staticOption.textContent = 'Select Question'

	newSelect.appendChild(staticOption)

	for(const question of questions) {
		const newOption = document.createElement('option')
		newOption.value = question.id
		newOption.textContent = question.field_name

		newSelect.appendChild(newOption)
	}

	newColFormGroup.appendChild(newLabel)
	newColFormGroup.appendChild(removeBtn)
	newColFormGroup.appendChild(newSelect)
	newColDiv.appendChild(newColFormGroup)
	newRow.appendChild(newColDiv)
	form_body.appendChild(newRow)
}

const removeElementsByClass = function(className) {
	const elements = document.getElementsByClassName(className);
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
}

add_question_btn.addEventListener('click',addQuestions)

$(document).on('click','.remove_btn', function () {
	const element_row = $(this).parent().parent().parent()
	element_row.remove();
})