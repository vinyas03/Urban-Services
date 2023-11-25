const toggleBtn = document.querySelector(".toggleBtn");
const menuBtn = document.querySelector(".menu");

const navItems = document.querySelector(".nav-items");
const navBtns = document.querySelector(".nav-buttons");

toggleBtn.addEventListener("click", () => {
  //toggleBtn.classList.toggle('active');
  if (menuBtn.src.endsWith("burger-menu-left.svg")) {
    menuBtn.src = "../images/svg/burger-menu-close.svg";
  } else {
    menuBtn.src = "../images/svg/burger-menu-left.svg";
  }

  navItems.classList.toggle("active");
  navBtns.classList.toggle("active");
});
