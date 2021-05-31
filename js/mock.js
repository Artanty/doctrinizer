function mockEntityInputs () {
	const mockInputRowData = [
		{T_entityColumnDesc_T: 'Слова...'},
		{T_entityVarType_T: 'string'},
		{T_entityColumnType_T: 'string'},
		{T_entityColumnName_T: 'value'},
		{T_entityColumnNull_T: 'true'},
		{T_entityVarName_T: 'value'}
	] 

	let itemClass = document.getElementsByClassName('entityItemsFormInput')
	Array.prototype.forEach.call(itemClass, function(input, i) {
		input.setAttribute("value", Object.values(mockInputRowData[i])[0])
    }) 
}

function mockMainForm () {
	const mockMainFormData = [
		{ class: 'Gelendvagen' },
		{ description: 'This is a food'},
		{ tableName: 'MyEntities'}
	]
	let itemClass = document.getElementsByClassName('entityMainDataFormInput')
	Array.prototype.forEach.call(itemClass, function(input, i) {
		input.setAttribute("value", Object.values(mockMainFormData[i])[0])
    }) 
}