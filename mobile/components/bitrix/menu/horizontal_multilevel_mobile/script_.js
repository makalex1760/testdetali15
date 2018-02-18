var jshover = function()
{
	var menuDiv = document.getElementById("horizontal-multilevel-menu")
	if (!menuDiv)
		return;

	var sfEls = menuDiv.getElementsByTagName("li");
	for (var i=0; i<sfEls.length; i++) 
	{
		sfEls[i].ontouchstart=function()
		{
			this.className+=" jshover";
		}
		
	}
}

if (window.attachEvent) 
	window.attachEvent("onload", jshover);
