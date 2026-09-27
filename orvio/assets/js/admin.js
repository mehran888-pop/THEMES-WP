document.addEventListener("click", function (e) {
  var tab = e.target.closest("[data-tab]");
  if (!tab) return;
  document.querySelectorAll("[data-tab]").forEach(function (b) { b.classList.toggle("is-on", b === tab); });
  document.querySelectorAll("[data-panel]").forEach(function (p) {
    p.hidden = p.getAttribute("data-panel") !== tab.getAttribute("data-tab");
  });
});
