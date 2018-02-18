function OpenMenuNode1(oThis)
{
	if (oThis.parentNode.className == '')
		oThis.parentNode.className = 'closemenu';
	else
		oThis.parentNode.className = '';
	return false;
}