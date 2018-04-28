export const stars = (n) => {
	var array =[];
	for(var i=1; i<=n; i++){
		var row='*';
		for(var j=1; j<i; j++){	
			row=row+'*';
		}
	console.log(row);
	array.push(row);
	}
	return array;
}


/*
給定 n（1<=n<=30），依照規律回傳正確圖形（每一行是一個陣列的元素）

n = 1
*
["*"]

n = 3
*
**
***
["*", "**", "***"]

n = 6
*
**
***
****
*****
******
["*", "**", "***", "****", "*****", "******"]
*/

/*
function stars(n){
	var array =[];
	for(var i=1; i<=n; i++){
		var row='*';
		for(var j=1; j<i; j++){	
			row=row+'*';
		}
	console.log(row);
	array.push(row);
	}
	return array;
}
*/

//console.log(stars(6));

