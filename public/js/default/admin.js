(function($) {
	var jspath = $('script').last().attr('src');
	var basepath = '';
	if (jspath.indexOf('/') != -1) {
		basepath += jspath.substr(0, jspath.lastIndexOf('/') + 1);
	}
	$.fn.fixpng = function(options) {
		function _fix_img_png(el, emptyGIF) {
			var images = $('img[src*="png"]', el || document),
				png;
			images.each(function() {
				png = this.src;
				width = this.width;
				height = this.height;
				this.src = emptyGIF;
				this.width = width;
				this.height = height;
				this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + png + "',sizingMethod='scale')";
			});
		}
		function _fix_bg_png(el) {
			var bg = $(el).css('background-image');
			if (/url\([\'\"]?(.+\.png)[\'\"]?\)/.test(bg)) {
				var src = RegExp.$1;
				$(el).css('background-image', 'none');
				$(el).css("filter", "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "',sizingMethod='scale')");
			}
		}
		if ($.browser.msie && $.browser.version < 7) {
			return this.each(function() {
				var opts = {
					scope: '',
					emptyGif: basepath + 'blank.gif'
				};
				$.extend(opts, options);
				switch (opts.scope) {
					case 'img':
						_fix_img_png(this, opts.emptyGif);
						break;
					case 'all':
						_fix_img_png(this, opts.emptyGif);
						_fix_bg_png(this);
						break;
					default:
						_fix_bg_png(this);
						break;
				}
			});
		}
	}
})(jQuery);

function mhover(dom, cs) {
	if (dom) dom.hover(function() {
			$(this).addClass(cs);
		},
		function() {
			$(this).removeClass(cs);
		});
}
function cknav(d) {
	if (d instanceof jQuery) {
		if (d.attr("id") != 'top_quick_a') {
			$('#topnav a').removeClass("onnav");
			d.addClass("onnav");
			$("ul[id^='ul_']").hide();
			var u = String(d.attr('id'));
			u = u.split('_');
			u = u[1];
			$.cookie('conav', null);
			$.cookie('conav', u, {
				path: '/'
			});
			$("#ul_" + u).show();
			u = $("#ul_" + u).find('li a').eq(0);
			frameget(u);
		}
	} else {
		cknav($('#nav_' + d));
	}
}
function frameget(u) {
	if (u.attr('target')) {
		if (u.attr('target') == '_blank') return false;
		$("#leftnav a").removeClass("on");
		$("#main").attr("src", u.attr('href'));
		$("#main").src = $("#main").src;
		u.addClass("on");
		var l = u.attr('id');
		l = l.split('_');
		$.cookie('coul', null);
		$.cookie('coul', l[2], {
			path: '/'
		});
	}
}
function dheight() {
	var d = $(document).height();
	//var d = $('body').height();
	d = d - 15;
	$('#metcmsbox').height(d);
	var l = d - 77;
	//var m = $("#main").contents().find("body").height();
	//l = m > l ? m: l;
	//if (m < 700 && l > 700) l = 700;
	$('#metleft').height(l);
	$('#metright').height(l);
	$('#main').height(l);
	//$('#main').height(l);
	$('#toggleIcon').height(l);
	//var n = l - 10 - 25 - 35;
	//$('#leftnav').height(n);
}

var conav = $.cookie('conav');
var coul = $.cookie('coul');
if (conav) {
	cknav(conav);
	if (coul) frameget($('#nav_' + conav + '_' + coul));
} else {
	var conavIdStr = $("#topnav").children().first().attr('id');
	conavArr = conavIdStr.split('_');
	cknav(conavArr[1]);
}
$("#main").load(function() {
	dheight();
});
$('#topnav a').click(function() {
	cknav($(this));
});
$("#leftnav a").click(function() {
	frameget($(this));
});

$('#mydata').click(function() {
	$.cookie('conav', 7);
	$.cookie('coul', 48);
});

$('#outhome').click(function() {
	$.cookie('conav', null);
	$.cookie('clang', null);
});


$('.top-right-boxr .dropdown').hover(function() {
	$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
	$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});
$("#toggleIcon").on('click', function() {
	if ($("#metleft").is(":visible")) {
		$("#metleft").hide();
		$("#content .floatr .iframe").css("margin-left", "10px");
		$("#toggleIcon").removeClass('toggleIconOpen').addClass('toggleIconClose');
	} else {
		$("#metleft").show();
		$("#content .floatr .iframe").css("margin-left", "160px");
		$("#toggleIcon").removeClass('toggleIconClose').addClass('toggleIconOpen');
	}
})