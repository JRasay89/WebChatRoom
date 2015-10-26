var lastLine_ = 0;
var lineCount_ = 0;

$(document).ready(function(){
	$.post("php/main.php",{action: "getSession"}, function(data) {
		var json = jQuery.parseJSON(data);
		$("#currentUsername").text(json["username"]);
	});
	
	//Post the message to post.php
	$("#sendBtn").click(function() {
		var userMsg = $("#message").val();
		$.post("php/main.php",{action: "post", message: userMsg});
		$("#message").val("");
		return false;
	});
	
	//Delete user from the database and delete session
	$("#exitBtn").click(function() {
		//$.post("php/main.php",{action: "exitChat"});
		$.ajax({
			type:'post',
			async:false,
			url:"php/main.php",
			data: {action: "exitChat"}
		});
		window.location.href = 'index.html';		
	});	
	
	//Initialize line count and the line to be read
	$.get("chatLog.txt", function(txt) {
		var lines = txt.split("\n");
		
		setLines(lines.length, lines.length-1);
	});
	
	//Update chat every second
	loadChatLog();
	setInterval (loadChatLog, 1000);
});


function loadChatLog() {
	var lastScrollHeight = $("#chatBox").prop('scrollHeight');
	$.get("chatLog.txt", function(txt) {
		var lines = txt.split("\n");
		var length = lines.length;
		//If lineCount is less than currentLength, then a new message was posted and so append it to the chat box
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