// Vanilla
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById('menu-mobile-open').addEventListener('click', function () {
    document.getElementById('header-mobile-open').className = 'header-mobile-open is--active'
  })
  document.getElementById('menu-mobile-cross').addEventListener('click', function () {
    document.getElementById('header-mobile-open').className = 'header-mobile-open'
  })
});