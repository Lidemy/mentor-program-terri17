	document.addEventListener("DOMContentLoaded", () => {
		document.querySelector(".listen").addEventListener("click", e => {
			console.log(e.target.className);
			if (e.target.className === "replyOldMessage_new"){
				if (e.target.innerText=== "新增留言▶"){
					e.target.innerText= "新增留言▼";
					e.target.nextElementSibling.style.display = 'block';
				}								
				else{
				e.target.innerText= "新增留言▼";
				e.target.nextElementSibling.style.display = 'none';		// display:none 可以用來隱藏物件			
				}
			} 
		})

		document.querySelector(".listen").addEventListener("click", e => {
			if (e.target.className === "edit_comment_input"){
				e.target.style.display = 'none';
				e.target.nextElementSibling.style.display = 'block';	// display:none 可以用來隱藏物件
			}								
		})

	})

