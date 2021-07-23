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

function mockEntityInputsMass () {
	const mockInputRowData = 
	[
		[
			{T_entityColumnDesc_T: 'Слова1'},
			{T_entityVarType_T: 'string'},
			{T_entityColumnType_T: 'string'},
			{T_entityColumnName_T: 'value'},
			{T_entityColumnNull_T: 'true'},
			{T_entityVarName_T: 'value'}
		],
		[
			{T_entityColumnDesc_T: 'Слова2'},
			{T_entityVarType_T: 'string'},
			{T_entityColumnType_T: 'string'},
			{T_entityColumnName_T: 'value2'},
			{T_entityColumnNull_T: 'true'},
			{T_entityVarName_T: 'value2'}
		]
	]
	mockInputRowData.forEach((el, i) => {
		let itemClass = document.getElementsByClassName('row_' + i)
		Array.prototype.forEach.call(itemClass, function(input, i2) {
			input.setAttribute("value", Object.values(mockInputRowData[i][i2])[0])
	    })
	    if (i+1 < mockInputRowData.length) {
			addEntityItemRow()
	    }
	})
	const json = JSON.stringify(mockInputRowData);
	console.log(json)
	const dat = JSON.parse(json)
	console.log(dat)
	// url()
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