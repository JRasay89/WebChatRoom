var lastLine_ = 0;
var lineCount_ = 0;

$(document).ready(function(){
	$.post("php/session.php", function(data) {
		var json = jQuery.parseJSON(data);
		$("#currentUsername").text(json["username"]);
	});
	
	//Post the message to post.php
	$("#sendBtn").click(function() {
		var userMsg = $("#message").val();
		$.post("php/post.php",{message: userMsg});
		$("#message").val("");
		return false;
	});
	
	//Delete user from the database and delete session
	$("#exitBtn").click(function() {
		$.post("php/session.php", function(data) {
				var json = jQuery.parseJSON(data);
				var user_ = json["username"];
				$.post("php/logout.php");
				//Delete user in database
				$.post("php/deleteUser.php", {username: user_});	
				//Delete session
				$.post("php/deleteSession.php");			
				//Go back login screen
				window.location.href = 'index.html';
		});			
	});
	
	//Initialize line count and the line to be read
	$.get("chatLog.txt", function(txt) {
		var lines = txt.split("\n");
		
		setLines(lines.length, lines.length-1);
	});
	
	//Load chat, update chat every second
	//loadChatLog();
	setInterval (loadChatLog, 1000);
});


function loadChatLog() {
	var lastScrollHeight = $("#chatBox").prop('scrollHeight');
	$.get("chatLog.txt", function(txt) {
		var lines = txt.split("\n");
		var length = lines.length;
		//If lineCount is less than currentLength, then a new message was posted and so append it to the message area
		if (lineCount_ < length) {
			$("#chatBox").append(lines[lastLine_]);
			setLines(length, lineCount_);
			
		}
		//Auto scroll to new message
		var newScrollHeight = $("#chatBox").prop('scrollHeight');
		if (newScrollHeight > lastScrollHeight) {
			$("#chatBox").scrollTop(newScrollHeight);
		}
	});
}

//Get the line count and the line to append to the chat 
function setLines(lineCount, lastLine) {
	lineCount_ = lineCount;
	lastLine_ = lastLine;
}