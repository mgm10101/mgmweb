var header = document.querySelector("navbar");

// Get the offset position of the header
var sticky = header.offsetTop;

// Function to add the "sticky" class to the header when scrolling
function makeHeaderSticky() {
  if (window.scrollY > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
