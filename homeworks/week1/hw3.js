export const isPrime = (n) => {
	if(n===1)
		return false;
	for(var i=2; i<n; i++){
		if(n%i===0)
			return false;
	}
	return true;
}

/*
hw3：判斷質數
給定一個數字 n（1<=n<=100000），請回傳 n 是否為質數（質數的定義：除了 1 以外，所有小於他的數都無法整除）

n = 2 => true
n = 3 => true
n = 10 => false
n = 37 => true
n = 38 => false


function prime (n){
	if(n===1)
		return false;
	for(var i=2; i<n; i++){
		if(n%i===0)
			return false;
	}
	return true;
}


console.log ("n = 2 => " + prime(2));
console.log ("n = 3 => " + prime(3));
console.log ("n = 10 => " + prime(10));
console.log ("n = 37 => " + prime(37));
console.log ("n = 38 => " + prime(38));
*/