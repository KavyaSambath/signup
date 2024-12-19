document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const response = await fetch("/php/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password }),
    });

    const result = await response.json();
    if (result.success) {
        localStorage.setItem("token", result.token);
        alert("Login successful!");
        window.location.href = "/profile.html";
    } else {
        alert(result.message);
    }
});
