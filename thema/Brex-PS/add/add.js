
// add Read
function add_read(id) {

	$('#add-response-list').load(add_url + '/response.php?read=1&id=' + id);
	add_response();

	return false;
}

// add Response Count
function add_response() {

	var $labels = $('.addLabel');
	var $counts = $('.addCount');
	var $slabels = $('.sidebarLabel');
	var $scounts = $('.sidebarCount');
	var url = add_url + '/response.php?count=1';

	$.get(url, function(data) {
		if (data.count > 0) {
			$counts.text(number_format(data.count));
			$scounts.text(number_format(data.count));
			$labels.show();
			$slabels.show();
		} else {
			$labels.hide();
			$slabels.hide();
		}
	}, "json");
	return false;
}

// Response Auto Check
if(g5_is_member && add_time > 0) {
	setInterval(function() {
		add_response();
		$('#add-response-list').load(add_url + '/response.php');
	}, add_time * 1000); // Time = 1000ms ex) 10sec = 10 * 1000
}
