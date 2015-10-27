var idleTime = 0;
$(document).ready(function(){
	//Increment idleTime every minute
	setInterval(idleTimer, 1000);
	
    //Reset idle time on mouse movement or keypress.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function idleTimer() {
	idleTime = idleTime + 1;
	if (idleTime >= 10) {
		//Logout user
		$.ajax({
			type:'post',
			async:false,
			url:"php/main.php",
			data: {action: "idle"},
			success: function(data) {
				var json = jQuery.parseJSON(data);
				alert(json["errorMsg"]);
			}
		});
		window.location.href = 'index.html';
	}
}