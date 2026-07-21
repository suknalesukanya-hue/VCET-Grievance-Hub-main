
function validateAdvisorLogin() {

    let advisor = document.querySelector("select[name='advisor_name']").value;
    let pass = document.querySelector("input[name='password']").value;

    if (advisor === "") {
        alert("Please select Advisor.");
        return false;
    }

    if (pass.trim() === "") {
        alert("Password is required.");
        return false;
    }

    return true;
}
