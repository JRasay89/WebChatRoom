$(document).ready(function(){
	checkSession();
});

function checkSession() {
	//Check if session is set
	$.post("php/main.php",{action: "getSession"}, function(data) {
		var json = jQuery.parseJSON(data);
		//If session is set, check if session has expired
		if (json["success"] == true) {
			var uid  = json["uid"];
			var username = json["username"];
			//alert("uid: " + uid + " username: " + username);
			$.post("php/main.php",{action: "verifySession", uid: uid, username: username}, function(data) {
				json = jQuery.parseJSON(data);
				//If session has not expired, log user back in
				if (json["success"] == true) {
					//alert("Session not expired.");
					window.location.href = 'chat_room.html';
				}
				else {
					alert(json["errorMsg"]);
					$.post("php/main.php",{action: "deleteSession"});
				}
			});
		}
		else {
			console.log(json["errorMsg"]);
		}		
	});
}