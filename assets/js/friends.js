// search
let list = document.getElementsByClassName("suggested-friends")[0];
            let input = document.getElementsByClassName("input")[0];

            async function refreshList() {
                let value = input.value;
                let filter = users.filter(user => {
                    if(input.value.length > 0) {
                        if(user.includes(value)) {
                            return user;
                        }
                    }
                })

                if(filter.length > 0) {
                    // create list of user entries
                    let new_list = document.createElement("div");

                    filter.forEach(user => {
                        let element = document.createElement("div");
                        element.classList.add("mElement");
                        element.classList.add("suggested-friends-entry");
                        element.innerHTML = user;
                        new_list.appendChild(element);
                    });
                
                    // show list and add new elements
                    list.style.display = "block";
                    list.innerHTML = new_list.innerHTML;

                    // add click handler on each entry for auto complete
                    list.childNodes.forEach(child => {
                        child.addEventListener("click", () => {
                            input.value = child.innerHTML
                            list.style.display = "none";
                            list.innerHTML = "";
                            input.className = 'input';
                        }) 
                    })
                }
                else {
                    // display nothing if we dont find anything
                    list.style.display = "none";
                    list.innerHTML = "";
                }
}

input.addEventListener("input", () => {
    refreshList();
})

async function getFriends() {
    let uri = "https://online-lectures-cs.thi.de/chat/" + chatCollectionId + "/friend";
    let response = await fetch(uri, {
        method: "GET",
        headers: {
            'Authorization': "Bearer " + chatToken
        }
    });
    if(response.ok) {
        let result = await response.json();
        return result;
    }
    else {
        console.error('error ' + response.status);
    }
}

async function getUnread() {
    let uri = "https://online-lectures-cs.thi.de/chat/" + chatCollectionId + "/unread";
    let response = await fetch(uri, {
        method: "GET",
        headers: {
            'Authorization': "Bearer " + chatToken
        }
    });
    if(response.ok) {
        let result = await response.json();
        return result;
    }
    else {
        console.error('error ' + response.status);
    }
}

setInterval(async () => {
    let friendlist = document.getElementById("friendlist");
    let requestList= document.getElementById("requests");
    let friends = document.createElement("div");
    let requests = document.createElement("div");
    let result = await getFriends();
    let result2 = await getUnread();
    result.forEach(friend => {
        if(friend.status == "accepted") {
            let count = 0;
            if(result2[friend.username] != null) {
                count = result2[friend.username];
            }
            let li = document.createElement("li");
            li.innerHTML = "<a href='chat.php?friend=" + friend.username + "' class='link'>" + friend.username + "</a>" +
                           "<label class='notification-count'>" + count + "</label>";
            friends.appendChild(li);
        }
        else {
            let li = document.createElement("li");
            li.innerHTML = "<form action='friendlist.php' method='POST'>" + 
                                "<a>Friend request from <span class='link'>" + friend.username + "</span></a>" +
                                "<div class='centerCol mElement'>" + 
                                    "<button type='submit' class='button-small centerRow' name='accept' value=" + friend.username + ">Accept</button>" + 
                                    "<div style='width: 10px'></div>" +
                                    "<button type='submit' class='button-small centerRow' name='dismiss' value=" + friend.username + ">Decline</button>" +
                                "</div>" + 
                            "</form>";
            requests.appendChild(li);
        }
    });

    if(friends.firstChild) {
        friendlist.innerHTML = friends.innerHTML;
    }
    else {
        friendlist.innerHTML = "No friends";
    }

    if(requests.firstChild) {
        requestList.innerHTML = requests.innerHTML;
    }
    else {
        requestList.innerHTML = "No friend requests";
    }
}, 2000)


