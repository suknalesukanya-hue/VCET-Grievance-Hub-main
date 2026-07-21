
function validateHODLogin() {

    let department = document.getElementById("department").value;
    let pass = document.getElementById("password").value;

    if (department === "") {
        alert("Please select Department.");
        return false;
    }

    if (pass.trim() === "") {
        alert("Password cannot be empty.");
        return false;
    }

    return true;
}
