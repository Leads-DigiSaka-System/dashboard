'use strict'
const form_body = document.getElementById('form-body')

const field_type = document.getElementById('field_type')
const sub_field_type = document.getElementById('sub_field_type')
const sub_field_type_label = document.getElementById('sub_field_type_label')
const conditional = document.getElementById('conditional')

const add_option_btn = document.getElementById('add_option_btn')

const addOptions = function () {
	const newRow = document.createElement("div")
	newRow.classList.add("row","mb-1","additional_option")

	const newCol = document.createElement("div")
	newCol.classList.add("col-sm-7", "offset-sm-3")

	const newFormInput = document.createElement("div")
	newFormInput.classList.add("input-group")

	const newSpan = document.createElement("span")
	newSpan.classList.add("input-group-text","rounded-0")

	const newTag = document.createElement("i")
	newTag.classList.add("fas","fa-list","mr-2")
	newSpan.appendChild(newTag)

	const newInput = document.createElement("input")
	newInput.classList.add("form-control","rounded-0")
	newInput.type = "text"
	newInput.name = "sub_field_type[]"

	newFormInput.appendChild(newSpan)
	newFormInput.appendChild(newInput)

	const newRemoveDiv = document.createElement("div")
	newRemoveDiv.classList.add("col-sm-1","d-flex","align-items-center")

	const newRemoveSpan = document.createElement("i")
	newRemoveSpan.classList.add("fas", "fa-times","mr-2","remove_btn","text-danger")

	newRemoveDiv.appendChild(newRemoveSpan)

	newCol.appendChild(newFormInput)
	

	newRow.appendChild(newCol)
	newRow.appendChild(newRemoveDiv)
	form_body.appendChild(newRow)
}

const removeElementsByClass = function(className) {
	const elements = document.getElementsByClassName(className);
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
}

$('#field_type').on('change', function() {
	const value = this.value
	let html = ""

	if(value == 'Checkbox' || value == 'Radio Button' || value == 'Dropdown' || value == 'Ratings') {
		sub_field_type_label.textContent = 'Choices *'

		add_option_btn.classList.remove('d-none')

		html = `<div class="input-group">
		    	<span 
		    	class="input-group-text rounded-0">
			    	<i class="fas fa-list mr-2"></i>
			    </span>
		      <input 
		      type="text" 
		      name="sub_field_type[]" 
		      class="form-control rounded-0" 
		      id="sub_field_type">
		    </div>
			`

		$('#append_sub').parent().removeClass('d-none')
		$('#append_sub').html(html)
	} else if(value == 'Textbox') {
		sub_field_type_label.textContent = 'Sub-Field Type *'

		add_option_btn.classList.add('d-none')

		html = `<select 
			class="form-select rounded-0" 
			name="sub_field_type[]" 
			id="sub_field_type" 
			aria-label="Default select example">
				<option selected disabled>Select Sub-Field Type</option>
				<option value="Short Text">Short Text</option>
				<option value="Long Text">Long Text</option>
				<option value="Number">Number</option>
			</select>
			`

		removeElementsByClass('additional_option')

		$('#append_sub').parent().removeClass('d-none')
		$('#append_sub').html(html)

		$('#sub_field_type').select2()
	} else {
		add_option_btn.classList.add('d-none')
		removeElementsByClass('additional_option')
		$('#append_sub').parent().addClass('d-none')
		$('#append_sub').html("")
	}
})

add_option_btn.addEventListener('click',addOptions)

conditional.addEventListener('change', function () {
	//add_option_btn.classList.add('d-none')
	//removeElementsByClass('additional_option')
	//$('#append_sub').parent().addClass('d-none')
	//$('#append_sub').html("")
	if(this.checked) {
		document.querySelector('#question_list_div').classList.remove('d-none')
	} else {
		document.querySelector('#question_list_div').classList.add('d-none')

		document.querySelector('#questionnaire').selectedIndex = 0
	}
})

$(document).on('click','.remove_btn', function () {
	const element_row = $(this).parent().parent()

	element_row.remove();
})

$(".form-select").select2();
$(document).on('select2:open', () => {
	document.querySelector('.select2-search__field').focus();
});