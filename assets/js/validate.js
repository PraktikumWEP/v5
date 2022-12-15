// get data from config
let COLLECTION_ID; // initialize empty for global scope
fetch('./cfg.json')
.then(response => response.json()) // get object from response
.then(data => {
    COLLECTION_ID = data.COLLECTION_ID; // get ID
})
.catch(err => { 
    console.error(err);
});
    
// get elements
const form = document.forms.registerForm;
const username = form.username;
const password1 = form.password1;
const password2 = form.password2;
const submit = form.submit;

// settings
const minPasswordLength = 8;
const minUsernameLength = 3;

// event listeners
// event listener submit
form.addEventListener('submit', (e) => {
    e.preventDefault();
    resetErrorMessage();
    checkInputsUsername();
    checkInputsPassword1();
    checkInputsPassword2();
    checkSuccess();
});

// event listener username input
username.addEventListener('input', (e) => {
    checkInputsUsername();
});

// event listener password input
password1.addEventListener('input', (e) => {
    checkInputsPassword1();
});

// event listener password repeat input 
password2.addEventListener('input', (e) => {
    checkInputsPassword2();
});

// functions
// check username input arguments
async function checkInputsUsername() {

    // reset error msg
    setErrorMessage(username, '');

    // trim
    const usernameValue = username.value.trim();

    // name check
    if(usernameValue.length < minUsernameLength) {
        let message = "Username must be at least " + minUsernameLength + " characters";
        setErrorFor(username, message);
    }
    else if(!(await checkNameAvailability(usernameValue))) { // async
        let message = "Username " + usernameValue + " is already taken";
        setErrorFor(username, message);
    }
    else {
        setSuccessFor(username);
    }
}

// check inputs for password input
function checkInputsPassword1() {

    // reset error msg
    setErrorMessage(password1, '');

    // trim 
    const pw1Value = password1.value.trim();

    // password check
    if(pw1Value.length < minPasswordLength) {
        let message = "Password must be at least " + minPasswordLength + " characters";
        setErrorFor(password1, message);
    }
    else {
        setSuccessFor(password1);
    }
}

// check inputs for password repeat input
function checkInputsPassword2() {

    // reset error msg
    setErrorMessage(password2,'');

    // trim
    const pw1Value = password1.value.trim();
    const pw2Value = password2.value.trim();

    // password repeat check
    if(pw1Value.length < minPasswordLength) {
        let message = "";
        setErrorFor(password2, message);
    }
    else if(pw1Value !== pw2Value) {
        let message = "Passwords do not match";
        setErrorFor(password2, message);
    }
    else {
        setSuccessFor(password2);
    }
}

// add error class and message
function setErrorFor(input, message) {
    setErrorMessage(input, message);
    input.className = 'input input-error';
}

// set the error message for the specified input
function setErrorMessage(input, message) {
    const formSection = input.parentElement.parentElement;
    const small = formSection.querySelector('div.hasSmall').querySelector('small');
    small.innerText = message; // set error message
}

// add success class
function setSuccessFor(input) {
    input.className = 'input input-success';
}

// check if all inputs have success class and submit if so
function checkSuccess() {

    // guard clauses
    if(!username.classList.contains('input-success')) {
        return;
    }
    if(!password1.classList.contains('input-success')) {
        return;
    }
    if(!password2.classList.contains('input-success')) {
        return;
    }

    // submit
    form.submit();
}

// reset error message for all inputs
function resetErrorMessage() {
    setErrorMessage(username, '');
    setErrorMessage(password1, '');
    setErrorMessage(password2, '');
}

// AJAX
// check if specified name is already in use
async function checkNameAvailability(name) {
    let uri = "https://online-lectures-cs.thi.de/chat/" + COLLECTION_ID + "/user/" + name;
    let response = await fetch(uri);

    if (response.status === 204) { // already exists
        return false;
    }
    else if (response.status === 404) { // available
        return true;
    }
    else {
        console.error('error ' + response.status); // print error
        return false;
    }
}