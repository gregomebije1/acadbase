<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
 <meta http-equiv="content-type" content="text/html; charset=UTF-8">
 <title>Javascript Modal Dialog Tutorial</title>
 <style type="text/css"> 
 #modalBackground 
 {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
 
	z-index: 9;
	background-color:#333333;
	display: none;
	opacity: 0.40;
	filter: alpha(opacity=40)
 }
 #modalWindow
 {
    position: fixed;
    left: 0;
    top: 0;
 
	z-index: 10;
	background-color: white;
	display: none;
	width: 20em;
	height: 10em;
	border: 1px solid blue;
 }
 </style>
 
 <!--[if gte IE 5.5]>
 <![if lt IE 7]>
 <style>
 #modalBackground, #modalIframe
 {    
	position: absolute;
    left: expression(ignoreMe = document.documentElement.scrollLeft + "px");
    top: expression(ignoreMe = document.documentElement.scrollTop + "px");
    width: expression(document.documentElement.clientWidth + "px");
    height: expression(document.documentElement.clientHeight + "px");
 }
 
 #modalIframe
 {
	filter: alpha(opacity=0);
	z-index: 8;
 }
 
 #modalWindow
 {
	position: absolute;
    left: expression(ignoreMe = document.documentElement.scrollLeft + "px");
    top: expression(ignoreMe = document.documentElement.scrollTop + "px");
 }
 </style>
 <![endif]>
 <![endif]-->
</head>
<body>
   <select id="hideType">
    <option value="replace">Replace Selects</option>
	<option selected="selected" value="iframe">Use Iframe</option>
	<option value="none">None</option>
   </select> 
   
   <iframe id="modalIframe" style="display: none;" src="javascript:false;" scrolling="no" frameborder="0"></iframe>
   <div style="display: none; left: 500.5px; top: 254.5px;" id="modalWindow">Click here to make this go away.</div>
   <div style="display: none;" id="modalBackground"></div>
 
    <script type="text/javascript">
//<![CDATA[
 
document.ondblclick = OnDocumentDblClick;
$('modalWindow').onclick = OnModalWindowClick;
 
var _rulesAdded = false;
 
function OnDocumentDblClick()
{
	$('modalWindow').style.display = $('modalBackground').style.display = 'block';
 
	// special < IE7 -only processing for windowed elements, like select	
	if (window.XMLHttpRequest == null)
	{
		var type = $('hideType').value;
		
		if (type == 'iframe')
			$('modalIframe').style.display = 'block';
		if (type == 'replace')
			ReplaceSelectsWithSpans();
	}
 
	// call once to center everything
	OnWindowResize();
	
	if (window.attachEvent)
		window.attachEvent('onresize', OnWindowResize);
	else if (window.addEventListener)
		window.addEventListener('resize', OnWindowResize, false);
	else
		window.onresize = OnWindowResize;
	
	// we won't bother with using javascript in CSS to take care
	//   keeping the window centered
	if (document.all)
		document.documentElement.onscroll = OnWindowResize;
}
 
function OnWindowResize()
{
	// we only need to move the dialog based on scroll position if
	//   we're using a browser that doesn't support position: fixed, like < IE 7
	var left = window.XMLHttpRequest == null ? document.documentElement.scrollLeft : 0;
	var top = window.XMLHttpRequest == null ? document.documentElement.scrollTop : 0;
	var div = $('modalWindow');
	
	div.style.left = Math.max((left + (GetWindowWidth() - div.offsetWidth) / 2), 0) + 'px';
	div.style.top = Math.max((top + (GetWindowHeight() - div.offsetHeight) / 2), 0) + 'px';
}
 
function OnModalWindowClick()
{
	$('modalWindow').style.display = $('modalBackground').style.display = 'none';
	
	// special IE-only processing for windowed elements, like select	
	if (document.all)
	{
		var type = $('hideType').value;
		
		if (type == 'iframe')
			$('modalIframe').style.display = 'none';
		if (type == 'replace')
			RemoveSelectSpans();
	}
	
	if (window.detachEvent)
		window.detachEvent('onresize', OnWindowResize);
	else if (window.removeEventListener)
		window.removeEventListener('resize', OnWindowResize, false);
	else
		window.onresize = null;
}
 
/* These functions deal with IE's retardedness in not allowing divs to 
 * cover select elements by replacing the select elements with spans. */
 
