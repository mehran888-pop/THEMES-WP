(function () {
  var app = document.getElementById("orvio-app");
  if (!app) return;
  function open(id) {
    if (!app.querySelector('[data-panel="' + id + '"]')) id = "general";
    app.querySelectorAll("[data-tab]").forEach(function (btn) {
      btn.classList.toggle("is-on", btn.getAttribute("data-tab") === id);
    });
    app.querySelectorAll("[data-panel]").forEach(function (panel) {
      panel.classList.toggle("is-on", panel.getAttribute("data-panel") === id);
    });
    try { localStorage.setItem("orvio-admin-tab", id); } catch (err) {}
  }
  app.addEventListener("click", function (e) {
    var tab = e.target.closest("[data-tab]");
    if (!tab || !app.contains(tab)) return;
    e.preventDefault();
    open(tab.getAttribute("data-tab"));
  });
  var saved = "general";
  try { saved = localStorage.getItem("orvio-admin-tab") || "general"; } catch (err) {}
  open(saved);
})();
