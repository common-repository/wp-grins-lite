jQuery(document).ready(function() {
var $j = jQuery;
$j.wpgrins = {
	grin: function(tag) {
		var myField;
		var value = '';
		if ($j('#content:input').length > 0)  {
			myField = $j('#content:input');
			value = $j("#content:input").attr("value");
			if ($j('#postdivrich') && typeof tinyMCE != 'undefined' && (!$j('#edButtons') || $j('#quicktags')[0].style.display == 'none')) {
				tinyMCE.execCommand('mceInsertContent', false, ' ' + tag + ' ');
				tinyMCE.execCommand('mceRepaint');
				return;
			}
		}
		else if ($j('#comment:input').length > 0) {
			myField = $j('#comment:input');
			value = $j("#comment:input").attr("value");
		}
		else {
			return false;
		}
		if (value == undefined) { value = ''; }
		if (document.selection) {
			myField.focus();
			sel = document.selection.createRange();
			sel.text = ' ' + tag + ' ';
			myField.focus();
		}
		else if (myField[0].selectionStart || myField[0].selectionStart == '0') {
			var startPos = myField[0].selectionStart;
			var endPos = myField[0].selectionEnd;
			var cursorPos = endPos;
			myField.attr("value", value.substring(0, startPos)
							+ ' ' + tag + ' '
							+ value.substring(endPos, value.length));
			cursorPos += tag.length + 2;
			myField.focus();
			myField[0].selectionStart = cursorPos;
			myField[0].selectionEnd = cursorPos;
		}
		else {
			myField.attr("value", value + ' ' + tag + ' ');
			myField.focus();
		}
	},
	init: function() {
		if (wpgrinslite.MANUAL == "true") { return; }
		var s = {};
		s.response = 'ajax-response';
		s.type = "POST";
		s.data = $j.extend(s.data, {action: 'grins'});
		s.global = false;
		s.url = wpgrinslite.Ajax_Url;
		s.timeout = 30000;
		s.success = function(r) {
			var grinsDiv = '<div id="wp_grins">'+r+'</div>';
			if ($j('#postdiv').length > 0) {
				var type = 'after';
				var node = $j('#postdiv');
			}	else if ($j('#postdivrich').length > 0) {
				var type = 'after';
				var node = $j('#postdivrich');
			} else if ($j('#comment').length > 0) {
				var type = 'before';
				var node = $j('#comment');
			}	else {
				return;
			}
			switch (type) {
				case 'after':
					node.after(grinsDiv);
					$j("#wp_grins").css("paddingTop", "5px");
					break;
				case 'before':
					node.before(grinsDiv);
					break;
			}
		} //end success
		$j.ajax(s);
	}
};
	$j.wpgrins.init();
});