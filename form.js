
document.getElementById("signupForm").addEventListener("submit", function(e){

    let password = document.querySelectorAll("input[type='password']")[0].value;
    let confirm = document.querySelectorAll("input[type='password']")[1].value;

    if(password !== confirm){
        e.preventDefault();
        alert("Passwords do not match!");
    }
});