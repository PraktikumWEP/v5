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