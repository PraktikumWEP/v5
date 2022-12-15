// global variables
let COLLECTION_ID;
let TOM_TOKEN; // initialize empty for global scope
let JERRY_TOKEN;
const chat = document.getElementById("chat"); // global
let oldMessages = []; // save old messages to make refresh invisible

// MAIN

// fetch config data
await fetch('./cfg.json')
.then(response => response.json()) // get object from response
.then(data => {
    COLLECTION_ID = data.COLLECTION_ID;
    TOM_TOKEN = data.tom.token;
    JERRY_TOKEN = data.jerry.token;
})
.catch(err => { 
    console.error(err);
});

// which chat (temporary)
let user = "Jerry";
let token = TOM_TOKEN;
let bearerHeader = "Bearer " + token;

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
    let uri = "https://online-lectures-cs.thi.de/chat/" + COLLECTION_ID + "/message/" + user;

    // vars for data
    let messages = [];
    
    // request
    fetch(uri, {
        method: "GET",
        headers: {
            "Authorization": bearerHeader
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
    for(let msg of messages.reverse()) {
        addMessage(msg);
    }
}

// add a message to the chat
function addMessage(msg) {

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
    chat_helper_div.className = "chat-helper-div";
    chat_message_user.className = "chat-message-user";
    chat_message_text.className = "chat-message-text";
    time_div.className = "time chat-helper-div";

    // structure
    chat.appendChild(chat_message);
    chat_message.appendChild(chat_helper_div);
    chat_message.appendChild(time_div);
    chat_helper_div.appendChild(chat_message_user);
    chat_helper_div.appendChild(chat_message_text);

    // inner HTML
    time_div.innerHTML = time;
    chat_message_user.innerHTML = sender + ":&nbsp";
    chat_message_text.innerHTML = content;
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