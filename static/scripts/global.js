function scale(image) {
	if (image.width > 500) {
		image.height = Math.round(((500) / image.width) * image.height);
		image.width = 500;
		image.title = "Preview";
		image.setAttribute("onclick", "preview(this);");
	}
}

function preview(image) {
	$('#lightbox').html('<a onclick="unpreview();"><img src="' + image.src + '" /></a>');
	$('#curtain').show();
	$('#lightbox').show();
}

function unpreview() {
	$('#lightbox').hide();
	$('#curtain').hide();
	$('#lightbox').html('');
}

$(function() {
	$(".bbcode_spoiler_btn").each(function(idx, val) {
		$(this).on('click', function(e) {
			$(this).siblings(".bbcode_spoiler").toggle('fast');
		});
		$(this).siblings(".bbcode_spoiler").hide();
	});

	$(".post").each(function(idx, val) {
		var username = $($(".post .username")[idx]).text();
		var id = $(this).attr('data-id');

		$($(".post .quickpost")[idx]).on('click', function(e) {
			$.get('/ajax/getTorrentCommentBBCode/' + id.toString(), function(data) {
				$("#quickpost").val($("#quickpost").val()+'[quote='+username+']'+data+'[/quote]');
			});
		});
	});

	if ($('#ratiograph').length != 0) {
		var history = JSON.parse($("#ratiohistory").text());

		var r = Raphael("ratiograph");

		var timevals = [];
		var ratiovals = [];
		var reqvals = [];

		for (var i = history.length - 1; i >= 0; i--) {
			timevals.push((history[i].time - history[0].time) / (60*60*24));
			ratiovals.push(history[i].ratio);
			reqvals.push(history[i].required);
		};

		r.linechart(30, 10, 150, 155, [timevals, timevals], [ratiovals, reqvals], {axis:"0 0 1 1", miny: 0});
	}

	$('.blink').each(function() {
    var elem = $(this);
    setInterval(function() {
        if (elem.css('visibility') == 'hidden') {
            elem.css('visibility', 'visible');
        } else {
            elem.css('visibility', 'hidden');
        }    
    }, 500);
	});
});
