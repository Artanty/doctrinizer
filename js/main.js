function getTemplate(url) {
	return new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		xhr.open("GET", url);
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
		xhr.send();
	});
}

/**
 * Конвертирует значения динамических инпутов с повторяющимися name 
 * в массив c массивами объектов
 *
 * @param {string} className
 * @return {number} 6
 */
function getArrOfSameNamesDynamicInputs(className, rowLength) {
	var className = 'entityItemsFormInput'
	var bigArr = []
	var smallArr = []
	let ii = 0
	let iii = 0
	var inputs = Array.prototype.slice.call(document.getElementsByClassName(className));
	inputs.forEach((el,i) => {
		i++
		smallArr[iii] = Object.assign({[el.name]: el.value})
		// iii++
		// if (el.name === 'T_entityVarName_T') {
		// 	const entVarType = el.value.charAt(0).toUpperCase() + el.value.substring(1) // todo
		// 	smallArr[iii] = Object.assign({'T_entityVarType_T': entVarType})
		// }
		iii++
		if(i % rowLength === 0){
			bigArr[ii] = [...smallArr]
			ii++
			iii = 0
			smallArr.lenght = 0
		}
	})
	return bigArr
}


function fillTemplateFromArray (inputArray, text){
	inputArray.forEach((el, i) => {
		text = text.replace(new RegExp(Object.keys(el), 'g'), Object.values(el));
	});
	return text
}

function fillTemplateFromArrayOfObjects (inputs, text) {
	inputs.forEach(input => {
		text = text.replace(new RegExp(input.name, 'g'), input.value)
    })
    return text
}

function getInputsArr (className) {
	let result = []
	const inputsArr = document.getElementsByClassName(className)
	let classLowerCase
	let classes
	Array.prototype.forEach.call(inputsArr, function(input, i) {
		result[i] = { name: input.name, value: input.value }
		if (input.name === 'T_Class_T') {
			classLowerCase = input.value.charAt(0).toLowerCase() + input.value.substring(1);
			if (input.value.charAt(input.value.length-1) === 'y') {
				classes = classLowerCase.slice(0,-1) + 'ies'
			} else {
				classes = classLowerCase + 's'
			}
		}
    })
    result.push({ name: 'T_class_T', value: classLowerCase })
    
    result.push({ name: 'T_classes_T', value: classes })
    
    return result
}

/**
 * Показывает полученный текст файла в pre-контейнере
 *
 * @param string fileContent переменная с контентом
 */
function showResult ( fileContent) {
	const container = document.getElementById('resultContainer')
	const textNode = document.createTextNode(fileContent);
	container.innerHTML = "";
    container.appendChild(textNode); 
}

/**
 * Вставляем в шаблон значения из формы
 *
 * @param string templateItem with placeholders
 * @param array of arrays [input row] of objects {placeholder: value} itemsFromForm
 * @return string
 */
function fillItems (templateItem, itemsFromForm) {
	var entityItemsArr = []
	itemsFromForm.forEach((value, i) => {
		entityItemsArr[i] = fillTemplateFromArray(value, templateItem)
	})
	const str = entityItemsArr.join("\n")
    return str
}

//подставляет нужный метод в строки свойств определенных CRUD-методов
function buildMethodsWithItems (input_G_mainForm, Method) {
	let G_mainFormForMethod = [...input_G_mainForm]

	G_mainFormForMethod.push({ name: 'T_Method_T', value: Method })

	const methodLowerCase = Method.charAt(0).toLowerCase() + Method.substring(1)
	G_mainFormForMethod.push({ name: 'T_method_T', value: methodLowerCase })

	return G_mainFormForMethod
	
}

/**
 * (Replace Class) Заменяет T_Class_T на ClassName
 *
 * @param string template
 * @param string ClassName
 * @return string
 */
function rC (template, ClassName) {
	template = template.replace(new RegExp('T_Class_T', 'g'), ClassName)
	return template
}