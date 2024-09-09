document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../src/php/adminLogin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = xhr.responseText.trim();
            if (response === "success") {
                // Redirect to the admin page if login is successful
                window.location.href = "admin.php";
                document.getElementById("message").innerText = '';
            } else {
                // Display the error message if login failed
                document.getElementById("message").innerText = response;
            }
        }
    };

    const identity = document.getElementById("identity").value;
    const password = document.getElementById("password").value;
    const params = "identity=" + encodeURIComponent(identity) + "&password=" + encodeURIComponent(password);

    if (identity !== "" && password !== "") {
        // alert(identity + " and " + password);
        
        xhr.send(params);

    } else {
        document.getElementById("message").innerText = "Veillez entrer l'identite et le mot de passe";
    }
});
