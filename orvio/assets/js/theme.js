(function () {
  "use strict";

  var overlay = function () { return document.querySelector("[data-overlay]"); };

  function lock(on) {
    document.body.classList.toggle("is-locked", !!on);
  }

  function closeDrawers() {
    document.querySelectorAll("[data-drawer]").forEach(function (el) {
      el.classList.remove("is-open");
      el.setAttribute("aria-hidden", "true");
    });
    document.querySelectorAll(".orvio-filters.is-open").forEach(function (el) {
      el.classList.remove("is-open");
    });
    var modal = document.querySelector("[data-modal]");
    if (modal) modal.classList.remove("is-open");
    var ov = overlay();
    if (ov) ov.classList.remove("is-open");
    var search = document.querySelector("[data-searchpanel]");
    if (search) search.classList.remove("is-open");
    lock(false);
  }

  function openDrawer(name) {
    var el = document.querySelector('[data-drawer="' + name + '"]');
    if (!el) return;
    document.querySelectorAll("[data-drawer]").forEach(function (d) {
      d.classList.remove("is-open");
    });
    el.classList.add("is-open");
    el.setAttribute("aria-hidden", "false");
    var ov = overlay();
    if (ov) ov.classList.add("is-open");
    lock(true);
    var focusable = el.querySelector("button, a, input");
    if (focusable) focusable.focus();
  }

  function toast(message) {
    var el = document.querySelector("[data-toast]");
    if (!el) return;
    el.textContent = message;
    el.classList.add("is-on");
    clearTimeout(toast._t);
    toast._t = setTimeout(function () { el.classList.remove("is-on"); }, 2400);
  }

  function initSticky() {
    var header = document.querySelector("[data-header]");
    if (!header) return;
    var onScroll = function () {
      header.classList.toggle("is-stuck", window.scrollY > 8);
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  function initAnnounce() {
    var bar = document.querySelector("[data-announce]");
    if (!bar) return;
    try {
      if (localStorage.getItem("orvio-announce") === "off") bar.remove();
    } catch (e) {}
    var btn = bar.querySelector("[data-announce-close]");
    if (btn) btn.addEventListener("click", function () {
      bar.remove();
      try { localStorage.setItem("orvio-announce", "off"); } catch (e) {}
    });
  }

  function initQty() {
    document.addEventListener("click", function (e) {
      var btn = e.target.closest("[data-qty]");
      if (!btn) return;
      var wrap = btn.closest(".orvio-qty");
      if (!wrap) return;
      var input = wrap.querySelector("input");
      var v = parseInt(input.value, 10) || 1;
      v += btn.getAttribute("data-qty") === "plus" ? 1 : -1;
      input.value = String(Math.max(1, Math.min(99, v)));
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
  }

  function initCarousel() {
    document.querySelectorAll("[data-carousel]").forEach(function (root) {
      var track = root.querySelector(".orvio-carousel__track");
      if (!track) return;
      var index = 0;
      function cardStep() {
        var card = track.querySelector(".orvio-card");
        if (!card) return 1;
        var gap = 16;
        return card.getBoundingClientRect().width + gap;
      }
      function visible() {
        var view = root.querySelector(".orvio-carousel__view");
        return Math.max(1, Math.round(view.clientWidth / cardStep()));
      }
      function go(dir) {
        var max = Math.max(0, track.children.length - visible());
        index = Math.min(max, Math.max(0, index + dir));
        var sign = document.documentElement.dir === "rtl" ? 1 : -1;
        track.style.transform = "translateX(" + (sign * index * cardStep()) + "px)";
      }
      var prev = root.querySelector("[data-prev]");
      var next = root.querySelector("[data-next]");
      if (prev) prev.addEventListener("click", function () { go(-1); });
      if (next) next.addEventListener("click", function () { go(1); });
      window.addEventListener("resize", function () { go(0); });
    });
  }

  function initGallery() {
    document.addEventListener("click", function (e) {
      var btn = e.target.closest("[data-thumb]");
      if (!btn) return;
      var gallery = btn.closest("[data-gallery]");
      if (!gallery) return;
      var main = gallery.querySelector("[data-main]");
      if (main && btn.dataset.src) {
        main.src = btn.dataset.src;
        main.alt = btn.dataset.alt || main.alt;
      }
      gallery.querySelectorAll("[data-thumb]").forEach(function (b) { b.classList.remove("is-on"); });
      btn.classList.add("is-on");
    });
  }

  document.addEventListener("click", function (e) {
    var open = e.target.closest("[data-open]");
    if (open) {
      var name = open.getAttribute("data-open");
      if (name === "search") {
        var panel = document.querySelector("[data-searchpanel]");
        if (panel) {
          panel.classList.toggle("is-open");
          var input = panel.querySelector("input");
          if (panel.classList.contains("is-open") && input) input.focus();
        }
        return;
      }
      if (name === "filters") {
        var filters = document.querySelector("[data-filters]");
        if (filters) {
          filters.classList.add("is-open");
          var ov = overlay();
          if (ov) ov.classList.add("is-open");
          lock(true);
        }
        return;
      }
      openDrawer(name);
      document.dispatchEvent(new CustomEvent("orvio:open", { detail: name }));
      return;
    }
    if (e.target.closest("[data-close]") || e.target.closest("[data-overlay]")) {
      closeDrawers();
    }
    var catall = e.target.closest("[data-catall]");
    if (catall && window.matchMedia("(hover: none)").matches) {
      catall.parentElement.classList.toggle("is-open");
    }
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeDrawers();
  });

  if (window.jQuery) {
    window.jQuery(document.body).on("added_to_cart", function () {
      openDrawer("cart");
    });
  }

  function wishStore() {
    try { return JSON.parse(localStorage.getItem("orvio-wish-wp")) || []; } catch (err) { return []; }
  }
  function saveWish(list) {
    localStorage.setItem("orvio-wish-wp", JSON.stringify(list));
  }
  function renderWish() {
    if (window.ORVIO_CATALOG) return;
    var list = wishStore();
    document.querySelectorAll("[data-wish-count]").forEach(function (el) {
      el.textContent = String(list.length);
      el.classList.toggle("is-zero", !list.length);
    });
    document.querySelectorAll("[data-wish]").forEach(function (btn) {
      btn.classList.toggle("is-on", list.some(function (i) { return String(i.id) === String(btn.getAttribute("data-wish")); }));
    });
    var box = document.querySelector("[data-wish-items]");
    if (!box) return;
    if (!list.length) {
      box.innerHTML = '<div class="orvio-empty"><p>' + ((window.OrvioData && OrvioData.i18n && OrvioData.i18n.empty) || "") + "</p></div>";
      return;
    }
    box.innerHTML = list.map(function (item) {
      return '<div class="orvio-line"><a href="' + item.url + '"><img src="' + (item.img || "") + '" alt=""></a><div><h3><a href="' + item.url + '">' + item.name + '</a></h3><button class="orvio-line__remove" data-wish="' + item.id + '">×</button></div></div>';
    }).join("");
  }

  document.addEventListener("click", function (e) {
    if (window.ORVIO_CATALOG) return;
    var btn = e.target.closest("[data-wish]");
    if (!btn) return;
    e.preventDefault();
    var id = btn.getAttribute("data-wish");
    var list = wishStore().filter(function (i) { return String(i.id) !== String(id); });
    if (!btn.classList.contains("is-on")) {
      list.push({
        id: id,
        name: btn.getAttribute("data-wish-name") || "",
        img: btn.getAttribute("data-wish-img") || "",
        url: btn.getAttribute("data-wish-url") || "#"
      });
    }
    saveWish(list);
    renderWish();
  });

  document.addEventListener("input", function (e) {
    if (window.ORVIO_CATALOG || !window.OrvioData || !e.target.matches("[data-search]")) return;
    var input = e.target;
    var panel = input.parentElement.querySelector("[data-suggest]");
    if (!panel) return;
    var q = input.value.trim();
    if (q.length < 2) { panel.hidden = true; return; }
    clearTimeout(input._orvioT);
    input._orvioT = setTimeout(function () {
      fetch(OrvioData.ajax + "?action=orvio_search&nonce=" + encodeURIComponent(OrvioData.nonce) + "&q=" + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (res) {
          var items = (res && res.data) || [];
          panel.hidden = false;
          panel.innerHTML = items.map(function (item) {
            return '<a href="' + item.url + '">' + (item.img ? '<img src="' + item.img + '" alt="">' : "") + "<span>" + item.title + (item.price ? "<small>" + item.price + "</small>" : "") + "</span></a>";
          }).join("") || '<div class="orvio-suggest__empty">—</div>';
        });
    }, 180);
  });

  document.addEventListener("submit", function (e) {
    var form = e.target.closest ? e.target.closest("[data-orvio-contact], [data-orvio-news]") : null;
    if (!form || !window.OrvioData) return;
    e.preventDefault();
    if (form.hasAttribute("data-orvio-news")) {
      toast((OrvioData.i18n && OrvioData.i18n.sent) || "OK");
      form.reset();
      return;
    }
    var data = new FormData(form);
    data.append("action", "orvio_contact");
    data.append("nonce", OrvioData.nonce);
    fetch(OrvioData.ajax, { method: "POST", body: data, credentials: "same-origin" })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        toast((res.data && res.data.message) || (OrvioData.i18n && OrvioData.i18n.sent) || "OK");
        if (res.success) form.reset();
      })
      .catch(function () { toast(OrvioData.i18n.required || "Error"); });
  });

  window.OrvioUI = {
    open: openDrawer,
    close: closeDrawers,
    toast: toast
  };

  document.addEventListener("DOMContentLoaded", function () {
    initSticky();
    initAnnounce();
    initQty();
    initCarousel();
    initGallery();
    if (!window.ORVIO_CATALOG && typeof renderWish === "function") renderWish();
    document.addEventListener("click", function (e) {
    if (!e.target.closest("[data-sticky-submit]")) return;
    var form = document.querySelector("form.cart");
    if (form) {
      if (typeof form.requestSubmit === "function") form.requestSubmit();
      else form.submit();
    }
  });
    var sticky = document.querySelector("[data-sticky-atc]");
    var buy = document.querySelector("form.cart");
    if (sticky && buy && "IntersectionObserver" in window) {
      new IntersectionObserver(function (entries) {
        sticky.classList.toggle("is-on", !entries[0].isIntersecting && window.innerWidth < 980);
      }, { threshold: 0.15 }).observe(buy);
    }
  });
})();
