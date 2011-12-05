function validate_form(thisform) {
	with (thisform) {
	  if (validate_required(nombre,"Debe añadir un nombre")==false)
	  {nombre.focus();return false;}	  
	}
}
