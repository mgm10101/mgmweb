document.addEventListener("DOMContentLoaded", function() {
    // Check if we're on root (index.html) or inside /home/
    const isRoot = window.location.pathname === "/" || window.location.pathname.endsWith("index.html");
    const prefix = isRoot ? "home/" : "";

    // Load header and footer
    loadHTML(prefix + "header.html", "header", setActiveLink);
    loadHTML(prefix + "footer.html", "footer");
});

function loadHTML(url, elementId, callback) {
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error(response.status + " " + response.statusText);
            return response.text();
        })
        .then(data => {
            const el = document.getElementById(elementId);
            if (el) {
                el.innerHTML = data;
                if (callback) callback();
            }
        })
        .catch(error => console.error("Error loading HTML:", error));
}

function setActiveLink() {
    const navLinks = document.querySelectorAll(".nav-link");
    let currentPage = window.location.pathname.split("/").pop();

    // Default to index.html if empty (root path "/")
    if (currentPage === "") {
        currentPage = "index.html";
    }

    navLinks.forEach(link => {
        const href = link.getAttribute("href");

        // Match index.html with home link too
        if (href === currentPage || (currentPage === "index.html" && href.includes("home"))) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
}
