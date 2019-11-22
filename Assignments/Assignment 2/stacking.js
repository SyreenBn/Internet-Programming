function toTop(id){
	document.getElementById("calanderImage").src = id+".jpg"
}

function valForm() {
			var nameval1 = document.forms["myForm"]["eventname"].value;
			var nameval2 = document.forms["myForm"]["location"].value;
			if ((/^[0-9a-zA-Z]+$/.test(nameval1)) && (/^[0-9a-zA-Z]+$/.test(nameval2)) == true ) {
				return true;
			}
			else {
				alert("Name and Location should consist of uppercase and/or lowercase characters only");
				return false;
			}
		}
function myFunction() {
	var text;
	var d = new Date();
	var n = ((d.getDay())-1);
    var x =   document.getElementById("myTable").rows[n].cells[1].children[0].innerHTML  
			+ document.getElementById("myTable").rows[n].cells[1].children[1].innerHTML + "   ||~~~||   " 
			+ document.getElementById("myTable").rows[n].cells[2].children[0].innerHTML  
			+ document.getElementById("myTable").rows[n].cells[2].children[1].innerHTML + "   ||~~~||   "
			+ document.getElementById("myTable").rows[n].cells[3].children[0].innerHTML  
			+ document.getElementById("myTable").rows[n].cells[3].children[1].innerHTML +"   ||~~~||   ";
    document.getElementById("demo").innerHTML = x;
}