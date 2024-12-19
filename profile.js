document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("token");

    const response = await fetch("/php/profile.php", {
        method: "GET",
        headers: { Authorization: token },
    });

    const result = await response.json();
    if (result.success) {
        document.getElementById("profileData").innerText = JSON.stringify(result.profile, null, 2);
    } else {
        alert(result.message);
        window.location.href = "/login.html";
    }
});
