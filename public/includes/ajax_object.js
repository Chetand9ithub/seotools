var request = createXMLHttpRequest();
var request1 = createXMLHttpRequest();
var request2 = createXMLHttpRequest();
var request3 = createXMLHttpRequest();
var request4 = createXMLHttpRequest();

/*function makeObject()
{
	var x;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		x = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		x = new XMLHttpRequest();
	}
	return x;
}*/
function createXMLHttpRequest()
{
	var ua;
	if(window.XMLHttpRequest)
	{
		try
		{
			ua = new XMLHttpRequest();
		}
		catch(e)
		{
			ua = false;
		}
	}
	else if(window.ActiveXObject)
	{
		try
		{
			ua = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			ua = false;
		}
	}
	return ua;
}
