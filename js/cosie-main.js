if(document.querySelector('.participant')){
	console.log('participant');
	appendCountHolder();
	makeHeadersButtons();
	populateCertFields();
	pdfApprove();
}

function countWords(id){
	if(document.getElementById(id).value){
		populateCertFields()
		return document.getElementById(id).value.split(' ').length;
	} else {
		return 0;
	}
}


function appendCountHolder(){
	//const boxes = ['acf-field_605ded9481995', 'acf-field_605df51a632e1', 'acf-field_field_605df521632e2', 'acf-field_field_605df528632e3'];
	const boxes = document.querySelectorAll('.acf-input textarea')
	boxes.forEach((box) => {
	  let count = countWords(box.id)
	  makeCountHolder(box, count);	
	  box.addEventListener('input', () => {
	  	pdfApprove();
	    let counter = document.querySelector('#'+box.id+'counter')
	    counter.innerHTML = 'currently ' + countWords(box.id) + ' words<div class="">goal: 200-500 words</div>'
	    if (countWords(box.id) > 200 && countWords(box.id) < 500){
	    	counter.classList = 'ok word-counter'
	    } else {
	    	counter.classList = 'not-ok word-counter'
	    }
	  });
	});
}

function makeCountHolder(box, count){
	const parent = document.querySelector('#'+box.id).parentElement;
	const holder = document.createElement('div');
	holder.classList.add('word-counter');
	holder.id = box.id+'counter'
	 if (count > 200 && count < 500){
	    	holder.classList.add('ok')
	    } else {
	    	holder.classList.add('not-ok')
	    }
	holder.innerHTML = 'currently ' + count + ' words<div class="">goal: 200-500 words</div>'
	parent.appendChild(holder)
}

function makeHeadersButtons(){
	const headers = document.querySelectorAll('.acf-field-textarea .acf-label label')
	headers.forEach((box) => {
		box.addEventListener('click', () =>{
			let p = box.parentNode.parentNode.querySelectorAll('p')
			let text = box.parentNode.parentNode.querySelector('.acf-input')
			hideShow(p[1],text)
		})
	})

}

function hideShow(p,text){
	jQuery(".chosen").removeClass("chosen");
	p.classList.add('chosen');
	text.classList.add('chosen');
}

function populateCertFields(){
	let p1 = document.getElementById('acf-field_605ded9481995')
	let p2 = document.getElementById('acf-field_605df51a632e1')
	let p3 = document.getElementById('acf-field_605df528632e3')
	let p4 = document.getElementById('acf-field_605df521632e2')
	

	let destination1 = document.getElementById('input_3_1')
	let destination2 = document.getElementById('input_3_2')
	let destination3 = document.getElementById('input_3_3')
	let destination4 = document.getElementById('input_3_4')
	destination1.value = p1.value
	destination2.value = p2.value
	destination3.value = p3.value
	destination4.value = p4.value
}

function pdfApprove(){
	let okCounts = [];
	const boxes = document.querySelectorAll('.acf-input textarea')
	boxes.forEach((box) => {
	  let count = countWords(box.id)	
	  console.log(count) 
	  // box.addEventListener('input', () => {
	    if (countWords(box.id) > 200 && countWords(box.id) < 500){
	    	okCounts.push(box.id);
	    	checkCount(okCounts);
	    } else {
	    	checkCount(okCounts)
	    }
	  });
	//});
}

function checkCount(okCounts){
    const pdfButton = document.getElementById('gform_wrapper_3')
	if(okCounts.length >3){
		console.log('add?')
		pdfButton.classList.remove('hidden')
	} else {
		console.log('remove?')
	   pdfButton.classList.add('hidden')
	}
}
