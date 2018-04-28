export const capitalize = (str) => {
 	var new_str=str.toUpperCase()
	new_str=new_str.charAt(0)+str.slice(1)
  return new_str;
}

/*
首字母大寫
給定一字串，把第一個字轉成大寫之後回傳，若第一個字不是英文字母則忽略。

input: nick
output: Nick

input: Nick
output: Nick

input: ,hello
output: ,hello


function alphabet(n){
	var new_n=n.toUpperCase()
	n=new_n.charAt(0)+n.slice(1)
	return n;
}
*/

