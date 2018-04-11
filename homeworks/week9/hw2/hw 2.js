var arr = []

var Stack = function() { 
	this.push=function(n){
		arr [arr.length] = n;
	},
	this.pop=function(){
		var last = arr[arr.length-1];
		var newArray = []
		for (var i=0; i<arr.length-1; i++){
			newArray [i] = arr [i];
		}
		arr = newArray;
		return last;
	}
}

var Queue = function() { 
	this.push=function(n){
		arr [arr.length] = n;
	},
	this.pop=function(){
		var first = arr[0];
		var newArray = []
		for (var i=1; i<arr.length; i++){
			newArray [i-1] = arr [i];
		}
		arr = newArray;
		return first;
	}
}


var stack = new Stack()	//先進後出
stack.push(10)
stack.push(5)
console.log(stack.pop()) // 5
console.log(stack.pop()) // 10


var queue = new Queue()	//先進先出
queue.push(1)
queue.push(2)
console.log(queue.pop()) // 1
console.log(queue.pop()) // 2
