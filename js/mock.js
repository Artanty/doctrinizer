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

function mockEntityInputsMass (mockInputRowData) {
	// const mockInputRowData = 
	// [
	// 	[
	// 		{T_entityColumnDesc_T: 'Слов222а1'},
	// 		{T_entityVarType_T: 'string'},
	// 		{T_entityColumnType_T: 'string'},
	// 		{T_entityColumnName_T: 'value'},
	// 		{T_entityColumnNull_T: 'true'},
	// 		{T_entityVarName_T: 'value'}
	// 	],
	// 	[
	// 		{T_entityColumnDesc_T: 'Слова2111'},
	// 		{T_entityVarType_T: 'string'},
	// 		{T_entityColumnType_T: 'string'},
	// 		{T_entityColumnName_T: 'value2'},
	// 		{T_entityColumnNull_T: 'true'},
	// 		{T_entityVarName_T: 'value2'}
	// 	]
	// ]
	mockInputRowData.forEach((el, i) => {
		let itemClass = document.getElementsByClassName('row_' + i)
		Array.prototype.forEach.call(itemClass, function(input, i2) {
			input.setAttribute("value", Object.values(mockInputRowData[i][i2])[0])
	    })
	    if (i+1 < mockInputRowData.length) {
			addEntityItemRow()
	    }
	})
}

const apiKey = '$2b$10$SU0HWnuoYolbM9jXGcV85uM6N5L/VOOavCZzeibovAJRp8EkySrSW'
const collectionId = '60faf610a263d14a297ad80b'

function getMainForm () {
	return getInputsArr('entityMainDataFormInput') // G_mainForm
}
function getSchema () {
	return getArrOfSameNamesDynamicInputs('entityItemsFormInput', 6) // G_itemsForm
}

function saveBinToCollectionApi(){

	const json = {
		main: getMainForm(),
		items: getSchema()
	}

	let req = new XMLHttpRequest();

	req.onreadystatechange = () => {
	  if (req.readyState == XMLHttpRequest.DONE) {
	    console.log(req.responseText);
	  }
	};
	  
	req.open("POST", "https://api.jsonbin.io/v3/b", true);
	req.setRequestHeader("Content-Type", "application/json");
	req.setRequestHeader("X-Master-Key", apiKey);
	req.setRequestHeader("X-Collection-Id", collectionId);
	
	req.send(JSON.stringify(json));
}

function createCollectionApi () {
	let req = new XMLHttpRequest();

	req.onreadystatechange = () => {
	  if (req.readyState == XMLHttpRequest.DONE) {
	    console.log(req.responseText);
	  }
	};

	req.open("POST", "https://api.jsonbin.io/v3/c", true);
	req.setRequestHeader("X-Collection-Name", "Doctrinizer");
	req.setRequestHeader("X-Master-Key", apiKey);
	req.send();
}
hiddenBodies = []
collectionList = document.getElementById('collectionList')

function getCollectionApi () {
	let req = new XMLHttpRequest();

	req.onreadystatechange = () => {
	  if (req.readyState == XMLHttpRequest.DONE) {
	    // console.log(req.responseText);
	    res = JSON.parse(req.responseText)
	    res.forEach(el => {
	    	console.log(el)
	    	getBin(el.record).then(binContent => {
	    		console.log(binContent)
	    		// hiddenBodies.push(binContent)
	    		let item = JSON.parse(binContent)
	    		hiddenBodies.push(item)
	    		let a = document.createElement('a');
				a.setAttribute('class', 'collectionListItem')
				a.setAttribute('itemId', item.metadata.id)
				a.innerHTML = item.record.main[0]['value']
	    		collectionList.append(a)
	    	})
	    })
	  }
	};

	req.open("GET", "https://api.jsonbin.io/v3/c/" + collectionId + "/bins", true);
	req.setRequestHeader("X-Master-Key", apiKey);
	req.send();
}


document.body.addEventListener('click', function (event) {
    if (event.target.className === 'collectionListItem') {
    	const itemId = event.target.getAttribute('itemId')
    	const elem = hiddenBodies.find(el => el.metadata.id === itemId)
		mockEntityInputsMass(elem.record.items)
    }
}, false);

// function getOneBin () {
// 	let req = new XMLHttpRequest();

// 	req.onreadystatechange = () => {
// 	  if (req.readyState == XMLHttpRequest.DONE) {
// 	    console.log(req.responseText);
// 	  }
// 	};

// 	req.open("GET", "https://api.jsonbin.io/v3/b/<BIN_ID>/<BIN_VERSION | latest>", true);
// 	req.setRequestHeader("X-Master-Key", "<YOUR_API_KEY>");
// 	req.send();
// }

function getBin(binId) {
	return new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		xhr.open("GET", "https://api.jsonbin.io/v3/b/" + binId);
		xhr.setRequestHeader("X-Master-Key", apiKey);
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
		xhr.send();
	});
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
// note
// 60fade6e99892a4ae9a8c3df
// collection
//60faf610a263d14a297ad80b


// https://jsonbin.io/api-reference/v3/bins/read

// доделать 
// 1 вставку из загруженного массива в MainForm
// 2 удаление рядов перед вставкой новых