function RemoveSelectSpans()
{
	var selects = document.getElementsByTagName('select');
	
	for (var i = 0; i < selects.length; i++)
	{
		var select = selects[i];
		
		if (select.clientWidth == 0 || select.clientHeight == 0 || 
			select.nextSibling == null || select.nextSibling.className != 'selectReplacement')
		{
			continue;
		}
			
		select.parentNode.removeChild(select.nextSibling);
		select.style.display = select.cachedDisplay;
	}
}
 
function ReplaceSelectsWithSpans()
{
	var selects = document.getElementsByTagName('select');
	
	for (var i = 0; i < selects.length; i++)
	{
		var select = selects[i];
		
		if (select.clientWidth == 0 || select.clientHeight == 0 || 
			select.nextSibling == null || select.nextSibling.className == 'selectReplacement')
		{
			continue;
		}
			
		var span = document.createElement('span');
		
		// this would be "- 3", but for that appears to shift the block that contains the span 
		//   one pixel down; instead we tolerate the span being 1px shorter than the select
		span.style.height = (select.clientHeight - 4) + 'px';
		span.style.width = (select.clientWidth - 6) + 'px';
		span.style.display = 'inline-block';
		span.style.border = '1px solid rgb(200, 210, 230)';
		span.style.padding = '1px 0 0 4px';
		span.style.fontFamily = 'Arial';
		span.style.fontSize = 'smaller';
		span.style.position = 'relative';
		span.style.top = '1px';
		span.className = 'selectReplacement';
		
		span.innerHTML = select.options[select.selectedIndex].innerHTML + 
			'<img src="custom_drop.gif" alt="drop down" style="position: absolute; right: 1px; top: 1px;" />';
		
		select.cachedDisplay = select.style.display;
		select.style.display = 'none';
		select.parentNode.insertBefore(span, select.nextSibling);
	}
}
 
/* The following two functions are not used, but have been kept here because 
 *   they might be useful; one must use this method to programmatically add
 *   javascript-valued CSS values (using element.style.div = expresssion(...)
 *   does not work).  These are only useful for IE.
 */
 
function AddStyleRules()
{
	if (_rulesAdded)
		return;
		
	_rulesAdded = true;
 
	var stylesheet = document.styleSheets[document.styleSheets.length - 1];
	
	if (!document.all)
	{
		InsertCssRule(stylesheet, '#modalBackground', 'position: fixed; height: 100%; width: 100%; left: 0; top: 0;');		
		InsertCssRule(stylesheet, '#modalWindow', 'position: fixed; left: 0; top: 0;');		
	}
	else
	{
		InsertCssRule(stylesheet, '#modalBackground', 
			'position: absolute; ' +
			'left: expression(ignoreMe = document.documentElement.scrollLeft + "px"); ' +
			'top: expression(ignoreMe = document.documentElement.scrollTop + "px");' +
			'width: expression(document.documentElement.clientWidth + "px"); ' +
			'height: expression(document.documentElement.clientHeight + "px");');
 
		InsertCssRule(stylesheet, '#modalWindow', 
			'position: absolute; ' +
			'left: expression(ignoreMe = document.documentElement.scrollLeft + "px"); ' +
			'top: expression(ignoreMe = document.documentElement.scrollTop + "px");');
 
	}
}
 
function InsertCssRule(stylesheet, selector, rule)
{
	if (stylesheet.addRule)
	{
		stylesheet.addRule(selector, rule, stylesheet.rules.length);
		return stylesheet.rules.length - 1;
	}
	else
	{
		stylesheet.insertRule(selector + ' {' + rule + '}', stylesheet.cssRules.length);
		return stylesheet.cssRules.length - 1;
	}
}
 
 
 
/* utiltiy functions */
 
function GetWindowWidth()
{
	var width =
		document.documentElement && document.documentElement.clientWidth ||
		document.body && document.body.clientWidth ||
		document.body && document.body.parentNode && document.body.parentNode.clientWidth ||
		0;
		
	return width;
}
 
function GetWindowHeight()
{
    var height =
		document.documentElement && document.documentElement.clientHeight ||
		document.body && document.body.clientHeight ||
  		document.body && document.body.parentNode && document.body.parentNode.clientHeight ||
  		0;
  		
  	return height;
}
 
function $(id)
{
	return document.getElementById(id);
}
//]]>
    </script>
 
</body></html>
