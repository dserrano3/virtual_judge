$(document).ready(function() {

    $('.collapse').on('show.bs.collapse', function() {
        var id = $(this).attr('id');
       
				var span = document.getElementById(id);
				//alert(span);
				//span.innerHTML = '<i class="glyphicon glyphicon-minus"></i>';
				span.style.display = "block";
				span.style.visibility = "visible";
    });
    $('.collapse').on('hide.bs.collapse', function() {
			var id = $(this).attr('id');
			var span = document.getElementById(id);
			//span.innerHTML = '<i class="glyphicon glyphicon-plus	"></i>';
			span.style.display = "none";
			span.style.visibility = "invisible";
    });
});
