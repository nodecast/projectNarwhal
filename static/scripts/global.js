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
		var history = eval($("#ratiohistory").text());

		var r = Raphael("ratiograph");

		if (history.length >= 21) {
			var ratiovals = [];
			var reqratiovals = [];
			for (var i = history.length - 1; i >= 0; i--) {
				ratiovals.push(history[i][0]);
				reqratiovals.push(history[i][1]);
			}

			r.linechart(30,10,150,155,[[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]],[ratiovals, reqratiovals], {axis:"0 0 1 1", smooth: true, miny: 0, shade: false});
		} else {
			var text = r.text(100, 20, "Not enough ratio history!");
			text.scale(1.25, 1.25);

			r.path("M10,30L180,180").attr("stroke", "#FF0000").attr("stroke-width", "3");
			r.path("M180,30L10,180").attr("stroke", "#FF0000").attr("stroke-width", "3");
		}
	}
});
