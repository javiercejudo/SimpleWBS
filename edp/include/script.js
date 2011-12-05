$(document).ready(function() {
  $("#msj").hide().delay(100).slideDown().delay(1500).slideUp();
  $("#msj2").hide().delay(100).slideDown().delay(3000).slideUp();
  $("#msj3").hide().delay(100).slideDown().delay(1500).slideUp();
});

function validate_form(thisform) {
	with (thisform) {
	  if (validate_required(nombre,"Debe añadir un nombre")==false)
	  {nombre.focus();return false;}	  
	}
}

function validate_required(field,alerttxt){
	with (field){
		if (value==null||value=="") {
			alert(alerttxt);
			return false;
		}
		else {
			return true;
		}
	}
}

function borrar_paquete () {
	return confirm("¿Desea borrar el paquete y todos sus hijos? Esta operación no podrá ser desecha más adelante.");
}

function borrar_comentario () {
	return confirm("¿Desea borrar el comentario? Esta operación no podrá ser desecha más adelante.");
}

//======fade effect=====================================================
//crédito: http://www.switchonthecode.com/tutorials/javascript-tutorial-simple-fade-animation
//var TimeToFade  = 1000.0;

function fade(eid,TimeToFade)
{
  var element = document.getElementById(eid);
  if(element == null)
    return;
   
  if(element.FadeState == null)
  {
    if(element.style.opacity == null
        || element.style.opacity == ''
        || element.style.opacity == '1')
    {
      element.FadeState = 2;
    }
    else
    {
      element.FadeState = -2;
    }
  }
   
  if(element.FadeState == 1 || element.FadeState == -1)
  {
    element.FadeState = element.FadeState == 1 ? -1 : 1;
    element.FadeTimeLeft = TimeToFade - element.FadeTimeLeft;
  }
  else
  {
    element.FadeState = element.FadeState == 2 ? -1 : 1;
    element.FadeTimeLeft = TimeToFade;
    setTimeout("animateFade(" + new Date().getTime() + ",'" + eid + "'," + TimeToFade + ")", 33);
  }  
}

function animateFade(lastTick, eid,TimeToFade)
{  
  var curTick = new Date().getTime();
  var elapsedTicks = curTick - lastTick;
 
  var element = document.getElementById(eid);
 
  if(element.FadeTimeLeft <= elapsedTicks)
  {
    element.style.opacity = element.FadeState == 1 ? '1' : '0';
    element.style.filter = 'alpha(opacity = ' + (element.FadeState == 1 ? '100' : '0') + ')';
    element.FadeState = element.FadeState == 1 ? 2 : -2;
    return;
  }
 
  element.FadeTimeLeft -= elapsedTicks;
  var newOpVal = element.FadeTimeLeft/TimeToFade;
  if(element.FadeState == 1)
    newOpVal = 1 - newOpVal;

    newOpVal = newOpVal*1 + 0;
  element.style.opacity = newOpVal;
  element.style.filter = 'alpha(opacity = ' + (newOpVal*100) + ')';
 
  setTimeout("animateFade(" + curTick + ",'" + eid + "'," + TimeToFade + ")", 33);
}
