function removeEntityItemRow(row)
{
	var fooId = "foo";
	var id = row.id.substring(3,row.id.length-1);
	for (i=1;i<=6;i++) {
		document.getElementById(fooId+id+i).remove();
	}
	document.getElementById(fooId+id+8).nextSibling.remove();
	document.getElementById(fooId+id+8).remove();
	x--
}

var x = 1;

function addEntityItemRow() {
	var formData = getArrOfSameNamesDynamicInputs('entityItemsFormInput', 6)
	formData = formData.flat()
	var itemClass = document.getElementsByClassName('entityItemsFormInput')
	Array.prototype.forEach.call(itemClass, function(input, i) {
		input.setAttribute("value", Object.values(formData[i])[0])
    }) //leave previous input rows filled

	var fooId = "foo";
	for (i=1; i<=6; i++) {
		//Create an input type dynamically.
		var element = document.createElement("input");
		//Assign different attributes to the element.
		element.setAttribute("type", fooId+x+i);
		element.setAttribute("id", fooId+x+i);
		element.setAttribute("class", "entityItemsFormInput");
		if(i==1){
			element.setAttribute("name", "T_entityColumnDesc_T");
			element.setAttribute("placeholder", "Описание");
		}
		if(i==2){
			element.setAttribute("name", "T_entityVarType_T");
			element.setAttribute("placeholder", "Тип переменной");
		}
		if(i==3){
			element.setAttribute("name", "T_entityColumnType_T");
			element.setAttribute("placeholder", "Тип столбца БД");
		}
		if(i==4){
			element.setAttribute("name", "T_entityColumnName_T");
			element.setAttribute("placeholder", "Имя столбца БД");
		}
		if(i==5){
			element.setAttribute("name", "T_entityColumnNull_T");
			element.setAttribute("placeholder", "IS NULL?");
		}
		if(i==6){
			element.setAttribute("name", "T_entityVarName_T");
			element.setAttribute("placeholder", "Имя переменной");
		}
		var foo = document.getElementById("fooBar");
		foo.appendChild(element);
		foo.innerHTML += ' ';
	}
	i++;


	var element = document.createElement("input");
	element.setAttribute("type", "button");
	element.setAttribute("value", "-");
	element.setAttribute("id", fooId+x+i);
	element.setAttribute("name", fooId+x+i);
	element.setAttribute("onclick", "removeEntityItemRow(this)");
	foo.appendChild(element);
	var br = document.createElement("br");
	foo.appendChild(br);
	x++;
	// console.log(x)
}

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
// public string $value;
// public int $customerId;
// public ?int $removed = null;
// public ?string $timestampTo = null;