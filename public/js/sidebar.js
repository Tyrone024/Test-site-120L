const sidebaropen = document.querySelector(".toggle-btn");

sidebaropen.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});
