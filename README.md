# WebChatRoom
A simple chatroom using PHP, JavaScript, JQuery, and AJAX. I started this project so that 
I could practice more on these languages and libraries.

This web app is work in progress. I will continue to work on it and improve my code.
I will also try to add new features such as creating multiple chat rooms, and kicking out users who are idle after a certain amount of time.

##Login
![Login](images/login_screenshot.png)

##Chat
![Chat](images/chat_screenshot.png)

##Current Version
A user can join by entering a username which is then stored in a MySQL database until user exits or expires.
If the username is already being used, it will alert the user and he/she must enter a new username that is not in used.
Inside the chatroom, users can send messages which is saved in a log file.
The log file is read every one second to check if new messages were sent.
Any new messages found in the log file are appended to the chatbox.