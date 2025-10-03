document.addEventListener("DOMContentLoaded", function() {
    // if we are on index.html (root), fetch from /html/
    const isRoot = window.location.pathname === "/" || window.location.pathname.endsWith("index.html");
    const prefix = isRoot ? "html/" : "";

    loadHTML(prefix + 'header.html', 'header', setActiveLink);
    loadHTML(prefix + 'footer.html', 'footer');
});

function loadHTML(url, elementId, callback) {
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error(response.statusText);
            return response.text();
        })
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
            if (callback) callback();
        })
        .catch(error => console.error('Error loading HTML:', error));
}

function setActiveLink() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname.split("/").pop();

    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}
