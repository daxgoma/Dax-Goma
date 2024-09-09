document.getElementById("LogoutForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../src/php/adminLogout.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = xhr.responseText.trim();
            if (response === "success") {

                // Redirect to the admin page if login is successful
                window.location.href = "index.php";

            }
        }
    };

    const islogedout = "true";
    const params = "islogedout=" + encodeURIComponent(islogedout);


    xhr.send(params);

});
