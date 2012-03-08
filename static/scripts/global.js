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
			$.get('http://localhost/ajax/getTorrentCommentBBCode/' + id.toString(), function(data) {
				$("#quickpost").append('[quote='+username+']'+data+'[/quote]');
			});
		});
	});
});