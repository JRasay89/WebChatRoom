function join() {
	var user = $("#username").val();
	//If input is empty or whitespace
	if (!user.trim()) {
		alert("Please enter a username");
	}
	else {
		$.post("php/checkUserExists.php", {username: user}, function(data) {
			var json = jQuery.parseJSON(data);
			//Check if username exist
			if (json["exists"] === true) {
				//check if username has expired (if no activity for the last 10 mins or more)
				//if true delete old record and create new record
				isUserExpired(user);

			}

			//else create new record
			else {
				createUser(user);
			}
		});		
	}

}

/*
 * Check if username has expired
 * @param user is the name to be check
 */
function isUserExpired(user) {
	$.post("php/checkUserExpired.php", {username: user}, function(data) {
		var json = jQuery.parseJSON(data);
		if (json["expired"] === true) {
			//if expired delete old record
			deleteUser(user);
			//Create a new record
			createUser(user);
		}
		else {
			alert("Username is already in used!");
		}
	});
}

function deleteUser(user) {
	$.post("php/deleteUser.php", {username: user}, function(data) {
		var json = jQuery.parseJSON(data);
		if (!json["deleted"]) {
			alert("Could not delete user!");
		}
	});	
}

function createUser(user) {
	$.post("php/login.php", {username: user}, function(data) {
		var json = jQuery.parseJSON(data);
		if (json["success"] === true) {
			alert("Username created!");
		}
		else {
			alert("Username could not be created!");
		}
	});		
}
