
export function zetStijl(nodeList, eigenschap, waarde){
	const l = nodeList.length;
	for (let i = 0; i < l; i++) {
		nodeList[i].style[eigenschap] = waarde;
	} 
}

export function actieInit(e, testKlasse){

	e.preventDefault();
	e.stopPropagation();

	return e.target.classList.contains(testKlasse) ? e.target : e.target.parentNode.classList.contains(testKlasse) ? e.target.parentNode : e.target.parentNode.parentNode;
}

const gereedschap = {
	zetStijl,
	actieInit
}
export default gereedschap;