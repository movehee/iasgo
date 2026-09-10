(function($) {

    $.jPopup = function(message, errorLevel, callback, options, buttons) {
        var defaults = {
            message: message,
            errorLevel: errorLevel,
            wrapperClass: "jpopup",
            show: "drop",
            minHeight: 5
        };
        options = $.extend(defaults, options);

        var dialogCSS = "ui-state-error";
        var iconCSS = " ui-icon-alert";
		
        switch (options.errorLevel) {
            case "highlight":
				
                dialogCSS = " ui-state-highlight";
                iconCSS = "  ui-icon-notice";

                break;

            case "error":
		
                dialogCSS = " ui-state-error";
                iconCSS = " ui-icon-alert";

                break;

            default:

                dialogCSS = "";
                iconCSS = " ui-icon-notice";

                break;
        }

        var dialog = $("<table style='background:#ffffff;border:0px;'><tr><th valign=\"middle\" style=\"background:#ffffff;border:0px;\"><img src='/image/header_logo.png' width='50'></th><td class=\"" + dialogCSS + "\" style=\"border: none; background: transparent;color:#000000;background-color:#ffffff;font-size:14px;\" valign=\"middle\">" + options.message + "</td></tr></table>");

        var dialogOptions = {
            bgiframe: true,
            dialogClass: options.wrapperClass + dialogCSS,
            resizable: false,
            minHeight: options.minHeight,
            modal: true,
            buttons: buttons,
            close: function(event, ui) {
                dialog.remove();
            }
        }
        options = $.extend(dialogOptions, options);
		
        dialog.dialog(options);
    };

    $.jConfirm = function(message, errorLevel, callback, options) {
        var buttons = {
            'OK': function() {
				
                $(this).dialog('close');
                if (callback) {
                    callback(true);
                }
				$('#body').removeClass("overHidden");
            },
            Cancel: function() {
                $(this).dialog('close');
				
                if (callback) {
                    callback(false);
                }
				$('#body').removeClass("overHidden");
            }
			
        };

        $.jPopup(message, errorLevel, callback, options, buttons);
    };

    $.jAlert = function(message, errorLevel, callback, options) {
		
        var buttons = {
            'OK': function() {
                $(this).dialog('close');
//				$(this).css('background-color:red');
				$(this).attr('style','background:red;');
                if (callback) {
                    callback(true);
                }
				$('#body').removeClass("overHidden");
            }
        };
        $.jPopup(message, errorLevel, callback, options, buttons);
		
    };
})(jQuery);