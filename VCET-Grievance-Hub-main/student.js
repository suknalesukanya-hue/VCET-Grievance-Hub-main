function validateStudentLogin() {

    let crname = document.getElementById("crname").value;
    let usn = document.getElementById("usn").value;
    let pass = document.getElementById("password").value;

    if (crname === "") {
        alert("Please select CR Name.");
        return false;
    }

    if (usn === "") {
        alert("Please select CR USN.");
        return false;
    }

    if (pass.trim() === "") {
        alert("Password cannot be empty.");
        return false;
    }

    if (pass.length < 4) {
        alert("Password must be at least 4 characters.");
        return false;
    }

    return true; // Allow submission
}