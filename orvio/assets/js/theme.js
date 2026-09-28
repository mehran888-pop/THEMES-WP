(function () {
  "use strict";

  var overlay = function () { return document.querySelector("[data-overlay]"); };
  var activeDrawer = null;
  var lastDrawerTrigger = null;

  function lock(on) {
    document.body.classList.toggle("is-locked", !!on);
  }

  function drawerFocusable(el) {
    if (!el) return [];
    return Array.prototype.slice.call(el.querySelectorAll("a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex=\"-1\"])"));
  }

  function setTriggerState(name, expanded) {
    document.querySelectorAll('[data-open="' + name + '"]').forEach(function (trigger) {
      trigger.setAttribute("aria-expanded", expanded ? "true" : "false");
    });
  }

  function closeDrawers() {
    document.querySelectorAll("[data-drawer]").forEach(function (el) {
      el.classList.remove("is-open");
      el.setAttribute("aria-hidden", "true");
      setTriggerState(el.getAttribute("data-drawer"), false);
    });
    document.querySelectorAll(".orvio-filters.is-open").forEach(function (el) {
      el.classList.remove("is-open");
    });
    document.querySelectorAll("[data-account-nav].is-open").forEach(function (el) {
      el.classList.remove("is-open");
      el.setAttribute("aria-hidden", "true");
    });
    setTriggerState("account-nav", false);
    var modal = document.querySelector("[data-modal]");
    if (modal) modal.classList.remove("is-open");
    var search = document.querySelector("[data-searchpanel]");
    if (search) search.classList.remove("is-open");
    document.querySelectorAll('[data-open="search"]').forEach(function (trigger) {
      trigger.setAttribute("aria-expanded", "false");
    });
    var ov = overlay();
    if (ov) {
      ov.classList.remove("is-open");
      ov.setAttribute("aria-hidden", "true");
    }
    lock(false);
    var restore = lastDrawerTrigger;
    activeDrawer = null;
    lastDrawerTrigger = null;
    if (restore && document.contains(restore)) restore.focus();
  }

  function openDrawer(name, trigger) {
    var el = document.querySelector('[data-drawer="' + name + '"]');
    if (!el) return;
    document.querySelectorAll("[data-drawer]").forEach(function (d) {
      d.classList.remove("is-open");
      d.setAttribute("aria-hidden", "true");
      setTriggerState(d.getAttribute("data-drawer"), false);
    });
    var accountNav = document.querySelector("[data-account-nav].is-open");
    if (accountNav) {
      accountNav.classList.remove("is-open");
      accountNav.setAttribute("aria-hidden", "true");
      setTriggerState("account-nav", false);
    }
    lastDrawerTrigger = trigger || document.activeElement;
    activeDrawer = el;
    el.classList.add("is-open");
    el.setAttribute("aria-hidden", "false");
    setTriggerState(name, true);
    var ov = overlay();
    if (ov) {
      ov.classList.add("is-open");
      ov.setAttribute("aria-hidden", "false");
    }
    lock(true);
    var focusable = drawerFocusable(el);
    if (focusable.length) focusable[0].focus();
  }

  function openAccountNav(trigger) {
    var nav = document.querySelector("[data-account-nav]");
    if (!nav) return;
    closeDrawers();
    lastDrawerTrigger = trigger || document.activeElement;
    activeDrawer = nav;
    nav.classList.add("is-open");
    nav.setAttribute("aria-hidden", "false");
    setTriggerState("account-nav", true);
    var ov = overlay();
    if (ov) {
      ov.classList.add("is-open");
      ov.setAttribute("aria-hidden", "false");
    }
    lock(true);
    var focusable = drawerFocusable(nav);
    if (focusable.length) focusable[0].focus();
  }

  function toast(message) {
    var el = document.querySelector("[data-toast]");
    if (!el) return;
    el.textContent = message;
    el.classList.add("is-on");
    clearTimeout(toast._t);
    toast._t = setTimeout(function () { el.classList.remove("is-on"); }, 2400);
  }

  function replaceWooFragments(fragments) {
    if (!fragments) return;
    Object.keys(fragments).forEach(function (selector) {
      document.querySelectorAll(selector).forEach(function (oldNode) {
        var holder = document.createElement("div");
        holder.innerHTML = fragments[selector];
        var fresh = holder.firstElementChild;
        if (fresh) oldNode.replaceWith(fresh);
      });
    });
  }

  function afterCartAdd(button) {
    var behavior = (button && button.getAttribute("data-orvio-atc-behavior")) || (window.OrvioData && OrvioData.atcBehavior) || "auto";
    if (behavior === "checkout") {
      window.location.href = (window.OrvioData && OrvioData.checkout) || "/checkout/";
      return;
    }
    if (behavior === "cart" || (behavior === "auto" && window.OrvioData && OrvioData.cartType === "page")) {
      window.location.href = (window.OrvioData && OrvioData.cart) || "/cart/";
      return;
    }
    if (behavior === "ajax-stay") return;
    openDrawer("cart");
  }

  function initCardAddToCart() {
    document.addEventListener("click", function (e) {
      var button = e.target.closest("[data-orvio-atc]");
      if (!button || button.classList.contains("is-loading")) return;
      e.preventDefault();
      var params = window.wc_add_to_cart_params || {};
      var endpoint = params.wc_ajax_url ? params.wc_ajax_url.replace("%%endpoint%%", "add_to_cart") : "";
      if (!endpoint || !window.fetch) {
        window.location.href = button.href;
        return;
      }
      var quantity = parseFloat(button.getAttribute("data-quantity") || "1") || 1;
      var productId = button.getAttribute("data-product_id");
      button.classList.add("is-loading");
      button.setAttribute("aria-busy", "true");
      fetch(endpoint, {
        method: "POST",
        credentials: "same-origin",
        headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
        body: new URLSearchParams({ product_id: productId, quantity: String(quantity) }).toString()
      }).then(function (response) { return response.json(); }).then(function (result) {
        if (result.error && result.product_url) {
          window.location.href = result.product_url;
          return;
        }
        replaceWooFragments(result.fragments);
        if (window.jQuery) {
          window.jQuery(document.body).trigger("added_to_cart", [result.fragments || {}, result.cart_hash || "", button]);
        } else {
          afterCartAdd(button);
        }
      }).catch(function () {
        window.location.href = button.href;
      }).finally(function () {
        button.classList.remove("is-loading");
        button.removeAttribute("aria-busy");
      });
    });
  }

  function initSingleAddToCart() {
    document.addEventListener("submit", function (e) {
      var form = e.target.closest("form[data-orvio-single-atc]");
      if (!form || form.classList.contains("variations_form") || form.classList.contains("is-loading")) return;
      var params = window.wc_add_to_cart_params || {};
      var endpoint = params.wc_ajax_url ? params.wc_ajax_url.replace("%%endpoint%%", "add_to_cart") : "";
      if (!endpoint || !window.fetch) return;
      e.preventDefault();
      var body = new URLSearchParams();
      new FormData(form).forEach(function (value, key) { body.append(key, value); });
      body.set("product_id", form.getAttribute("data-product_id") || body.get("add-to-cart") || "");
      form.classList.add("is-loading");
      fetch(endpoint, { method: "POST", credentials: "same-origin", headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, body: body.toString() })
        .then(function (response) { return response.json(); })
        .then(function (result) {
          if (result.error && result.product_url) { window.location.href = result.product_url; return; }
          replaceWooFragments(result.fragments);
          if (window.jQuery) window.jQuery(document.body).trigger("added_to_cart", [result.fragments || {}, result.cart_hash || "", form]);
          else afterCartAdd(form);
        })
        .catch(function () { form.submit(); })
        .finally(function () { form.classList.remove("is-loading"); });
    });
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
      var cols = parseInt(root.getAttribute("data-cols") || "4", 10) || 4;
      var gap = parseInt(root.getAttribute("data-gap") || "16", 10) || 16;
      var loop = root.getAttribute("data-loop") === "1";
      function cardStep() {
        var card = track.querySelector(".orvio-card, .orvio-dealcard, .orvio-catcard");
        if (!card) card = track.firstElementChild;
        if (!card) return 1;
        return card.getBoundingClientRect().width + gap;
      }
      function visible() {
        var view = root.querySelector(".orvio-carousel__view");
        if (!view) return cols;
        return Math.max(1, Math.min(cols, Math.round(view.clientWidth / Math.max(1, cardStep()))));
      }
      function maxIndex() { return Math.max(0, track.children.length - visible()); }
      function paint() {
        var sign = document.documentElement.dir === "rtl" ? 1 : -1;
        track.style.transform = "translateX(" + (sign * index * cardStep()) + "px)";
        root.querySelectorAll("[data-dot]").forEach(function (dot, i) {
          dot.classList.toggle("is-on", i === index);
        });
      }
      function go(dir) {
        var max = maxIndex();
        index += dir;
        if (loop) {
          if (index > max) index = 0;
          if (index < 0) index = max;
        } else {
          index = Math.min(max, Math.max(0, index));
        }
        paint();
      }
      var dots = root.querySelector("[data-dots]");
      if (dots && !dots.children.length) {
        for (var i = 0; i <= maxIndex(); i++) {
          var b = document.createElement("button");
          b.type = "button";
          b.setAttribute("data-dot", String(i));
          b.addEventListener("click", function () { index = parseInt(this.getAttribute("data-dot"), 10) || 0; paint(); });
          dots.appendChild(b);
        }
      }
      var prev = root.querySelector("[data-prev]");
      var next = root.querySelector("[data-next]");
      if (prev) prev.addEventListener("click", function () { go(-1); });
      if (next) next.addEventListener("click", function () { go(1); });
      var auto = parseInt(root.getAttribute("data-autoplay") || "0", 10);
      if (auto > 800) setInterval(function () { go(1); }, auto);
      window.addEventListener("resize", function () { go(0); });
      paint();
    });
  }
  function initTimers() {
    function tick() {
      document.querySelectorAll("[data-orvio-timer]").forEach(function (el) {
        var end = Date.parse(el.getAttribute("data-orvio-timer") || "");
        if (!end) return;
        var left = Math.max(0, end - Date.now());
        var h = Math.floor(left / 3600000);
        var m = Math.floor((left % 3600000) / 60000);
        var s = Math.floor((left % 60000) / 1000);
        el.textContent = (h < 10 ? "0" : "") + h + ":" + (m < 10 ? "0" : "") + m + ":" + (s < 10 ? "0" : "") + s;
      });
    }
    tick();
    setInterval(tick, 1000);
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
          open.setAttribute("aria-expanded", panel.classList.contains("is-open") ? "true" : "false");
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
      if (name === "account-nav") {
        openAccountNav(open);
        document.dispatchEvent(new CustomEvent("orvio:open", { detail: name }));
        return;
      }
      openDrawer(name, open);
      document.dispatchEvent(new CustomEvent("orvio:open", { detail: name }));
      return;
    }
    if (e.target.closest("[data-close]") || e.target.closest("[data-overlay]")) {
      closeDrawers();
    }
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeDrawers();
      return;
    }
    if (e.key !== "Tab" || !activeDrawer || !activeDrawer.classList.contains("is-open")) return;
    var focusable = drawerFocusable(activeDrawer);
    if (!focusable.length) {
      e.preventDefault();
      var closeButton = activeDrawer.querySelector(".orvio-drawer__x");
      if (closeButton) closeButton.focus();
      return;
    }
    var first = focusable[0];
    var last = focusable[focusable.length - 1];
    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  });

  if (window.jQuery) {
    window.jQuery(document.body).on("added_to_cart", function (event, fragments, hash, button) {
      replaceWooFragments(fragments);
      afterCartAdd(button && button.jquery ? button[0] : button);
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

  function initAccountNav() {
    var nav = document.querySelector("[data-account-nav]");
    if (!nav) return;
    var sync = function () {
      if (!nav.classList.contains("is-open")) {
        nav.setAttribute("aria-hidden", window.innerWidth <= 980 ? "true" : "false");
      }
    };
    sync();
    window.addEventListener("resize", sync);
  }

  function initProfileAvatar() {
    document.querySelectorAll("[data-avatar-input]").forEach(function (input) {
      input.addEventListener("change", function () {
        var file = input.files && input.files[0];
        var form = input.closest("form");
        var wrap = document.querySelector("[data-avatar-preview-wrap]");
        if (!file || !wrap) return;
        var label = form && form.querySelector("[data-avatar-name]");
        if (label) label.textContent = file.name;
        if (!window.URL || !URL.createObjectURL) return;
        var image = wrap.querySelector("img");
        if (!image) {
          image = document.createElement("img");
          image.className = "orvio-profile-avatar__image";
          image.alt = "";
          wrap.querySelectorAll(".orvio-profile-avatar__initials").forEach(function (fallback) { fallback.remove(); });
          wrap.insertBefore(image, wrap.firstChild);
        }
        if (input._orvioObjectUrl) URL.revokeObjectURL(input._orvioObjectUrl);
        input._orvioObjectUrl = URL.createObjectURL(file);
        image.src = input._orvioObjectUrl;
      });
    });
  }

  function initCatMenu() {
    document.querySelectorAll(".orvio-catbar__menu > li > a, .orvio-catall__btn").forEach(function (el) {
      el.addEventListener("click", function (e) {
        if (window.matchMedia("(hover: hover) and (pointer: fine)").matches) return;
        var li = el.closest("li, .orvio-catall");
        if (!li || !li.querySelector(".orvio-mega, .orvio-catall__panel")) return;
        if (li.classList.contains("is-open")) return;
        e.preventDefault();
        document.querySelectorAll(".orvio-catbar__menu > li, .orvio-catall").forEach(function (item) {
          item.classList.toggle("is-open", item === li);
        });
      });
    });
    document.addEventListener("keydown", function (e) {
      if (e.key !== "Escape") return;
      document.querySelectorAll(".orvio-catbar__menu > li, .orvio-catall").forEach(function (item) {
        item.classList.remove("is-open");
      });
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initSticky();
    initAnnounce();
    initQty();
    initCarousel();
    initTimers();
    initGallery();
    initAccountNav();
    initProfileAvatar();
    initCardAddToCart();
    initSingleAddToCart();
    initCatMenu();
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
