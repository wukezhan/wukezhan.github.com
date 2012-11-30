(function($){
	jQuery.cookie = function (key, value, options) {
	    // key and at least value given, set cookie...
	    if (arguments.length > 1 && String(value) !== "[object Object]") {
	        options = jQuery.extend({}, options);
	        if (value === null || value === undefined) {
	            options.expires = -1;
	        }
	        if (typeof options.expires === 'number') {
	            var days = options.expires, t = options.expires = new Date();
	            t.setDate(t.getDate() + days);
	        }
	        value = value+'';
	        return (document.cookie = [
	            encodeURIComponent(key), '=',
	            options.raw ? value : encodeURIComponent(value),
	            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
	            options.path ? '; path=' + options.path : '',
	            options.domain ? '; domain=' + options.domain : '',
	            options.secure ? '; secure' : ''
	        ].join(''));
	    }

	    // key and possibly options given, get cookie...
	    options = value || {};
	    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
	    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
	};
	if(!$.cookie('badget-github')){
	    url = 'https://api.github.com/legacy/user/search/wukezhan';
	    $.getJSON(url+"?callback=?", function(data){
	        var text = data['data']['users'][0]['followers_count'];
	        $('#github').find('.info').text(text);
	        $.cookie('badget-github', text, {expires: 7} );
	    });
	}else{
	    $('#github').find('.info').text($.cookie('badget-github'));
	}
})(window.jQuery);