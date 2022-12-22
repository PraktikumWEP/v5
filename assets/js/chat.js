// global variables
let TOM_TOKEN; // initialize empty for global scope
let JERRY_TOKEN;
const chat = document.getElementById("chat"); // global
let oldMessages = []; // save old messages to make refresh invisible

// set inline variable
let inline = true;
if(chatInline === "dualline") {
    inline = false;
}

// initial load
loadMessages(token);

// refresh
window.setInterval(e => {
    loadMessages(token);
}, 1000);

// event listener for button (calls send)
let send_button = document.getElementsByClassName("button-send")[0];
send_button.addEventListener("click", e => {
    let message = document.getElementsByClassName("input-message")[0];
    send(message.value);
    message.value = "";
});

// send on enter 
let input = document.getElementsByClassName("input-message")[0];
input.addEventListener("keypress", (e) => {
    if(e.key === "Enter") {
        send_button.click();
    }
});

// FUNCTIONS

// GET messages
function loadMessages(token) {

    // vars for request
    let uri = "https://online-lectures-cs.thi.de/chat/" + chatCollectionId + "/message/" + user;

    // vars for data
    let messages = [];
    
    // request
    fetch(uri, {
        method: "GET",
        headers: {
            "Authorization": "Bearer " + chatToken
        }
    })
    .then(response => response.json())
    .then(data => {
        messages = data;
        if(messages !== oldMessages) {
            clearMessages();
            showMessages(messages);
        }
        oldMessages = messages;
    })
    .catch(err => {
        console.error(err);    
    });
}

// show messages arry from fetch (calls addMessage)
function showMessages(messages) {
    messages.forEach(msg => addMessage(msg));
    scroll();
}

// add a message to the chat
function addMessage(msg) {

     /* structure:
        <div class='chat-message'>
            <div class='chat-helper-div'> <!--or chat-helper-div-column-->
                <div class='chat-message-user'></div>
                <div class='chat-message-text'></div>
            </div>
            <div class='time chat-helper-div'></div>
        </div>
    */

    // get data from msg
    let sender = msg.from;
    let content = msg.msg;
    let time = new Date(msg.time);
    time = time.toLocaleTimeString("de-DE");

    // create Elements for new Chat Message
    let chat_message = document.createElement("div");
    let chat_helper_div = document.createElement("div");
    let chat_message_user = document.createElement("span");
    let chat_message_text = document.createElement("span");
    let time_div = document.createElement("div");

    // add CSS classes
    chat_message.className = "chat-message mElement";
    chat_message_user.className = "chat-message-user";
    chat_message_text.className = "chat-message-text";
    time_div.className = "time chat-helper-div";
    if(inline) {
        chat_helper_div.className = "chat-helper-div";
    }
    else {
        chat_helper_div.className = "chat-helper-div-column";
    }

    // structure
    chat.appendChild(chat_message);
    chat_message.appendChild(chat_helper_div);
    chat_message.appendChild(time_div);
    chat_helper_div.appendChild(chat_message_user);
    chat_helper_div.appendChild(chat_message_text);

    // inner HTML
    time_div.innerHTML = time;
    chat_message_user.innerHTML = sender + ":&nbsp";
    if(inline) {
        chat_message_text.innerHTML = content;
    }
    else {
        chat_message_text.innerHTML = "&nbsp" + content;
    }
}

// remove all messages from chat (calls removeChilds)
function clearMessages() {
    removeChilds(chat);
}

// POST message
function send(message) {
    
    // vars
    let uri = "https://online-lectures-cs.thi.de/chat/" + COLLECTION_ID + "/message";

    // request
    fetch(uri, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": bearerHeader
        },
        body: JSON.stringify({
            "message": message,
            "to": user
        })
    })
    .catch(err => {
        console.error(err);    
    });
}

// remove all child elements of a parent node
function removeChilds(parent) {
    while (parent.lastChild) {
        parent.removeChild(parent.lastChild);
    }
}

// scroll div to bottom
function scroll() {
    chat.scrollTop = chat.scrollHeight;
}