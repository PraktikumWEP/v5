// get data from config
let COLLECTION_ID; // initialize empty for global scope
let TOM_TOKEN;
await fetch('./cfg.json')
    .then(response => response.json()) // get object from response
    .then(data => {
        COLLECTION_ID = data.COLLECTION_ID; // get ID
        TOM_TOKEN = data.tom.token;
    })
    .catch(err => { 
        console.error(err);
    });

async function getFriends() {
    let uri = "https://online-lectures-cs.thi.de/chat/" + COLLECTION_ID + "/user";
    let response = await fetch(uri, {
        headers: {
            'Authorization': "Bearer " + TOM_TOKEN
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

let list = document.getElementsByClassName("suggested-friends")[0];
let input = document.getElementsByClassName("input")[0];
const form = document.forms.addFriend;

async function refreshList() {
    // get friend and filter them by input
    let friends = await getFriends();
    let value = input.value;
    let filter = friends.filter(friend => {
        if(input.value.length > 0) {
            if(friend.includes(value)) {
                return friend;
            }
        }
    })

    if(filter.length > 0) {
        // create list of friend entries
        let new_list = document.createElement("div");

        filter.forEach(friend => {
            let element = document.createElement("div");
            element.classList.add("mElement");
            element.classList.add("suggested-friends-entry");
            element.innerHTML = friend;
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

async function checkFriends() {
    let friends = await getFriends();
    let value = input.value;

    if(friends.includes(value)) {
        return true;
    }
    return false;
}

input.addEventListener("input", () => {
    refreshList();
})

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if(await checkFriends()) {
        form.submit();
    }
    else {
        input.className = 'input input-error';
    }
})