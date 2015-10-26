$(document).ready(function(){
	$("#joinBtn").click(join);
});

function join() {
	var username = $("#username").val();
	//If input is empty or whitespace
	if (!username.trim()) {
		alert("Please enter a username");
	}
	else {
		$.post("php/main.php", {action: "join", username: username}, function(data) {
			var json = jQuery.parseJSON(data);
			if (json["success"] == true) {
				//set the session 
				$.post("php/main.php", {action: "setSession", uid: json["uid"], username: json["username"]});
				window.location.href = 'chat_room.html';
			}
			else {
				alert(json["errorMsg"]);
			}
		});		
	}
	return false;
}