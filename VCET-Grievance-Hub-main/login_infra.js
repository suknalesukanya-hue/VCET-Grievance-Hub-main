
function validateInfraLogin() {

    let user = document.querySelector("input[name='username']").value;
    let pass = document.querySelector("input[name='password']").value;

    if (user.trim() === "") {
        alert("Username is required.");
        return false;
    }

    if (pass.trim() === "") {
        alert("Password cannot be empty.");
        return false;
    }

    return true;
}
