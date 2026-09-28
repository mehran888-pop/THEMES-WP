(function () {
  "use strict";

  var CATALOG = window.ORVIO_CATALOG || [];
  var CART_KEY = "orvio-cart-v1";
  var WISH_KEY = "orvio-wish-v1";
  var LANG_KEY = "orvio-lang";
  var UI_KEY = "orvio-ui";
  var COUPON_KEY = "orvio-coupon";
  var ORDER_KEY = "orvio-last-order";
  var FREE_SHIP = 2000000;

  var I18N = {
    fa: {
      skip: "پرش به محتوا",
      announce: "ارسال رایگان برای سفارش‌های بالای ۲ میلیون تومان  ·  بازگشت آسان تا ۳۰ روز",
      tagline: "اشیاء آرام",
      searchPh: "جستجو میان اشیاء…",
      search: "جستجو",
      account: "حساب",
      wish: "علاقه‌مندی",
      cart: "سبد",
      allCats: "همه دسته‌ها",
      weekSale: "تخفیف‌های هفته",
      menu: "منو",
      close: "بستن",
      shop: "فروشگاه",
      about: "درباره ما",
      contact: "ارتباط با ما",
      home: "خانه",
      add: "افزودن به سبد",
      added: "به سبد اضافه شد",
      wished: "به علاقه‌مندی‌ها اضافه شد",
      unwished: "از علاقه‌مندی‌ها برداشته شد",
      emptyCart: "سبد شما خالی است.",
      emptyWish: "هنوز چیزی ذخیره نکرده‌اید.",
      continue: "ادامه خرید",
      viewCart: "مشاهده سبد",
      checkout: "تسویه و صورتحساب",
      subtotal: "جمع جزء",
      remove: "حذف",
      shipLeft: "تا ارسال رایگان",
      shipFree: "ارسال این سفارش رایگان است.",
      results: "کالا",
      noResults: "کالایی با این فیلتر پیدا نشد.",
      clear: "پاک کردن فیلترها",
      sort: "مرتب‌سازی",
      filters: "فیلترها",
      apply: "اعمال",
      inStock: "فقط موجود",
      onSale: "فقط تخفیف‌دار",
      newest: "جدیدترین",
      priceAsc: "ارزان‌ترین",
      priceDesc: "گران‌ترین",
      topRated: "بالاترین امتیاز",
      color: "رنگ",
      size: "سایز",
      qty: "تعداد",
      sku: "شناسه",
      stock: "موجودی",
      low: "تنها چند عدد مانده",
      out: "ناموجود",
      desc: "توضیحات",
      specs: "مشخصات",
      reviews: "نظرها",
      ship: "ارسال",
      related: "کالاهای مرتبط",
      coupon: "کد تخفیف",
      applyCoupon: "اعمال",
      couponOk: "کد DEMO10 اعمال شد.",
      couponBad: "این کد معتبر نیست.",
      discount: "تخفیف",
      shipping: "ارسال",
      tax: "مالیات",
      total: "مبلغ قابل پرداخت",
      place: "ثبت سفارش",
      notes: "یادداشت سفارش",
      required: "این فیلد را پر کنید.",
      invoice: "صورتحساب",
      thanks: "سفارش شما ثبت شد",
      print: "چاپ صورتحساب",
      backShop: "بازگشت به فروشگاه",
      guest: "مهمان اُرویو",
      dash: "داشبورد",
      orders: "سفارش‌ها",
      addresses: "آدرس‌ها",
      details: "اطلاعات حساب",
      logout: "خروج",
      login: "ورود",
      register: "ثبت‌نام",
      email: "ایمیل",
      password: "رمز عبور",
      name: "نام و نام خانوادگی",
      phone: "موبایل",
      province: "استان",
      city: "شهر",
      address: "آدرس",
      postal: "کد پستی",
      standard: "ارسال استاندارد",
      express: "ارسال سریع",
      cod: "پرداخت در محل",
      card: "کارت به کارت",
      online: "درگاه آنلاین (نمایشی)",
      hours: "شنبه تا پنجشنبه، ۱۰ تا ۱۸",
      send: "ارسال پیام",
      sent: "پیام شما ثبت شد. به زودی پاسخ می‌دهیم.",
      subscribe: "عضویت",
      subscribed: "به فهرست نامه‌ها اضافه شدید.",
      dock: "ظاهر دمو",
      accent: "رنگ تأکید",
      radius: "گوشه‌ها",
      header: "چیدمان هدر",
      card: "کارت کالا",
      classic: "کلاسیک",
      minimal: "مینیمال",
      overlay: "روی تصویر",
      soft: "نرم",
      sharp: "تیز",
      centered: "لوگوی وسط",
      standardH: "استاندارد",
      free: "رایگان",
      toman: "تومان",
      off: "تخفیف",
      page: "صفحه",
      quick: "نگاه سریع",
      chooseSize: "سایز را انتخاب کنید.",
      update: "به‌روزرسانی",
      emptyShop: "فروشگاه",
      catHome: "خانه و دکور",
      catFashion: "پوشاک",
      catAudio: "صدا",
      catScent: "رایحه",
      catTravel: "سفر"
    },
    en: {
      skip: "Skip to content",
      announce: "Free shipping over $45  ·  Easy 30-day returns",
      tagline: "Quiet objects",
      searchPh: "Search the edit…",
      search: "Search",
      account: "Account",
      wish: "Saved",
      cart: "Bag",
      allCats: "All categories",
      weekSale: "This week’s edit",
      menu: "Menu",
      close: "Close",
      shop: "Shop",
      about: "About",
      contact: "Contact",
      home: "Home",
      add: "Add to bag",
      added: "Added to your bag",
      wished: "Saved to wishlist",
      unwished: "Removed from wishlist",
      emptyCart: "Your bag is empty.",
      emptyWish: "Nothing saved yet.",
      continue: "Continue shopping",
      viewCart: "View bag",
      checkout: "Checkout",
      subtotal: "Subtotal",
      remove: "Remove",
      shipLeft: "away from free shipping",
      shipFree: "Shipping is free on this order.",
      results: "pieces",
      noResults: "Nothing matches these filters.",
      clear: "Clear filters",
      sort: "Sort",
      filters: "Filters",
      apply: "Apply",
      inStock: "In stock only",
      onSale: "Sale only",
      newest: "Newest",
      priceAsc: "Price: low to high",
      priceDesc: "Price: high to low",
      topRated: "Top rated",
      color: "Color",
      size: "Size",
      qty: "Qty",
      sku: "SKU",
      stock: "Stock",
      low: "Only a few left",
      out: "Sold out",
      desc: "Description",
      specs: "Details",
      reviews: "Reviews",
      ship: "Shipping",
      related: "You may also like",
      coupon: "Gift code",
      applyCoupon: "Apply",
      couponOk: "Code DEMO10 applied.",
      couponBad: "That code is not valid.",
      discount: "Discount",
      shipping: "Shipping",
      tax: "Tax",
      total: "Total",
      place: "Place order",
      notes: "Order note",
      required: "Please fill this field.",
      invoice: "Invoice",
      thanks: "Your order is in",
      print: "Print invoice",
      backShop: "Back to shop",
      guest: "Orvio guest",
      dash: "Dashboard",
      orders: "Orders",
      addresses: "Addresses",
      details: "Account details",
      logout: "Log out",
      login: "Sign in",
      register: "Create account",
      email: "Email",
      password: "Password",
      name: "Full name",
      phone: "Phone",
      province: "Region",
      city: "City",
      address: "Address",
      postal: "Postal code",
      standard: "Standard shipping",
      express: "Express shipping",
      cod: "Pay on delivery",
      card: "Bank transfer",
      online: "Online gateway (demo)",
      hours: "Sat–Thu, 10:00–18:00",
      send: "Send message",
      sent: "Message received. We’ll reply shortly.",
      subscribe: "Subscribe",
      subscribed: "You’re on the list.",
      dock: "Demo look",
      accent: "Accent",
      radius: "Corners",
      header: "Header",
      card: "Product card",
      classic: "Classic",
      minimal: "Minimal",
      overlay: "Overlay",
      soft: "Soft",
      sharp: "Sharp",
      centered: "Centered logo",
      standardH: "Standard",
      free: "Free",
      toman: "Toman",
      off: "Off",
      page: "Page",
      quick: "Quick look",
      chooseSize: "Choose a size.",
      update: "Update",
      emptyShop: "Shop",
      catHome: "Home",
      catFashion: "Apparel",
      catAudio: "Audio",
      catScent: "Scent",
      catTravel: "Travel"
    }
  };

  function lang() {
    return document.documentElement.lang === "en" ? "en" : "fa";
  }
  function t(key) {
    return (I18N[lang()] && I18N[lang()][key]) || I18N.fa[key] || key;
  }
  function faDigits(value) {
    return String(value).replace(/\d/g, function (d) { return "۰۱۲۳۴۵۶۷۸۹"[d]; });
  }
  function money(productOrAmount, usd) {
    if (lang() === "en") {
      var u = usd != null ? usd : (productOrAmount && productOrAmount.usd);
      if (u == null && typeof productOrAmount === "number") u = Math.round(productOrAmount / 45000);
      return "$" + u;
    }
    var n = typeof productOrAmount === "number" ? productOrAmount : productOrAmount.price;
    return faDigits(Math.round(n).toLocaleString("en-US")) + " تومان";
  }
  function byId(id) {
    return CATALOG.find(function (p) { return p.id === id; });
  }
  function read(key, fallback) {
    try { return JSON.parse(localStorage.getItem(key)) || fallback; } catch (e) { return fallback; }
  }
  function write(key, value) {
    localStorage.setItem(key, JSON.stringify(value));
  }
  function cart() { return read(CART_KEY, []); }
  function wish() { return read(WISH_KEY, []); }
  function nameOf(p) { return lang() === "en" ? p.en : p.fa; }
  function catName(id) {
    var map = { home: "catHome", fashion: "catFashion", audio: "catAudio", scent: "catScent", travel: "catTravel" };
    return t(map[id] || "shop");
  }
  function esc(s) {
    return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
  }
  function stars(v) {
    return '<span class="orvio-stars" style="--v:' + v + '" aria-label="' + v + '"><span class="orvio-stars__base">★★★★★</span><span class="orvio-stars__fill">★★★★★</span></span>';
  }
  function priceHTML(p) {
    var html = '<p class="orvio-price"><ins data-money="' + p.price + '" data-usd="' + p.usd + '">' + money(p.price, p.usd) + "</ins>";
    if (p.compare) html += '<del data-money="' + p.compare + '" data-usd="' + p.usdCompare + '">' + money(p.compare, p.usdCompare) + "</del>";
    html += "</p>";
    return html;
  }

  function applyLang(next) {
    if (next) localStorage.setItem(LANG_KEY, next);
    var current = localStorage.getItem(LANG_KEY) || "fa";
    document.documentElement.lang = current === "en" ? "en" : "fa";
    document.documentElement.dir = current === "en" ? "ltr" : "rtl";
    document.querySelectorAll("[data-i18n]").forEach(function (el) {
      var v = I18N[current][el.getAttribute("data-i18n")];
      if (v) el.textContent = v;
    });
    document.querySelectorAll("[data-i18n-placeholder]").forEach(function (el) {
      var v = I18N[current][el.getAttribute("data-i18n-placeholder")];
      if (v) el.setAttribute("placeholder", v);
    });
    document.querySelectorAll("[data-i18n-aria]").forEach(function (el) {
      var v = I18N[current][el.getAttribute("data-i18n-aria")];
      if (v) el.setAttribute("aria-label", v);
    });
    document.querySelectorAll("[data-fa]").forEach(function (el) {
      el.textContent = current === "en" ? (el.getAttribute("data-en") || el.textContent) : el.getAttribute("data-fa");
    });
    document.querySelectorAll("[data-money]").forEach(function (el) {
      el.textContent = money(Number(el.dataset.money), el.dataset.usd);
    });
    document.querySelectorAll("[data-lang]").forEach(function (b) {
      b.textContent = current === "fa" ? "EN" : "فا";
    });
    renderChrome();
    renderPage();
  }

  function lineKey(item) { return [item.id, item.color || "", item.size || ""].join("|"); }
  function addItem(id, qty, color, size) {
    var p = byId(id);
    if (!p) return;
    var items = cart();
    var found = items.find(function (i) { return i.id === id && (i.color || "") === (color || "") && (i.size || "") === (size || ""); });
    if (found) found.qty += qty;
    else items.push({ id: id, qty: qty, color: color || "", size: size || "" });
    write(CART_KEY, items);
    renderChrome();
    if (window.OrvioUI) window.OrvioUI.open("cart");
    if (window.OrvioUI) window.OrvioUI.toast(t("added"));
  }
  function setQty(key, qty) {
    var items = cart().map(function (i) { return lineKey(i) === key ? Object.assign({}, i, { qty: qty }) : i; }).filter(function (i) { return i.qty > 0; });
    write(CART_KEY, items);
    renderChrome();
    renderPage();
  }
  function removeItem(key) {
    write(CART_KEY, cart().filter(function (i) { return lineKey(i) !== key; }));
    renderChrome();
    renderPage();
  }
  function toggleWish(id) {
    var list = wish();
    var on = list.indexOf(id) === -1;
    list = on ? list.concat(id) : list.filter(function (x) { return x !== id; });
    write(WISH_KEY, list);
    renderChrome();
    if (window.OrvioUI) window.OrvioUI.toast(on ? t("wished") : t("unwished"));
  }
  function subtotal() {
    return cart().reduce(function (sum, i) {
      var p = byId(i.id);
      return sum + (p ? p.price * i.qty : 0);
    }, 0);
  }
  function subtotalUsd() {
    return cart().reduce(function (sum, i) {
      var p = byId(i.id);
      return sum + (p ? p.usd * i.qty : 0);
    }, 0);
  }
  function discountAmount() {
    var code = localStorage.getItem(COUPON_KEY);
    if (code === "DEMO10") return Math.round(subtotal() * 0.1);
    return 0;
  }
  function taxAmount() {
    return Math.round(Math.max(0, subtotal() - discountAmount()) * 0.09);
  }
  function taxAmountUsd() {
    return Math.round(Math.max(0, subtotalUsd() - (localStorage.getItem(COUPON_KEY) === "DEMO10" ? subtotalUsd() * 0.1 : 0)) * 0.09 * 100) / 100;
  }
  function shipCost(method) {
    var base = subtotal() - discountAmount();
    if (method === "express") return lang() === "en" ? 12 : 149000;
    if (base >= FREE_SHIP || (lang() === "en" && subtotalUsd() >= 45)) return 0;
    return lang() === "en" ? 6 : 89000;
  }

  function renderChrome() {
    var items = cart();
    var count = items.reduce(function (s, i) { return s + i.qty; }, 0);
    document.querySelectorAll("[data-cart-count]").forEach(function (el) {
      el.textContent = lang() === "fa" ? faDigits(count) : String(count);
      el.classList.toggle("is-zero", count === 0);
    });
    document.querySelectorAll("[data-cart-total]").forEach(function (el) {
      el.textContent = count ? money(subtotal(), subtotalUsd()) : (lang() === "fa" ? "۰" : "$0");
    });
    document.querySelectorAll("[data-wish-count]").forEach(function (el) {
      var n = wish().length;
      el.textContent = lang() === "fa" ? faDigits(n) : String(n);
      el.classList.toggle("is-zero", n === 0);
    });
    document.querySelectorAll("[data-wish]").forEach(function (btn) {
      btn.classList.toggle("is-on", wish().indexOf(btn.getAttribute("data-wish")) !== -1);
    });
    var box = document.querySelector("[data-cart-items]");
    if (box) box.innerHTML = items.length ? items.map(lineHTML).join("") : '<div class="orvio-empty"><p>' + esc(t("emptyCart")) + '</p><a class="orvio-btn orvio-btn--dark" href="shop.html">' + esc(t("continue")) + "</a></div>";
    var wishBox = document.querySelector("[data-wish-items]");
    if (wishBox) {
      var ws = wish().map(byId).filter(Boolean);
      wishBox.innerHTML = ws.length ? ws.map(function (p) {
        return '<div class="orvio-line"><a href="product.html?id=' + p.id + '"><img src="' + p.img + '" alt=""></a><div><h3><a href="product.html?id=' + p.id + '">' + esc(nameOf(p)) + "</a></h3>" + priceHTML(p) + '<div class="orvio-line__row"><button class="orvio-btn orvio-btn--sm orvio-btn--dark" data-add="' + p.id + '">' + esc(t("add")) + '</button><button class="orvio-line__remove" data-wish="' + p.id + '">' + esc(t("remove")) + "</button></div></div></div>";
      }).join("") : '<div class="orvio-empty"><p>' + esc(t("emptyWish")) + "</p></div>";
    }
    var sum = subtotal();
    var fill = document.querySelector("[data-ship-fill]");
    var shipText = document.querySelector("[data-ship-text]");
    if (fill) fill.style.width = Math.min(100, (sum / FREE_SHIP) * 100) + "%";
    if (shipText) {
      if (!items.length) shipText.textContent = "";
      else if (sum >= FREE_SHIP) shipText.textContent = t("shipFree");
      else shipText.textContent = money(FREE_SHIP - sum, Math.max(1, 45 - subtotalUsd())) + " " + t("shipLeft");
    }
    var sub = document.querySelector("[data-cart-subtotal]");
    if (sub) sub.textContent = money(sum, subtotalUsd());
  }

  function lineHTML(i) {
    var p = byId(i.id);
    if (!p) return "";
    var key = lineKey(i);
    var meta = [i.color, i.size].filter(Boolean).join(" · ");
    return '<div class="orvio-line"><a href="product.html?id=' + p.id + '"><img src="' + p.img + '" alt=""></a><div><h3><a href="product.html?id=' + p.id + '">' + esc(nameOf(p)) + "</a></h3>" + (meta ? '<div class="orvio-line__meta">' + esc(meta) + "</div>" : "") + '<div class="orvio-line__row"><div class="orvio-qty"><button type="button" data-qty="minus" data-line="' + esc(key) + '">−</button><input value="' + i.qty + '" inputmode="numeric" aria-label="qty" data-line-input="' + esc(key) + '"><button type="button" data-qty="plus" data-line="' + esc(key) + '">+</button></div><strong>' + money(p.price * i.qty, p.usd * i.qty) + '</strong></div><button class="orvio-line__remove" data-remove="' + esc(key) + '">' + esc(t("remove")) + "</button></div></div>";
  }

  function renderPage() {
    var page = document.body.dataset.page;
    if (page === "product") renderProduct();
    if (page === "cart") renderCartPage();
    if (page === "checkout") renderCheckout();
    if (page === "shop") applyShop();
    if (page === "account") renderAccountWish();
  }

  function renderProduct() {
    var root = document.getElementById("product-root");
    if (!root) return;
    var id = new URLSearchParams(location.search).get("id") || "kettle";
    var p = byId(id) || CATALOG[0];
    if (!p) return;
    document.title = nameOf(p) + " — Orvio";
    var gallery = p.gallery && p.gallery.length ? p.gallery : [p.img];
    var colors = (p.colors || []).map(function (c, idx) {
      return '<button type="button" class="orvio-swatch' + (idx === 0 ? " is-on" : "") + '" style="background:' + c.hex + '" data-color="' + esc(lang() === "en" ? c.en : c.fa) + '" aria-label="' + esc(c.en) + '"></button>';
    }).join("");
    var sizes = (p.sizes || []).map(function (s) {
      return '<button type="button" class="orvio-size" data-size="' + s + '">' + s + "</button>";
    }).join("");
    var specs = (p.specs || []).map(function (s) {
      return "<li><strong>" + esc(lang() === "en" ? s.en : s.fa) + ":</strong> " + esc(lang() === "en" ? s.ven : s.vfa) + "</li>";
    }).join("");
    var reviews = (p.reviewsList || []).map(function (r) {
      return '<article class="orvio-review"><strong>' + esc(lang() === "en" ? r.enName : r.faName) + "</strong>" + stars(r.rating) + "<p>" + esc(lang() === "en" ? r.en : r.fa) + "</p></article>";
    }).join("");
    var related = CATALOG.filter(function (x) { return x.cat === p.cat && x.id !== p.id; }).slice(0, 4);
    root.innerHTML =
      '<nav class="orvio-crumb"><a href="index.html">' + esc(t("home")) + '</a><span class="orvio-crumb__sep">/</span><a href="shop.html">' + esc(t("shop")) + '</a><span class="orvio-crumb__sep">/</span><a href="shop.html?cat=' + p.cat + '">' + esc(catName(p.cat)) + '</a><span class="orvio-crumb__sep">/</span><span>' + esc(nameOf(p)) + "</span></nav>" +
      '<div class="orvio-product"><div class="orvio-gallery" data-gallery><div class="orvio-gallery__main"><img data-main src="' + gallery[0] + '" alt="' + esc(nameOf(p)) + '"></div><div class="orvio-gallery__thumbs">' + gallery.map(function (src, i) {
        return '<button type="button" data-thumb data-src="' + src + '" class="' + (i === 0 ? "is-on" : "") + '"><img src="' + src + '" alt=""></button>';
      }).join("") + "</div></div>" +
      '<div class="orvio-summary"><a class="orvio-card__cat" href="shop.html?cat=' + p.cat + '">' + esc(catName(p.cat)) + "</a><h1>" + esc(nameOf(p)) + "</h1>" +
      '<div class="orvio-summary__rate">' + stars(p.rating) + "<span>" + (lang() === "fa" ? faDigits(p.rating) : p.rating) + " · " + (lang() === "fa" ? faDigits(p.reviews) : p.reviews) + " " + esc(t("reviews")) + "</span></div>" +
      priceHTML(p) +
      '<p class="orvio-lead">' + esc(lang() === "en" ? p.enLead : p.faLead) + "</p>" +
      (colors ? '<div class="orvio-option"><span>' + esc(t("color")) + '</span><div class="orvio-swatch-row">' + colors + "</div></div>" : "") +
      (sizes ? '<div class="orvio-option"><span>' + esc(t("size")) + '</span><div class="orvio-swatch-row">' + sizes + "</div></div>" : "") +
      '<div class="orvio-buy"><div class="orvio-qty"><button type="button" data-qty="minus">−</button><input value="1" inputmode="numeric" aria-label="qty"><button type="button" data-qty="plus">+</button></div><button class="orvio-btn orvio-btn--primary" data-add="' + p.id + '" data-needs-size="' + (sizes ? "1" : "0") + '">' + esc(t("add")) + '</button><button class="orvio-iconbtn" style="display:inline-flex;border:1px solid var(--line)" data-wish="' + p.id + '" aria-label="wish"><svg viewBox="0 0 24 24"><path d="M12 19s-7-4.4-7-8.5A3.5 3.5 0 0 1 12 8a3.5 3.5 0 0 1 7 2.5C19 14.6 12 19 12 19z"/></svg></button></div>' +
      '<div class="orvio-micro"><div><strong>' + esc(t("sku")) + "</strong>" + esc(p.sku) + "</div><div><strong>" + esc(t("stock")) + "</strong>" + (p.stock < 5 ? esc(t("low")) : (lang() === "fa" ? faDigits(p.stock) : p.stock)) + "</div></div>" +
      '<div class="orvio-acc"><details open><summary>' + esc(t("desc")) + "</summary><p>" + esc(lang() === "en" ? p.enBody : p.faBody) + "</p></details><details><summary>" + esc(t("specs")) + "</summary><ul>" + specs + "</ul></details><details><summary>" + esc(t("ship")) + "</summary><p>" + esc(lang() === "en" ? "Ships in 24–48 hours. Free over $45. 30-day returns on unused pieces." : "ارسال ۲۴ تا ۴۸ ساعته. رایگان برای سفارش‌های بالای ۲ میلیون تومان. بازگشت تا ۳۰ روز برای کالای استفاده نشده.") + "</p></details><details><summary>" + esc(t("reviews")) + "</summary>" + (reviews || "<p>—</p>") + "</details></div></div></div>" +
      (related.length ? '<section class="orvio-section"><div class="orvio-section__head"><h2>' + esc(t("related")) + "</h2></div><div class=\"orvio-grid\" style=\"--cols:4\">" + related.map(card).join("") + "</div></section>" : "") +
      '<div class="orvio-sticky-atc" data-sticky-atc><div><strong>' + esc(nameOf(p)) + "</strong><div>" + money(p.price, p.usd) + '</div></div><button class="orvio-btn orvio-btn--primary" data-add="' + p.id + '" data-needs-size="' + (sizes ? "1" : "0") + '">' + esc(t("add")) + "</button></div>";
    var sticky = root.querySelector("[data-sticky-atc]");
    var buy = root.querySelector(".orvio-buy");
    if (sticky && buy && "IntersectionObserver" in window) {
      var io = new IntersectionObserver(function (entries) {
        sticky.classList.toggle("is-on", !entries[0].isIntersecting);
      }, { threshold: 0.2 });
      io.observe(buy);
    }
    renderChrome();
  }

  function card(p) {
    var badge = "";
    if (p.compare) badge = '<span class="orvio-badge">−' + (lang() === "fa" ? faDigits(Math.round((1 - p.price / p.compare) * 100)) : Math.round((1 - p.price / p.compare) * 100)) + "%</span>";
    else if (p.isNew) badge = '<span class="orvio-badge orvio-badge--new">' + (lang() === "fa" ? "جدید" : "New") + "</span>";
    return '<article class="orvio-card" data-id="' + p.id + '" data-cat="' + p.cat + '" data-price="' + p.price + '" data-rating="' + p.rating + '" data-sale="' + (p.compare ? "1" : "0") + '" data-new="' + (p.isNew ? "1" : "0") + '"><div class="orvio-card__media"><a href="product.html?id=' + p.id + '" tabindex="-1"><img src="' + p.img + '" alt="' + esc(nameOf(p)) + '" width="800" height="800"></a>' + badge + '<button type="button" class="orvio-card__wish" data-wish="' + p.id + '" aria-label="wish"><svg viewBox="0 0 24 24"><path d="M12 19s-7-4.4-7-8.5A3.5 3.5 0 0 1 12 8a3.5 3.5 0 0 1 7 2.5C19 14.6 12 19 12 19z"/></svg></button><button type="button" class="orvio-card__quick" data-add="' + p.id + '">' + esc(t("add")) + '</button></div><div class="orvio-card__body"><a class="orvio-card__cat" href="shop.html?cat=' + p.cat + '">' + esc(catName(p.cat)) + '</a><h3 class="orvio-card__title"><a href="product.html?id=' + p.id + '">' + esc(nameOf(p)) + "</a></h3>" + stars(p.rating) + priceHTML(p) + "</div></article>";
  }

  function renderCartPage() {
    var root = document.getElementById("cart-root");
    if (!root) return;
    var items = cart();
    if (!items.length) {
      root.innerHTML = '<div class="orvio-empty orvio-panel"><h2>' + esc(t("emptyCart")) + '</h2><a class="orvio-btn orvio-btn--primary" href="shop.html">' + esc(t("continue")) + "</a></div>";
      return;
    }
    var disc = discountAmount();
    var ship = shipCost("standard");
    var tax = taxAmount();
    var taxUsd = taxAmountUsd();
    var total = subtotal() - disc + ship + tax;
    var totalUsd = subtotalUsd() - (localStorage.getItem(COUPON_KEY) === "DEMO10" ? Math.round(subtotalUsd() * 0.1) : 0) + (ship ? (lang() === "en" ? ship : 6) : 0) + taxUsd;
    root.innerHTML =
      '<div class="orvio-cartpage"><div class="orvio-panel"><h2 style="font-size:20px;letter-spacing:0;margin-bottom:6px">' + esc(t("cart")) + "</h2>" + items.map(function (i) {
        var p = byId(i.id);
        if (!p) return "";
        var key = lineKey(i);
        return '<article class="orvio-cart-item"><a href="product.html?id=' + p.id + '"><img src="' + p.img + '" alt=""></a><div class="orvio-cart-item__content"><div class="orvio-cart-item__top"><h3><a href="product.html?id=' + p.id + '">' + esc(nameOf(p)) + "</a></h3><div class=\"orvio-qty\"><button type=\"button\" data-qty=\"minus\" data-line=\"' + esc(key) + '\">−</button><input value=\"' + i.qty + '\" data-line-input=\"' + esc(key) + '\"><button type=\"button\" data-qty=\"plus\" data-line=\"' + esc(key) + '\">+</button></div></div><div class=\"orvio-line__meta\">" + esc([i.color, i.size].filter(Boolean).join(" · ")) + '</div><button class="orvio-line__remove" data-remove="' + esc(key) + '">' + esc(t("remove")) + "</button></div><strong>" + money(p.price * i.qty, p.usd * i.qty) + "</strong></article>";
      }).join("") + "</div>" +
      '<aside class="orvio-panel"><h2 style="font-size:18px;letter-spacing:0">' + esc(t("invoice")) + '</h2><div class="orvio-coupon"><input id="coupon-code" placeholder="DEMO10" aria-label="coupon"><button class="orvio-btn orvio-btn--dark orvio-btn--sm" data-coupon>' + esc(t("applyCoupon")) + "</button></div>" +
      '<div class="orvio-sum-row"><span>' + esc(t("subtotal")) + "</span><strong>" + money(subtotal(), subtotalUsd()) + "</strong></div>" +
      (disc ? '<div class="orvio-sum-row"><span>' + esc(t("discount")) + "</span><strong>−" + money(disc, Math.round(subtotalUsd() * 0.1)) + "</strong></div>" : "") +
      '<div class="orvio-sum-row"><span>' + esc(t("shipping")) + "</span><strong>" + (ship ? money(ship, lang() === "en" ? ship : 6) : esc(t("free"))) + "</strong></div>" +
      '<div class="orvio-sum-row"><span>' + esc(t("tax")) + "</span><strong>" + money(tax, taxUsd) + "</strong></div>" +
      '<div class="orvio-sum-row orvio-sum-row--total"><span>' + esc(t("total")) + "</span><span>" + money(total, lang() === "en" ? totalUsd : Math.round(total / 45000)) + '</span></div><a class="orvio-btn orvio-btn--primary orvio-btn--full" href="checkout.html">' + esc(t("checkout")) + '</a><p class="orvio-note" style="margin-top:8px">' + esc(t("shipFree")) + "</p></aside></div>" +
      '<section class="orvio-section"><div class="orvio-section__head"><h2>' + esc(t("related")) + '</h2></div><div class="orvio-grid" style="--cols:4">' + CATALOG.slice(0, 4).map(card).join("") + "</div></section>";
    var fillNote = root.querySelector(".orvio-note");
    if (fillNote && subtotal() < FREE_SHIP) fillNote.textContent = money(FREE_SHIP - subtotal(), Math.max(1, 45 - subtotalUsd())) + " " + t("shipLeft");
  }

  function renderCheckout() {
    var root = document.getElementById("checkout-root");
    if (!root) return;
    if (new URLSearchParams(location.search).get("ok") === "1") {
      renderInvoice(root);
      return;
    }
    if (!cart().length) {
      root.innerHTML = '<div class="orvio-empty orvio-panel"><h2>' + esc(t("emptyCart")) + '</h2><a class="orvio-btn orvio-btn--primary" href="shop.html">' + esc(t("shop")) + "</a></div>";
      return;
    }
    var provinces = lang() === "fa"
      ? ["تهران","البرز","اصفهان","فارس","خراسان رضوی","آذربایجان شرقی","آذربایجان غربی","مازندران","گیلان","یزد","کرمان","خوزستان","قم","قزوین","مرکزی","هرمزگان","سیستان و بلوچستان","کرمانشاه","همدان","لرستان","گلستان","اردبیل","زنجان","کردستان","بوشهر","سمنان","چهارمحال و بختیاری","کهگیلویه و بویراحمد","ایلام","خراسان شمالی","خراسان جنوبی"]
      : ["Tehran","Berlin","Paris","London","Istanbul","Dubai","New York","Toronto"];
    root.innerHTML =
      '<ol class="orvio-steps"><li class="is-on"><small>01</small>' + esc(t("details")) + '</li><li><small>02</small>' + esc(t("shipping")) + '</li><li><small>03</small>' + esc(t("online")) + "</li></ol>" +
      '<form class="orvio-checkout" id="checkout-form" novalidate><div><section class="orvio-panel"><h2 style="font-size:18px;letter-spacing:0;margin-bottom:12px">' + esc(t("details")) + '</h2><div class="orvio-fields">' +
      field("name", t("name"), "text", true) + field("phone", t("phone"), "tel", true) + field("email", t("email"), "email", true) +
      '<label class="orvio-field">' + esc(t("province")) + '<select name="province" required><option value="">—</option>' + provinces.map(function (p) { return "<option>" + esc(p) + "</option>"; }).join("") + "</select></label>" +
      field("city", t("city"), "text", true) + '<label class="orvio-field orvio-field--full">' + esc(t("address")) + '<textarea name="address" required></textarea></label>' + field("postal", t("postal"), "text", true) +
      "</div></section>" +
      '<section class="orvio-panel" style="margin-top:12px"><h2 style="font-size:18px;letter-spacing:0">' + esc(t("shipping")) + "</h2>" +
      shipOpt("standard", t("standard"), true) + shipOpt("express", t("express"), false) +
      '<h2 style="font-size:18px;letter-spacing:0;margin-top:16px">' + esc(t("online")) + "</h2>" +
      payOpt("cod", t("cod"), true) + payOpt("card", t("card"), false) + payOpt("online", t("online"), false) +
      '<label class="orvio-field" style="margin-top:12px">' + esc(t("notes")) + '<textarea name="notes"></textarea></label></section></div>' +
      '<aside class="orvio-panel" data-summary></aside></form>';
    paintSummary();
  }

  function field(name, label, type, req) {
    return '<label class="orvio-field' + (name === "email" ? " orvio-field--full" : "") + '">' + esc(label) + '<input name="' + name + '" type="' + type + '"' + (req ? " required" : "") + "></label>";
  }
  function shipOpt(val, label, on) {
    return '<label class="orvio-shipopt' + (on ? " is-on" : "") + '"><input type="radio" name="ship" value="' + val + '"' + (on ? " checked" : "") + "><span><strong>" + esc(label) + "</strong><small class=\"orvio-note\" data-ship-price=\"" + val + "\"></small></span></label>";
  }
  function payOpt(val, label, on) {
    return '<label class="orvio-payopt' + (on ? " is-on" : "") + '"><input type="radio" name="pay" value="' + val + '"' + (on ? " checked" : "") + "><span><strong>" + esc(label) + "</strong></span></label>";
  }
  function paintSummary() {
    var box = document.querySelector("[data-summary]");
    if (!box) return;
    var method = (document.querySelector('input[name="ship"]:checked') || {}).value || "standard";
    var disc = discountAmount();
    var ship = shipCost(method);
    var tax = taxAmount();
    var total = subtotal() - disc + ship + tax;
    document.querySelectorAll("[data-ship-price]").forEach(function (el) {
      var c = shipCost(el.getAttribute("data-ship-price"));
      el.textContent = c ? money(c, lang() === "en" ? c : Math.max(2, Math.round(c / 45000))) : t("free");
    });
    box.innerHTML = "<h2 style=\"font-size:18px;letter-spacing:0\">" + esc(t("invoice")) + "</h2>" + cart().map(function (i) {
      var p = byId(i.id);
      if (!p) return "";
      return '<div class="orvio-sum-row"><span>' + esc(nameOf(p)) + " × " + (lang() === "fa" ? faDigits(i.qty) : i.qty) + "</span><strong>" + money(p.price * i.qty, p.usd * i.qty) + "</strong></div>";
    }).join("") +
      '<div class="orvio-sum-row"><span>' + esc(t("shipping")) + "</span><strong>" + (ship ? money(ship, lang() === "en" ? ship : 6) : esc(t("free"))) + "</strong></div>" +
      '<div class="orvio-sum-row"><span>' + esc(t("tax")) + "</span><strong>" + money(tax, taxAmountUsd()) + "</strong></div>" +
      (disc ? '<div class="orvio-sum-row"><span>' + esc(t("discount")) + "</span><strong>−" + money(disc, Math.round(subtotalUsd() * 0.1)) + "</strong></div>" : "") +
      '<div class="orvio-sum-row orvio-sum-row--total"><span>' + esc(t("total")) + "</span><span>" + money(total, lang() === "en" ? Math.round(total / 45) : Math.round(total / 45000)) + "</span></div>" +
      '<button class="orvio-btn orvio-btn--primary orvio-btn--full" type="submit">' + esc(t("place")) + "</button>";
  }

  function renderInvoice(root) {
    var order = read(ORDER_KEY, null);
    if (!order) { location.href = "checkout.html"; return; }
    root.innerHTML = '<div class="orvio-invoice"><div class="orvio-invoice__top"><div><div class="orvio-okbadge">' + esc(t("thanks")) + "</div><h1 style=\"margin-top:8px;font-size:32px;letter-spacing:0\">" + esc(t("invoice")) + "</h1><p class=\"orvio-note\">ORV-" + esc(order.no) + "</p></div><div style=\"text-align:end\"><strong>ORVIO</strong><p class=\"orvio-note\">" + esc(order.date) + "</p></div></div><p><strong>" + esc(order.name) + "</strong><br>" + esc(order.phone) + "<br>" + esc(order.address) + "، " + esc(order.city) + "</p><table><thead><tr><th>" + esc(t("shop")) + "</th><th>" + esc(t("qty")) + "</th><th>" + esc(t("total")) + "</th></tr></thead><tbody>" + order.items.map(function (i) {
      return "<tr><td>" + esc(i.name) + "</td><td>" + esc(i.qty) + "</td><td>" + esc(i.total) + "</td></tr>";
    }).join("") + "</tbody></table><div class=\"orvio-sum-row orvio-sum-row--total\"><span>" + esc(t("total")) + "</span><span>" + esc(order.total) + "</span></div><div style=\"display:flex;gap:8px;margin-top:16px;flex-wrap:wrap\"><button class=\"orvio-btn orvio-btn--ghost\" onclick=\"print()\">" + esc(t("print")) + "</button><a class=\"orvio-btn orvio-btn--primary\" href=\"shop.html\">" + esc(t("backShop")) + "</a></div></div>";
  }

  function applyShop() {
    var grid = document.getElementById("shop-grid");
    if (!grid) return;
    var params = new URLSearchParams(location.search);
    var q = (params.get("q") || "").trim().toLowerCase();
    var cat = params.get("cat") || "";
    var saleOnly = params.get("sale") === "1";
    if (cat) {
      var input = document.querySelector('[data-filter="cat"][value="' + cat + '"]');
      if (input) input.checked = true;
    }
    if (saleOnly) {
      var sale = document.querySelector('[data-filter="sale"]');
      if (sale) sale.checked = true;
    }
    var search = document.querySelector("[data-shop-q]");
    if (search && q) search.value = q;
    filterShop();
  }

  function filterShop() {
    var grid = document.getElementById("shop-grid");
    if (!grid) return;
    var cats = [].slice.call(document.querySelectorAll('[data-filter="cat"]:checked')).map(function (i) { return i.value; });
    var sale = document.querySelector('[data-filter="sale"]');
    var stock = document.querySelector('[data-filter="stock"]');
    var max = document.querySelector("[data-price]");
    var color = (document.querySelector("[data-filter-color].is-on") || {}).dataset;
    color = color ? color.filterColor : "";
    var sort = (document.querySelector("[data-sort]") || {}).value || "newest";
    var q = ((document.querySelector("[data-shop-q]") || {}).value || new URLSearchParams(location.search).get("q") || "").trim().toLowerCase();
    var cards = [].slice.call(grid.querySelectorAll(".orvio-card"));
    var matched = cards.filter(function (card) {
      var p = byId(card.dataset.id);
      if (!p) return false;
      if (cats.length && cats.indexOf(p.cat) === -1) return false;
      if (sale && sale.checked && !p.compare) return false;
      if (stock && stock.checked && p.stock <= 0) return false;
      if (max && Number(card.dataset.price) > Number(max.value)) return false;
      if (color && (card.dataset.colors || "").indexOf(color) === -1) return false;
      if (q && (p.fa + " " + p.en + " " + p.cat).toLowerCase().indexOf(q) === -1) return false;
      return true;
    });
    matched.sort(function (a, b) {
      var pa = byId(a.dataset.id), pb = byId(b.dataset.id);
      if (sort === "priceAsc") return pa.price - pb.price;
      if (sort === "priceDesc") return pb.price - pa.price;
      if (sort === "rating") return pb.rating - pa.rating;
      return (pb.isNew - pa.isNew) || 0;
    });
    cards.forEach(function (c) { c.hidden = true; });
    matched.forEach(function (c) { c.hidden = false; grid.appendChild(c); });
    var count = document.querySelector("[data-count]");
    if (count) count.textContent = (lang() === "fa" ? faDigits(matched.length) : matched.length) + " " + t("results");
    var empty = document.querySelector("[data-shop-empty]");
    if (empty) empty.hidden = matched.length !== 0;
  }

  function renderAccountWish() {
    var box = document.querySelector("[data-account-wish]");
    if (!box) return;
    var ws = wish().map(byId).filter(Boolean);
    box.innerHTML = ws.length ? '<div class="orvio-grid" style="--cols:3">' + ws.map(card).join("") + "</div>" : "<p class=\"orvio-note\">" + esc(t("emptyWish")) + "</p>";
  }

  function suggest(input) {
    var panel = input.parentElement.querySelector("[data-suggest]") || document.querySelector("[data-suggest]");
    if (!panel) return;
    var q = input.value.trim().toLowerCase();
    if (q.length < 1) { panel.hidden = true; return; }
    var hits = CATALOG.filter(function (p) { return (p.fa + " " + p.en).toLowerCase().indexOf(q) !== -1; }).slice(0, 5);
    panel.hidden = false;
    panel.innerHTML = hits.length ? hits.map(function (p) {
      return '<a href="product.html?id=' + p.id + '"><img src="' + p.img + '" alt=""><span>' + esc(nameOf(p)) + "<small>" + money(p.price, p.usd) + "</small></span></a>";
    }).join("") : '<div class="orvio-suggest__empty">' + esc(t("noResults")) + "</div>";
  }

  function applyUI() {
    var ui = read(UI_KEY, {});
    document.documentElement.dataset.accent = ui.accent || "copper";
    document.documentElement.dataset.radius = ui.radius || "soft";
    document.body.classList.toggle("orvio-h-centered", ui.header === "centered");
    document.body.classList.remove("orvio-cards-minimal", "orvio-cards-overlay");
    if (ui.card && ui.card !== "classic") document.body.classList.add("orvio-cards-" + ui.card);
    document.querySelectorAll("[data-ui]").forEach(function (btn) {
      var on = ui[btn.dataset.ui] ? ui[btn.dataset.ui] === btn.dataset.val : btn.dataset.val === (btn.dataset.ui === "accent" ? "copper" : btn.dataset.ui === "radius" ? "soft" : btn.dataset.ui === "header" ? "standard" : "classic");
      btn.classList.toggle("is-on", on);
    });
  }

  document.addEventListener("click", function (e) {
    var langBtn = e.target.closest("[data-lang]");
    if (langBtn) {
      applyLang(lang() === "fa" ? "en" : "fa");
      return;
    }
    var add = e.target.closest("[data-add]");
    if (add && !add.closest("[data-wish-items] .orvio-line__remove")) {
      var id = add.getAttribute("data-add");
      var scope = add.closest(".orvio-summary, .orvio-sticky-atc") || document;
      var sizeBtn = document.querySelector(".orvio-summary .orvio-size.is-on");
      if (add.dataset.needsSize === "1" && !sizeBtn) {
        if (window.OrvioUI) window.OrvioUI.toast(t("chooseSize"));
        return;
      }
      var colorBtn = document.querySelector(".orvio-summary .orvio-swatch.is-on");
      var qtyInput = document.querySelector(".orvio-summary .orvio-qty input");
      var qty = qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;
      if (!add.closest(".orvio-summary") && !add.closest(".orvio-sticky-atc")) qty = 1;
      addItem(id, qty, colorBtn && add.closest(".orvio-summary, .orvio-sticky-atc") ? colorBtn.dataset.color : "", sizeBtn && add.closest(".orvio-summary, .orvio-sticky-atc") ? sizeBtn.dataset.size : "");
      return;
    }
    var wishBtn = e.target.closest("[data-wish]");
    if (wishBtn) { toggleWish(wishBtn.getAttribute("data-wish")); return; }
    var rem = e.target.closest("[data-remove]");
    if (rem) { removeItem(rem.getAttribute("data-remove")); return; }
    var sw = e.target.closest(".orvio-swatch");
    if (sw) {
      var was = sw.classList.contains("is-on");
      sw.parentElement.querySelectorAll(".orvio-swatch").forEach(function (b) { b.classList.remove("is-on"); });
      if (!was) sw.classList.add("is-on");
      if (sw.hasAttribute("data-filter-color")) filterShop();
      else sw.classList.add("is-on");
    }
    var sz = e.target.closest(".orvio-size");
    if (sz) {
      sz.parentElement.querySelectorAll(".orvio-size").forEach(function (b) { b.classList.remove("is-on"); });
      sz.classList.add("is-on");
    }
    var view = e.target.closest("[data-view]");
    if (view) {
      var grid = document.getElementById("shop-grid");
      if (grid) grid.classList.toggle("is-list", view.dataset.view === "list");
      document.querySelectorAll("[data-view]").forEach(function (b) { b.classList.toggle("is-on", b === view); });
    }
    if (e.target.closest("[data-coupon]")) {
      var code = (document.getElementById("coupon-code").value || "").trim().toUpperCase();
      if (code === "DEMO10") {
        localStorage.setItem(COUPON_KEY, "DEMO10");
        if (window.OrvioUI) window.OrvioUI.toast(t("couponOk"));
      } else {
        localStorage.removeItem(COUPON_KEY);
        if (window.OrvioUI) window.OrvioUI.toast(t("couponBad"));
      }
      renderPage();
    }
    var tab = e.target.closest("[data-tab]");
    if (tab) {
      document.querySelectorAll("[data-tab]").forEach(function (b) { b.classList.toggle("is-on", b === tab); });
      document.querySelectorAll("[data-panel]").forEach(function (p) { p.hidden = p.dataset.panel !== tab.dataset.tab; });
      if (tab.dataset.tab === "wish") renderAccountWish();
    }
    var ui = e.target.closest("[data-ui]");
    if (ui) {
      var state = read(UI_KEY, {});
      state[ui.dataset.ui] = ui.dataset.val;
      write(UI_KEY, state);
      applyUI();
    }
    var dock = e.target.closest("[data-dock-toggle]");
    if (dock) dock.parentElement.classList.toggle("is-open");
    var ship = e.target.closest(".orvio-shipopt, .orvio-payopt");
    if (ship) {
      var group = ship.classList.contains("orvio-shipopt") ? ".orvio-shipopt" : ".orvio-payopt";
      document.querySelectorAll(group).forEach(function (el) { el.classList.remove("is-on"); });
      ship.classList.add("is-on");
      paintSummary();
    }
    if (e.target.closest("[data-clear]")) {
      document.querySelectorAll("[data-filter]").forEach(function (i) { if (i.type === "checkbox") i.checked = false; if (i.type === "range") i.value = i.max; });
      var sq = document.querySelector("[data-shop-q]");
      if (sq) sq.value = "";
      filterShop();
    }
  });

  document.addEventListener("change", function (e) {
    if (e.target.matches("[data-line-input]")) setQty(e.target.dataset.lineInput, parseInt(e.target.value, 10) || 1);
    if (e.target.closest("[data-qty]") && e.target.closest("[data-line]")) {
      /* handled below */
    }
    if (e.target.matches("[data-filter], [data-sort], [data-price], [data-shop-q]")) filterShop();
    if (e.target.name === "ship") paintSummary();
  });

  document.addEventListener("input", function (e) {
    if (e.target.matches("[data-search]")) suggest(e.target);
    if (e.target.matches("[data-price]")) {
      var out = document.querySelector("[data-price-out]");
      if (out) out.textContent = money(Number(e.target.value), Math.round(Number(e.target.value) / 45000));
      filterShop();
    }
  });

  document.addEventListener("submit", function (e) {
    var form = e.target;
    if (form.matches(".orvio-search, [data-searchpanel] form")) {
      e.preventDefault();
      var q = (form.querySelector("input") || {}).value || "";
      location.href = "shop.html?q=" + encodeURIComponent(q);
      return;
    }
    if (form.id === "checkout-form") {
      e.preventDefault();
      if (!form.checkValidity()) {
        form.reportValidity();
        if (window.OrvioUI) window.OrvioUI.toast(t("required"));
        return;
      }
      var data = new FormData(form);
      var method = data.get("ship") || "standard";
      var disc = discountAmount();
      var ship = shipCost(method);
      var tax = taxAmount();
      var total = subtotal() - disc + ship + tax;
      var order = {
        no: String(2400 + Math.floor(Math.random() * 500)),
        date: new Date().toLocaleDateString(lang() === "fa" ? "fa-IR" : "en-GB"),
        name: data.get("name"),
        phone: data.get("phone"),
        address: data.get("address"),
        city: data.get("city"),
        total: money(total, lang() === "en" ? Math.round(total / 45) : Math.round(total / 45000)),
        items: cart().map(function (i) {
          var p = byId(i.id);
          return { name: nameOf(p), qty: lang() === "fa" ? faDigits(i.qty) : String(i.qty), total: money(p.price * i.qty, p.usd * i.qty) };
        })
      };
      write(ORDER_KEY, order);
      write(CART_KEY, []);
      localStorage.removeItem(COUPON_KEY);
      location.href = "checkout.html?ok=1";
    }
    if (form.id === "contact-form" || form.id === "news-form") {
      e.preventDefault();
      if (window.OrvioUI) window.OrvioUI.toast(form.id === "news-form" ? t("subscribed") : t("sent"));
      form.reset();
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    applyUI();
    applyLang(localStorage.getItem(LANG_KEY) || "fa");
  });
})();
