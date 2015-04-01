$(document).ready(function() {

    $('.collapse').on('show.bs.collapse', function() {
        var id = $(this).attr('id');
				var span = document.getElementById("span".concat(id.slice(-1)));
				span.innerHTML = '<i class="glyphicon glyphicon-minus"></i>';
    });
    $('.collapse').on('hide.bs.collapse', function() {
			var id = $(this).attr('id');
			var span = document.getElementById("span".concat(id.slice(-1)));
			span.innerHTML = '<i class="glyphicon glyphicon-plus	"></i>';
    });
});
