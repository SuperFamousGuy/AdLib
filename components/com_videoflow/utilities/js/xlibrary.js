//VideoFlow fallback utility
function showChoice(url, title, ok) {
	if (title === undefined) { title = 'Status message'; }
	if (ok === undefined) { ok = 'Okay'; }
	var ajax = new Ajax();
	ajax.responseType = Ajax.FBML;
	ajax.requireLogin = true;
	ajax.ondone = function(data) {
		dialog = new Dialog().showMessage(title, data, ok);
	}
	ajax.post(url);
} 
