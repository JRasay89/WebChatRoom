$(document).ready(function(){
	checkSession();
});

function checkSession() {
	$.post("php/session.php", function(data) {
		var json = jQuery.parseJSON(data);
		var uid_ = json["uid"];
		var user_ = json["username"];
		if (json["isset"] === true) {
			//If session is set and username has not expired, return user to the chatroom
			//alert("UID: " + json["uid"] + " Username: " + json["username"]);
			isSessionExists(uid_, user_);
		}
		else {
			console.log("no session found");
		}
	});
}


/*
 * Check if username ID for the session still exist
 * @param user is the name to be check
 */
 function isSessionExists(uid, user) {
	 $.post("php/checkSessionExists.php", {userID: uid, username: user}, function(data) {
		var json = jQuery.parseJSON(data);
		if (json["success"] === true) {
			//If session exists, then check if session has expired
			isSessionExpired(uid, user);
		}
		else {
			alert ("Session has expired!");
			deleteSession();
		}
	 });
 }
/*
 * Check if username for the session has expired
 * @param user is the name to be check
 */
function isSessionExpired(uid, user) {
	$.post("php/checkSessionExpired.php", {userID: uid, username: user}, function(data) {
		var json = jQuery.parseJSON(data);
		//If true, session has expired
		//else session is still active and sign in user
		if (json["success"] === true) {
			alert("Session has expired!");
			deleteSession();
		}
		else {
			//If session has not expired, login user to the chatroom
			alert("Session exists and has not expired!");
			window.location.href = 'chat_room.html';
		}
	});
}

function deleteSession() {
	$.post("php/deleteSession.php", function(data) {
	});
}