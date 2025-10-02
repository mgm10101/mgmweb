 // Get the current page URL
 var currentPage = window.location.href;

 // Get the links in the navigation menu
 var links = document.querySelectorAll("nav a");

 // Loop through each link
 links.forEach(function (link) {
   // Check if the link's href matches the current page URL
   if (link.href === currentPage) {
     // Add the active class to the link
     link.classList.add("active");
   }
 });