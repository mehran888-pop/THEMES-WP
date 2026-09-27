#!/usr/bin/env python3
"""Build the Orvio live demo pages from one catalog."""
import html
import json
from pathlib import Path

ROOT = Path(__file__).resolve().parent

def e(value):
    return html.escape(str(value), quote=True)

def fa_num(n):
    return f"{int(n):,}".translate(str.maketrans("0123456789", "۰۱۲۳۴۵۶۷۸۹"))

def money(n):
    return fa_num(n) + " تومان"

def off(price, compare):
    return round((1 - price / compare) * 100)

PRODUCTS = [
    {
        "id": "kettle", "fa": "کتری سرامیکی نُوا", "en": "Nova Ceramic Kettle", "cat": "home",
        "price": 1890000, "compare": 2200000, "usd": 42, "usdCompare": 49,
        "rating": 4.8, "reviews": 126, "sku": "ORV-KT-014", "stock": 8, "isNew": False,
        "img": "assets/images/products/kettle.jpg",
        "gallery": ["assets/images/products/kettle.jpg", "assets/images/products/kettle-detail.jpg", "assets/images/products/kettle-life.jpg"],
        "colors": [{"fa": "عاجی", "en": "Ivory", "hex": "#E7E1D6"}, {"fa": "زغالی", "en": "Charcoal", "hex": "#2C2926"}],
        "faLead": "کتری گوسنک برای دم‌آوری آرام. بدنه سرامیک مات، دسته گردو، و دهانه‌ای که جریان آب را دقیق نگه می‌دارد.",
        "enLead": "A gooseneck kettle for unhurried brewing. Matte ceramic, a walnut handle, and a spout that keeps the pour honest.",
        "faBody": "نُوا برای میزهایی ساخته شده که هر صبح از آن‌ها استفاده می‌شود. سرامیک حرارت را یکنواخت نگه می‌دارد و دسته گردو در دست گرم نمی‌شود. مناسب قهوه دمی و چای.",
        "enBody": "Nova is built for a table you actually use each morning. The ceramic holds heat evenly and the walnut handle stays comfortable. Made for pour-over and tea.",
        "specs": [
            {"fa": "جنس", "en": "Material", "vfa": "سرامیک مات و گردو", "ven": "Matte ceramic, walnut"},
            {"fa": "حجم", "en": "Capacity", "vfa": "۷۰۰ میلی‌لیتر", "ven": "700 ml"},
            {"fa": "مبدأ", "en": "Origin", "vfa": "کارگاه منتخب", "ven": "Selected workshop"},
        ],
        "reviewsList": [
            {"faName": "سارا م.", "enName": "Sara M.", "rating": 5, "fa": "جریان آب دقیقاً همان چیزی است که برای V60 می‌خواستم. سنگین و آرام است.", "en": "The pour is exactly what I wanted for a V60. Heavy, quiet, precise."},
            {"faName": "کیان ر.", "enName": "Kian R.", "rating": 4, "fa": "بسته‌بندی تمیز بود و دسته گردو واقعاً خوش‌دست است.", "en": "Packed carefully. The walnut handle feels considered."},
        ],
    },
    {
        "id": "teapot", "fa": "قوری سرامیکی آرام", "en": "Aram Ceramic Teapot", "cat": "home",
        "price": 1420000, "compare": None, "usd": 32, "usdCompare": None,
        "rating": 4.6, "reviews": 54, "sku": "ORV-TP-008", "stock": 14, "isNew": True,
        "img": "assets/images/products/kettle-side.jpg",
        "gallery": ["assets/images/products/kettle-side.jpg"],
        "colors": [{"fa": "شیری", "en": "Milk", "hex": "#F3EEE6"}, {"fa": "خاکی", "en": "Clay", "hex": "#C4B6A6"}],
        "faLead": "قوری دسته‌دار با در چوبی. برای چای عصر، نه برای ویترین.",
        "enLead": "A lidded pot with a wooden handle. Made for afternoon tea, not for a shelf.",
        "faBody": "فرم گرد، لعاب نرم و دسته‌ای که موقع ریختن تعادل را نگه می‌دارد. برای دو تا سه نفر کافی است.",
        "enBody": "A round body, a soft glaze, and a handle that stays balanced as you pour. Enough for two or three.",
        "specs": [
            {"fa": "جنس", "en": "Material", "vfa": "سرامیک و چوب", "ven": "Ceramic and wood"},
            {"fa": "حجم", "en": "Capacity", "vfa": "۶۵۰ میلی‌لیتر", "ven": "650 ml"},
        ],
        "reviewsList": [{"faName": "نگار", "enName": "Negar", "rating": 5, "fa": "لعابش زیر نور پنجره خیلی آرام است.", "en": "The glaze looks quiet in window light."}],
    },
    {
        "id": "lamp", "fa": "چراغ رومیزی بلوط", "en": "Oak Table Lamp", "cat": "home",
        "price": 1650000, "compare": None, "usd": 36, "usdCompare": None,
        "rating": 4.9, "reviews": 88, "sku": "ORV-LP-021", "stock": 11, "isNew": False,
        "img": "assets/images/products/lamp.jpg",
        "gallery": ["assets/images/products/lamp.jpg"],
        "colors": [{"fa": "بلوط", "en": "Oak", "hex": "#C6A57A"}, {"fa": "کتان", "en": "Linen", "hex": "#E6DCCB"}],
        "faLead": "پایه تراش‌خورده بلوط و شید کتان. نوری گرم برای میز کار و کنار مبل.",
        "enLead": "A turned oak base and a linen shade. Warm light for a desk or the side of a sofa.",
        "faBody": "ارتفاع متعادل، کلید پارچه‌ای، و شیدی که نور را پخش می‌کند نه اینکه بتاباند. هر پایه کمی تفاوت رگه‌های چوب دارد.",
        "enBody": "A balanced height, a cloth-covered switch, and a shade that diffuses rather than glares. Each base keeps its own grain.",
        "specs": [
            {"fa": "ارتفاع", "en": "Height", "vfa": "۴۲ سانتی‌متر", "ven": "42 cm"},
            {"fa": "سرپیچ", "en": "Bulb", "vfa": "E27، نور گرم", "ven": "E27, warm light"},
        ],
        "reviewsList": [{"faName": "هومن", "enName": "Hooman", "rating": 5, "fa": "شب‌ها میز کار را نرم می‌کند.", "en": "Softens the desk at night."}],
    },
    {
        "id": "table", "fa": "سرویس سنگی میز", "en": "Stoneware Table Set", "cat": "home",
        "price": 2980000, "compare": None, "usd": 66, "usdCompare": None,
        "rating": 4.7, "reviews": 41, "sku": "ORV-TW-033", "stock": 6, "isNew": False,
        "img": "assets/images/products/tableware.jpg",
        "gallery": ["assets/images/products/tableware.jpg", "assets/images/banners/table.jpg"],
        "colors": [{"fa": "جو دوسر", "en": "Oat", "hex": "#E4D7C4"}, {"fa": "دود", "en": "Smoke", "hex": "#B7A89A"}],
        "faLead": "بشقاب و کاسه با لعاب دانه‌دار. برای ناهار هر روز، نه فقط مهمانی.",
        "enLead": "Plates and a bowl in a speckled glaze. For everyday lunch, not only guests.",
        "faBody": "ست چهارنفره شامل بشقاب اصلی، پیش‌دستی و کاسه. لبه کمی نامنظم است؛ نشان دست است نه عیب.",
        "enBody": "A four-place set of dinner plates, side plates and bowls. The rim is slightly uneven on purpose.",
        "specs": [
            {"fa": "تعداد", "en": "Pieces", "vfa": "۱۲ تکه", "ven": "12 pieces"},
            {"fa": "ماشین ظرفشویی", "en": "Care", "vfa": "قابل شستشو", "ven": "Dishwasher safe"},
        ],
        "reviewsList": [{"faName": "لیلا", "enName": "Leila", "rating": 5, "fa": "رنگش با میز بلوط ما یکی شد.", "en": "The tone settled into our oak table."}],
    },
    {
        "id": "coat", "fa": "پالتو پشمی زغالی", "en": "Charcoal Wool Coat", "cat": "fashion",
        "price": 6800000, "compare": 7900000, "usd": 150, "usdCompare": 175,
        "rating": 4.9, "reviews": 63, "sku": "ORV-CT-102", "stock": 4, "isNew": False,
        "img": "assets/images/products/coat.jpg",
        "gallery": ["assets/images/products/coat.jpg", "assets/images/banners/atelier.jpg"],
        "colors": [{"fa": "زغالی", "en": "Charcoal", "hex": "#3A3A3A"}, {"fa": "شتری", "en": "Camel", "hex": "#A67C52"}],
        "sizes": ["S", "M", "L", "XL"],
        "faLead": "پالتوی پشم فشرده با برش مستقیم. سنگین به اندازه یک زمستان، نه بیشتر.",
        "enLead": "A dense wool coat with a straight cut. Heavy enough for winter, and no more.",
        "faBody": "آستر تیره، جیب‌های عمیق و دکمه‌های شاخ. برای شهر طراحی شده؛ روی شانه نمی‌لغزد.",
        "enBody": "A dark lining, deep pockets and horn buttons. Cut for the city; it stays on the shoulder.",
        "specs": [
            {"fa": "جنس", "en": "Material", "vfa": "پشم فشرده", "ven": "Dense wool"},
            {"fa": "قد", "en": "Length", "vfa": "زیر زانو", "ven": "Below the knee"},
        ],
        "reviewsList": [{"faName": "آرمان", "enName": "Arman", "rating": 5, "fa": "برش تمیز است و بعد از باران بوی نم نمی‌دهد.", "en": "Clean cut, and it doesn't smell of rain afterwards."}],
    },
    {
        "id": "sneaker", "fa": "کتانی چرم کرم", "en": "Cream Leather Sneaker", "cat": "fashion",
        "price": 2240000, "compare": None, "usd": 50, "usdCompare": None,
        "rating": 4.5, "reviews": 37, "sku": "ORV-SN-077", "stock": 18, "isNew": True,
        "img": "assets/images/products/sneaker.jpg",
        "gallery": ["assets/images/products/sneaker.jpg"],
        "colors": [{"fa": "کرم", "en": "Cream", "hex": "#F4F0E6"}, {"fa": "مشکی", "en": "Black", "hex": "#1C1916"}],
        "sizes": ["40", "41", "42", "43", "44"],
        "faLead": "کتانی چرم با کفی صمغی. مینیمال، برای هر روز.",
        "enLead": "A leather sneaker with a gum sole. Minimal, and meant for every day.",
        "faBody": "رویه‌ی چرم نرم، دوخت تمیز و کفی‌ای که شهر را تحمل می‌کند. قالب استاندارد است.",
        "enBody": "Soft leather, tidy stitching, and a sole that can take a city. Standard fit.",
        "specs": [
            {"fa": "رویه", "en": "Upper", "vfa": "چرم طبیعی", "ven": "Leather"},
            {"fa": "کفی", "en": "Sole", "vfa": "صمغی", "ven": "Gum"},
        ],
        "reviewsList": [{"faName": "مهدی", "enName": "Mehdi", "rating": 4, "fa": "قالب کمی تنگ است؛ یک سایز بزرگ‌تر بگیرید.", "en": "Runs slightly narrow. Size up."}],
    },
    {
        "id": "headphones", "fa": "هدفون بی‌سیم آرام", "en": "Aram Wireless Headphones", "cat": "audio",
        "price": 3150000, "compare": None, "usd": 70, "usdCompare": None,
        "rating": 4.8, "reviews": 210, "sku": "ORV-HP-019", "stock": 9, "isNew": True,
        "img": "assets/images/products/headphones.jpg",
        "gallery": ["assets/images/products/headphones.jpg"],
        "colors": [{"fa": "شن", "en": "Sand", "hex": "#D9CBB8"}, {"fa": "گرافیت", "en": "Graphite", "hex": "#4A463F"}],
        "faLead": "هدفونی با بدنه مات و حذف نویز ملایم. برای کار طولانی، نه برای هیاهو.",
        "enLead": "A matte headphone with gentle noise cancelling. For long work, not for spectacle.",
        "faBody": "باتری حدود ۳۰ ساعت، تا شدن تخت، و بالشتک‌هایی که گوش را فشار نمی‌دهند. میکروفون برای تماس کافی است.",
        "enBody": "About 30 hours of battery, a flat fold, and cushions that don't clamp. The mic is enough for calls.",
        "specs": [
            {"fa": "باتری", "en": "Battery", "vfa": "۳۰ ساعت", "ven": "30 hours"},
            {"fa": "اتصال", "en": "Connection", "vfa": "بلوتوث", "ven": "Bluetooth"},
        ],
        "reviewsList": [{"faName": "پریسا", "enName": "Parisa", "rating": 5, "fa": "در دفتر باز هم می‌توانم تمرکز کنم.", "en": "I can still focus in an open office."}],
    },
    {
        "id": "candle", "fa": "ست شمع دست‌ساز", "en": "Handmade Candle Set", "cat": "scent",
        "price": 780000, "compare": 920000, "usd": 18, "usdCompare": 22,
        "rating": 4.6, "reviews": 94, "sku": "ORV-CD-055", "stock": 3, "isNew": False,
        "img": "assets/images/products/candle.jpg",
        "gallery": ["assets/images/products/candle.jpg"],
        "colors": [{"fa": "انجیر", "en": "Fig", "hex": "#C4B48A"}, {"fa": "چوب", "en": "Wood", "hex": "#8C7355"}],
        "faLead": "سه شمع سویا در شیشه دودی. رایحه چوب، برگ و کمی انجیر.",
        "enLead": "Three soy candles in smoked glass. Wood, leaf, and a little fig.",
        "faBody": "سوخت تمیز، فتیله چوبی و شیشه‌ای که بعد از تمام شدن شمع هم روی میز می‌ماند.",
        "enBody": "A clean burn, a wood wick, and glass you'll keep after the wax is gone.",
        "specs": [
            {"fa": "زمان سوخت", "en": "Burn", "vfa": "حدود ۴۰ ساعت هر شیشه", "ven": "About 40 hours each"},
            {"fa": "موم", "en": "Wax", "vfa": "سویا", "ven": "Soy"},
        ],
        "reviewsList": [{"faName": "روژان", "enName": "Rozhan", "rating": 5, "fa": "رایحه‌اش شیرین نیست؛ دقیقاً همان چیزی که می‌خواستم.", "en": "Not sweet. Exactly the point."}],
    },
    {
        "id": "bag", "fa": "کیف چرم هفته", "en": "Weekender Leather Bag", "cat": "travel",
        "price": 4200000, "compare": None, "usd": 94, "usdCompare": None,
        "rating": 4.9, "reviews": 51, "sku": "ORV-BG-004", "stock": 5, "isNew": False,
        "img": "assets/images/products/bag.jpg",
        "gallery": ["assets/images/products/bag.jpg"],
        "colors": [{"fa": "کنیاک", "en": "Cognac", "hex": "#8C4A24"}, {"fa": "مشکی", "en": "Black", "hex": "#1C1916"}],
        "faLead": "کیف چرم فول‌گرین برای دو سه روز بیرون از خانه. یراق برنجی، فرم آرام.",
        "enLead": "A full-grain leather bag for two or three days away. Brass hardware, a calm shape.",
        "faBody": "بند شانه‌ی جداشونده، جیب داخلی لپ‌تاپ و چرمی که با استفاده تیره‌تر و زیباتر می‌شود.",
        "enBody": "A detachable shoulder strap, a laptop sleeve, and leather that darkens into something better.",
        "specs": [
            {"fa": "چرم", "en": "Leather", "vfa": "فول‌گرین", "ven": "Full grain"},
            {"fa": "جا لپ‌تاپ", "en": "Laptop", "vfa": "تا ۱۴ اینچ", "ven": "Up to 14 inch"},
        ],
        "reviewsList": [{"faName": "نیما", "enName": "Nima", "rating": 5, "fa": "برای سفر آخر هفته دقیقاً اندازه است.", "en": "Exactly the right size for a weekend."}],
    },
]

CATS = [
    ("home", "خانه و دکور", "Home", "assets/images/categories/home.jpg", True),
    ("fashion", "پوشاک", "Apparel", "assets/images/categories/fashion.jpg", False),
    ("audio", "صدا", "Audio", "assets/images/categories/audio.jpg", False),
    ("scent", "رایحه", "Scent", "assets/images/categories/scent.jpg", False),
    ("travel", "سفر", "Travel", "assets/images/categories/travel.jpg", False),
]

MEGA = {
    "home": [("اتاق نشیمن", "Living", ["چراغ‌ها", "Lamps", "سرامیک", "Ceramic", "پارچه", "Textile"]), ("میز غذا", "Table", ["سرویس", "Tableware", "شمع", "Candles"])],
    "fashion": [("رویی", "Outerwear", ["پالتو", "Coats", "کتانی", "Sneakers"]), ("جزئیات", "Details", ["چرم", "Leather", "پشم", "Wool"])],
    "audio": [("روزمره", "Everyday", ["هدفون", "Headphones", "بی‌سیم", "Wireless"]), ("کار", "Work", ["حذف نویز", "Noise cancelling"])],
    "scent": [("خانه", "Home", ["شمع", "Candles", "شیشه", "Glass"]), ("رایحه", "Notes", ["چوب", "Wood", "انجیر", "Fig"])],
    "travel": [("کیف", "Bags", ["هفته", "Weekender", "چرم", "Leather"]), ("یراق", "Hardware", ["برنج", "Brass"])],
}

def count(cat):
    return sum(1 for p in PRODUCTS if p["cat"] == cat)

def stars(v):
    return f'<span class="orvio-stars" style="--v:{v}"><span class="orvio-stars__base">★★★★★</span><span class="orvio-stars__fill">★★★★★</span></span>'

def card(p):
    badge = ""
    if p["compare"]:
        pct = off(p["price"], p["compare"])
        badge = f'<span class="orvio-badge" data-fa="−{fa_num(pct)}٪" data-en="−{pct}%">−{fa_num(pct)}٪</span>'
    elif p["isNew"]:
        badge = '<span class="orvio-badge orvio-badge--new" data-fa="جدید" data-en="New">جدید</span>'
    cat_fa = next(c[1] for c in CATS if c[0] == p["cat"])
    cat_en = next(c[2] for c in CATS if c[0] == p["cat"])
    compare = ""
    if p["compare"]:
        compare = f'<del data-money="{p["compare"]}" data-usd="{p["usdCompare"]}">{money(p["compare"])}</del>'
    colors = ",".join(c["hex"].lower() for c in p.get("colors") or [])
    return f'''<article class="orvio-card" data-id="{p["id"]}" data-cat="{p["cat"]}" data-price="{p["price"]}" data-rating="{p["rating"]}" data-sale="{1 if p["compare"] else 0}" data-new="{1 if p["isNew"] else 0}" data-colors="{colors}">
      <div class="orvio-card__media">
        <a href="product.html?id={p["id"]}" tabindex="-1"><img src="{p["img"]}" alt="{e(p["fa"])}" width="800" height="800" loading="lazy"></a>
        {badge}
        <button type="button" class="orvio-card__wish" data-wish="{p["id"]}" aria-label="علاقه‌مندی"><svg viewBox="0 0 24 24"><path d="M12 19s-7-4.4-7-8.5A3.5 3.5 0 0 1 12 8a3.5 3.5 0 0 1 7 2.5C19 14.6 12 19 12 19z"/></svg></button>
        <button type="button" class="orvio-card__quick" data-add="{p["id"]}" data-i18n="add">افزودن به سبد</button>
      </div>
      <div class="orvio-card__body">
        <a class="orvio-card__cat" href="shop.html?cat={p["cat"]}" data-fa="{e(cat_fa)}" data-en="{e(cat_en)}">{e(cat_fa)}</a>
        <h3 class="orvio-card__title"><a href="product.html?id={p["id"]}" data-fa="{e(p["fa"])}" data-en="{e(p["en"])}">{e(p["fa"])}</a></h3>
        {stars(p["rating"])}
        <p class="orvio-price"><ins data-money="{p["price"]}" data-usd="{p["usd"]}">{money(p["price"])}</ins>{compare}</p>
      </div>
    </article>'''

SVG = {
    "search": '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="M16.2 16.2L20 20"/></svg>',
    "user": '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5.2 19.2c1.3-3 3.7-4.5 6.8-4.5s5.5 1.5 6.8 4.5"/></svg>',
    "heart": '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19s-7-4.4-7-8.5A3.5 3.5 0 0 1 12 8a3.5 3.5 0 0 1 7 2.5C19 14.6 12 19 12 19z"/></svg>',
    "bag": '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 8h11L16.4 20H7.6L6.5 8z"/><path d="M9 8V7a3 3 0 0 1 6 0v1"/></svg>',
    "menu": '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h11"/></svg>',
    "grid": '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>',
    "chev": '<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>',
    "truck": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z"/><circle cx="7" cy="17.5" r="1.4"/><circle cx="17" cy="17.5" r="1.4"/></svg>',
    "back": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 12h16M8 8l-4 4 4 4"/></svg>',
    "shield": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3l7 3v6c0 4.5-3 7-7 9-4-2-7-4.5-7-9V6z"/></svg>',
    "check": '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="8"/><path d="M8.5 12.5l2.2 2.2 4.8-5"/></svg>',
}

def logo():
    return '''<span class="orvio-logo__mark" aria-hidden="true"><svg viewBox="0 0 32 32"><circle cx="16" cy="16" r="8" fill="none" stroke="#F4F0EA" stroke-width="1.6"/><circle cx="16" cy="16" r="2.4" fill="#C46A3A"/></svg></span>'''

def mega(cat):
    cols = MEGA[cat]
    html_cols = ""
    for fa, en, links in cols:
        items = "".join(
            f'<a href="shop.html?cat={cat}" data-fa="{e(links[i])}" data-en="{e(links[i+1])}">{e(links[i])}</a>'
            for i in range(0, len(links), 2)
        )
        html_cols += f'<div class="orvio-mega__col"><strong data-fa="{e(fa)}" data-en="{e(en)}">{e(fa)}</strong>{items}</div>'
    img = next(c[3] for c in CATS if c[0] == cat)
    label_fa = next(c[1] for c in CATS if c[0] == cat)
    label_en = next(c[2] for c in CATS if c[0] == cat)
    return f'''<div class="orvio-mega"><div class="orvio-mega__grid">{html_cols}<a class="orvio-mega__feature" href="shop.html?cat={cat}"><img src="{img}" alt=""><span data-fa="{e(label_fa)}" data-en="{e(label_en)}">{e(label_fa)}</span></a></div></div>'''

def header():
    cat_links = ""
    all_links = ""
    for cid, fa, en, img, _feat in CATS:
        cat_links += f'<li><a href="shop.html?cat={cid}" data-fa="{e(fa)}" data-en="{e(en)}">{e(fa)}</a>{mega(cid)}</li>'
        all_links += f'<a href="shop.html?cat={cid}"><span data-fa="{e(fa)}" data-en="{e(en)}">{e(fa)}</span><span>{count(cid)}</span></a>'
    menu_acc = "".join(
        f'<details><summary data-fa="{e(fa)}" data-en="{e(en)}">{e(fa)}</summary><a href="shop.html?cat={cid}" data-i18n="shop">فروشگاه</a></details>'
        for cid, fa, en, img, _ in CATS
    )
    return f'''<a class="orvio-skip" href="#main" data-i18n="skip">پرش به محتوا</a>
<div class="orvio-announce" data-announce>
  <div class="orvio-container orvio-announce__inner">
    <p data-i18n="announce">ارسال رایگان برای سفارش‌های بالای ۲ میلیون تومان  ·  بازگشت آسان تا ۳۰ روز</p>
    <button type="button" class="orvio-announce__x" data-announce-close data-i18n-aria="close" aria-label="بستن">×</button>
  </div>
</div>
<header class="orvio-header" data-header>
  <div class="orvio-container orvio-header__row">
    <button type="button" class="orvio-iconbtn orvio-burger" data-open="menu" data-i18n-aria="menu" aria-label="منو">{SVG["menu"]}</button>
    <a class="orvio-logo" href="index.html">{logo()}<span class="orvio-logo__word"><strong>ORVIO</strong><small data-i18n="tagline">اشیاء آرام</small></span></a>
    <form class="orvio-search" role="search" action="shop.html">
      <span class="orvio-search__icon">{SVG["search"]}</span>
      <input type="search" name="q" data-search data-i18n-placeholder="searchPh" placeholder="جستجو میان اشیاء…" autocomplete="off">
      <button type="submit" data-i18n="search">جستجو</button>
      <div class="orvio-suggest" data-suggest hidden></div>
    </form>
    <button type="button" class="orvio-iconbtn orvio-search-toggle" data-open="search" data-i18n-aria="search" aria-label="جستجو">{SVG["search"]}</button>
    <div class="orvio-tools">
      <button type="button" class="orvio-tool orvio-lang" data-lang>EN</button>
      <a class="orvio-tool" href="account.html"><span class="orvio-tool__icon">{SVG["user"]}</span><span class="orvio-tool__label" data-i18n="account">حساب</span></a>
      <button type="button" class="orvio-tool" data-open="wish"><span class="orvio-tool__icon">{SVG["heart"]}<span class="orvio-count is-zero" data-wish-count>0</span></span><span class="orvio-tool__label" data-i18n="wish">علاقه‌مندی</span></button>
      <button type="button" class="orvio-tool orvio-cartbtn" data-open="cart"><span class="orvio-tool__icon">{SVG["bag"]}<span class="orvio-count is-zero" data-cart-count>0</span></span><span class="orvio-tool__meta"><span class="orvio-tool__label" data-i18n="cart">سبد</span><span class="orvio-cartbtn__total" data-cart-total>۰</span></span></button>
    </div>
  </div>
  <div class="orvio-searchpanel" data-searchpanel>
    <form class="orvio-container" action="shop.html">
      <div class="orvio-search" style="display:flex">
        <span class="orvio-search__icon">{SVG["search"]}</span>
        <input type="search" name="q" data-search data-i18n-placeholder="searchPh" placeholder="جستجو میان اشیاء…">
        <button type="submit" data-i18n="search">جستجو</button>
        <div class="orvio-suggest" data-suggest hidden></div>
      </div>
    </form>
  </div>
  <nav class="orvio-catbar" aria-label="categories">
    <div class="orvio-container orvio-catbar__row">
      <div class="orvio-catall">
        <button type="button" class="orvio-catall__btn" data-catall>{SVG["grid"]}<span data-i18n="allCats">همه دسته‌ها</span>{SVG["chev"]}</button>
        <div class="orvio-catall__panel">{all_links}</div>
      </div>
      <ul class="orvio-catbar__menu">{cat_links}</ul>
      <a class="orvio-catbar__sale" href="shop.html?sale=1" data-i18n="weekSale">تخفیف‌های هفته</a>
    </div>
  </nav>
</header>
<div class="orvio-overlay" data-overlay></div>
<aside class="orvio-drawer orvio-drawer--menu" data-drawer="menu" aria-hidden="true">
  <div class="orvio-drawer__head"><h2 data-i18n="menu">منو</h2><button type="button" class="orvio-drawer__x" data-close aria-label="بستن">×</button></div>
  <div class="orvio-drawer__body">
    <button type="button" class="orvio-btn orvio-btn--ghost orvio-btn--sm" data-lang style="margin-bottom:12px">EN</button>
    <form action="shop.html" class="orvio-search" style="display:flex;margin-bottom:12px">
      <input type="search" name="q" data-i18n-placeholder="searchPh" placeholder="جستجو میان اشیاء…">
      <button type="submit" data-i18n="search">جستجو</button>
    </form>
    <div class="orvio-menu-acc">{menu_acc}</div>
    <div class="orvio-menu-links">
      <a href="shop.html" data-i18n="shop">فروشگاه</a>
      <a href="account.html" data-i18n="account">حساب</a>
      <a href="about.html" data-i18n="about">درباره ما</a>
      <a href="contact.html" data-i18n="contact">ارتباط با ما</a>
      <a href="theme.html" data-fa="قالب وردپرس" data-en="WordPress theme">قالب وردپرس</a>
    </div>
  </div>
</aside>
<aside class="orvio-drawer orvio-drawer--cart" data-drawer="cart" aria-hidden="true">
  <div class="orvio-drawer__head"><h2 data-i18n="cart">سبد</h2><button type="button" class="orvio-drawer__x" data-close>×</button></div>
  <div class="orvio-shipbar"><div class="orvio-shipbar__track"><span data-ship-fill></span></div><p data-ship-text></p></div>
  <div class="orvio-drawer__body" data-cart-items></div>
  <div class="orvio-drawer__foot">
    <div class="orvio-drawer__total"><span data-i18n="subtotal">جمع جزء</span><strong data-cart-subtotal>۰</strong></div>
    <a class="orvio-btn orvio-btn--ghost orvio-btn--full" href="cart.html" data-i18n="viewCart">مشاهده سبد</a>
    <a class="orvio-btn orvio-btn--primary orvio-btn--full" href="checkout.html" data-i18n="checkout">تسویه و صورتحساب</a>
  </div>
</aside>
<aside class="orvio-drawer orvio-drawer--wish" data-drawer="wish" aria-hidden="true">
  <div class="orvio-drawer__head"><h2 data-i18n="wish">علاقه‌مندی</h2><button type="button" class="orvio-drawer__x" data-close>×</button></div>
  <div class="orvio-drawer__body" data-wish-items></div>
</aside>
<div class="orvio-toast" data-toast role="status"></div>
<a class="orvio-themechip" href="theme.html" data-fa="قالب وردپرس" data-en="WordPress theme">قالب وردپرس</a>
<aside class="orvio-dock" data-dock>
  <button type="button" class="orvio-dock__toggle" data-dock-toggle data-i18n="dock">ظاهر دمو</button>
  <div class="orvio-dock__panel">
    <strong data-i18n="accent">رنگ تأکید</strong>
    <div class="orvio-swatches-ui">
      <button type="button" data-ui="accent" data-val="copper" style="background:#A34B2B" aria-label="copper"></button>
      <button type="button" data-ui="accent" data-val="forest" style="background:#234237" aria-label="forest"></button>
      <button type="button" data-ui="accent" data-val="ink" style="background:#1C1916" aria-label="ink"></button>
      <button type="button" data-ui="accent" data-val="navy" style="background:#1E3A5F" aria-label="navy"></button>
      <button type="button" data-ui="accent" data-val="wine" style="background:#7A2E3A" aria-label="wine"></button>
    </div>
    <strong data-i18n="header">چیدمان هدر</strong>
    <div class="orvio-seg">
      <button type="button" data-ui="header" data-val="standard" data-i18n="standardH">استاندارد</button>
      <button type="button" data-ui="header" data-val="centered" data-i18n="centered">لوگوی وسط</button>
    </div>
    <strong data-i18n="card">کارت کالا</strong>
    <div class="orvio-seg">
      <button type="button" data-ui="card" data-val="classic" data-i18n="classic">کلاسیک</button>
      <button type="button" data-ui="card" data-val="minimal" data-i18n="minimal">مینیمال</button>
      <button type="button" data-ui="card" data-val="overlay" data-i18n="overlay">روی تصویر</button>
    </div>
    <strong data-i18n="radius">گوشه‌ها</strong>
    <div class="orvio-seg">
      <button type="button" data-ui="radius" data-val="soft" data-i18n="soft">نرم</button>
      <button type="button" data-ui="radius" data-val="sharp" data-i18n="sharp">تیز</button>
    </div>
  </div>
</aside>'''

def footer():
    return '''<footer class="orvio-footer">
  <div class="orvio-container orvio-footer__grid">
    <div class="orvio-footer__brand">
      <a class="orvio-logo" href="index.html" style="color:#fff"><span class="orvio-logo__mark" aria-hidden="true"><svg viewBox="0 0 32 32" width="22" height="22"><circle cx="16" cy="16" r="8" fill="none" stroke="#F4F0EA" stroke-width="1.6"/><circle cx="16" cy="16" r="2.4" fill="#C46A3A"/></svg></span><span class="orvio-logo__word"><strong>ORVIO</strong></span></a>
      <p data-fa="ویترینی از اشیاء روزمره؛ انتخاب‌شده برای دوام، سکوت و زیبایی بی‌هیاهو." data-en="A shop of everyday objects, chosen to last and to stay quiet.">ویترینی از اشیاء روزمره؛ انتخاب‌شده برای دوام، سکوت و زیبایی بی‌هیاهو.</p>
      <div class="orvio-social">
        <a href="https://instagram.com" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="4" y="4" width="16" height="16" rx="4"/><circle cx="12" cy="12" r="3.5"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/></svg></a>
        <a href="https://t.me" aria-label="Telegram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 12l16-7-4 16-5-5-7-4z"/></svg></a>
        <a href="https://wa.me/989100000042" aria-label="WhatsApp"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M6 18l-1 4 4-1a8 8 0 1 0-3-3z"/></svg></a>
      </div>
      <div class="orvio-pay"><span>COD</span><span>CARD</span><span>TRANSFER</span><span>GATEWAY</span></div>
    </div>
    <div>
      <h3 data-i18n="shop">فروشگاه</h3>
      <ul>
        <li><a href="shop.html?cat=home" data-fa="خانه و دکور" data-en="Home">خانه و دکور</a></li>
        <li><a href="shop.html?cat=fashion" data-fa="پوشاک" data-en="Apparel">پوشاک</a></li>
        <li><a href="shop.html?cat=audio" data-fa="صدا" data-en="Audio">صدا</a></li>
        <li><a href="shop.html?cat=scent" data-fa="رایحه" data-en="Scent">رایحه</a></li>
        <li><a href="shop.html?cat=travel" data-fa="سفر" data-en="Travel">سفر</a></li>
        <li><a href="shop.html?sale=1" data-i18n="weekSale">تخفیف‌های هفته</a></li>
      </ul>
    </div>
    <div>
      <h3 data-fa="راهنما" data-en="Help">راهنما</h3>
      <ul>
        <li><a href="account.html" data-i18n="account">حساب</a></li>
        <li><a href="cart.html" data-i18n="cart">سبد</a></li>
        <li><a href="checkout.html" data-i18n="checkout">تسویه و صورتحساب</a></li>
        <li><a href="about.html" data-i18n="about">درباره ما</a></li>
        <li><a href="contact.html" data-i18n="contact">ارتباط با ما</a></li>
        <li><a href="theme.html" data-fa="قالب وردپرس" data-en="WordPress theme">قالب وردپرس</a></li>
      </ul>
    </div>
    <div>
      <h3 data-i18n="contact">ارتباط با ما</h3>
      <ul>
        <li data-fa="تهران، خیابان طراحی، پلاک ۱۲" data-en="12 Design Street, Tehran">تهران، خیابان طراحی، پلاک ۱۲</li>
        <li><a href="tel:+982191000042">۰۲۱−۹۱۰۰۰۰۴۲</a></li>
        <li><a href="mailto:hello@orvio.shop">hello@orvio.shop</a></li>
        <li data-i18n="hours">شنبه تا پنجشنبه، ۱۰ تا ۱۸</li>
      </ul>
    </div>
  </div>
  <div class="orvio-container orvio-footer__bottom">
    <span data-fa="© اُرویو — همه حقوق برای نسخه نمایشی محفوظ نیست." data-en="© Orvio — demo store, not a real checkout.">© اُرویو — همه حقوق برای نسخه نمایشی محفوظ نیست.</span>
    <span>ORVIO THEME</span>
  </div>
</footer>'''

def shell(page, title, body, extra=""):
    return f'''<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{e(title)}</title>
  <meta name="description" content="Orvio — قالب فروشگاهی ووکامرس با پشتیبانی المنتور">
  <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="orvio-body" data-page="{page}">
<div class="orvio-themebar"><div class="orvio-container">
  <p data-fa="این صفحه، ظاهر قالب وردپرس Orvio است." data-en="This page is the face of the Orvio WordPress theme.">این صفحه، ظاهر قالب وردپرس Orvio است.</p>
  <a href="theme.html" data-fa="خود قالب" data-en="The theme">خود قالب</a>
  <a href="orvio.zip" download data-fa="دانلود پوسته" data-en="Download theme">دانلود پوسته</a>
</div></div>
{header()}
<main id="main">{body}</main>
{footer()}
<script src="catalog.js"></script>
<script src="assets/js/theme.js" defer></script>
<script src="demo.js" defer></script>
{extra}
</body>
</html>
'''

def home():
    cats = ""
    for cid, fa, en, img, feat in CATS:
        cats += f'<a class="orvio-catcard{" orvio-catcard--feature" if feat else ""}" href="shop.html?cat={cid}"><img src="{img}" alt="{e(fa)}"><span data-fa="{e(fa)}" data-en="{e(en)}">{e(fa)}</span></a>'
    news = "".join(card(p) for p in PRODUCTS[:8])
    best = "".join(card(p) for p in sorted(PRODUCTS, key=lambda p: -p["rating"])[:8])
    kettle = PRODUCTS[0]
    return f'''
<section class="orvio-hero"><div class="orvio-container orvio-hero__grid">
  <div class="orvio-hero__copy">
    <p class="orvio-kicker" data-fa="مجموعه پاییز" data-en="Autumn edit">مجموعه پاییز</p>
    <h1 data-fa="اشیائی برای خانه‌ای که آرام است" data-en="Objects for a quieter house">اشیائی برای خانه‌ای که آرام است</h1>
    <p class="orvio-lead" data-fa="اُرویو ویترینی از سرامیک، چرم، پشم و نور است. هر قطعه را برای دوام و سکوت انتخاب کرده‌ایم، نه برای هیاهوی فصل." data-en="Orvio is a considered shop of ceramic, leather, wool and light. Chosen to last, not to shout.">اُرویو ویترینی از سرامیک، چرم، پشم و نور است. هر قطعه را برای دوام و سکوت انتخاب کرده‌ایم، نه برای هیاهوی فصل.</p>
    <div class="orvio-hero__actions">
      <a class="orvio-btn orvio-btn--primary" href="shop.html" data-fa="ورود به فروشگاه" data-en="Enter the shop">ورود به فروشگاه</a>
      <a class="orvio-btn orvio-btn--ghost" href="about.html" data-i18n="about">درباره ما</a>
    </div>
    <ul class="orvio-hero__stats">
      <li><strong data-fa="۴۸ ساعت" data-en="48 hrs">۴۸ ساعت</strong><span data-fa="ارسال بیشتر شهرها" data-en="to most cities">ارسال بیشتر شهرها</span></li>
      <li><strong data-fa="۳۰ روز" data-en="30 days">۳۰ روز</strong><span data-fa="بازگشت آسان" data-en="easy returns">بازگشت آسان</span></li>
      <li><strong>۱۲۰+</strong><span data-fa="قطعه منتخب" data-en="edited pieces">قطعه منتخب</span></li>
    </ul>
  </div>
  <div class="orvio-hero__media">
    <img src="assets/images/hero.jpg" alt="" width="1600" height="900">
    <a class="orvio-hero__float" href="product.html?id=kettle">
      <img src="{kettle["img"]}" alt="">
      <span><small data-fa="پرفروش هفته" data-en="This week">پرفروش هفته</small><strong data-fa="{e(kettle["fa"])}" data-en="{e(kettle["en"])}">{e(kettle["fa"])}</strong><em data-money="{kettle["price"]}" data-usd="{kettle["usd"]}">{money(kettle["price"])}</em></span>
    </a>
  </div>
</div></section>
<section class="orvio-container orvio-trust">
  <div class="orvio-trust__item"><span class="orvio-trust__ico">{SVG["truck"]}</span><div><strong data-fa="ارسال سراسری" data-en="Nationwide shipping">ارسال سراسری</strong><span data-fa="بیشتر شهرها تا ۴۸ ساعت" data-en="Most cities in 48 hours">بیشتر شهرها تا ۴۸ ساعت</span></div></div>
  <div class="orvio-trust__item"><span class="orvio-trust__ico">{SVG["back"]}</span><div><strong data-fa="بازگشت آسان" data-en="Easy returns">بازگشت آسان</strong><span data-fa="تا ۳۰ روز، بدون پیچیدگی" data-en="30 days, no theatre">تا ۳۰ روز، بدون پیچیدگی</span></div></div>
  <div class="orvio-trust__item"><span class="orvio-trust__ico">{SVG["shield"]}</span><div><strong data-fa="پرداخت امن" data-en="Secure payment">پرداخت امن</strong><span data-fa="درگاه، کارت‌به‌کارت، در محل" data-en="Gateway, transfer, on delivery">درگاه، کارت‌به‌کارت، در محل</span></div></div>
  <div class="orvio-trust__item"><span class="orvio-trust__ico">{SVG["check"]}</span><div><strong data-fa="بررسی دستی" data-en="Checked by hand">بررسی دستی</strong><span data-fa="هر قطعه پیش از ارسال" data-en="Every piece, before it ships">هر قطعه پیش از ارسال</span></div></div>
</section>
<section class="orvio-section"><div class="orvio-container">
  <div class="orvio-section__head"><div><p class="orvio-kicker" data-fa="دسته‌ها" data-en="Categories">دسته‌ها</p><h2 data-fa="از میز تا کمد" data-en="From the table to the coat">از میز تا کمد</h2></div><a href="shop.html" data-fa="همه کالاها" data-en="All pieces">همه کالاها</a></div>
  <div class="orvio-cats">{cats}</div>
</div></section>
<section class="orvio-section" style="padding-top:10px"><div class="orvio-container">
  <div class="orvio-section__head"><div><p class="orvio-kicker" data-fa="تازه‌ها" data-en="New in">تازه‌ها</p><h2 data-fa="به ویترین اضافه شد" data-en="Just added to the edit">به ویترین اضافه شد</h2></div><a href="shop.html" data-i18n="shop">فروشگاه</a></div>
  <div class="orvio-grid" style="--cols:4">{news}</div>
</div></section>
<section class="orvio-section" style="padding-top:8px"><div class="orvio-container">
  <article class="orvio-banner orvio-banner--split">
    <img src="assets/images/banners/living.jpg" alt="">
    <div class="orvio-banner__copy">
      <p class="orvio-kicker" style="color:#E7C3B0" data-fa="خانه" data-en="Home">خانه</p>
      <h2 data-fa="نور، چوب، و یک عصر آرام" data-en="Light, oak, and a quiet evening">نور، چوب، و یک عصر آرام</h2>
      <p data-fa="چراغ بلوط و سرویس سنگی، برای میزی که هر روز از آن استفاده می‌کنید." data-en="The oak lamp and stoneware set, for a table you use every day.">چراغ بلوط و سرویس سنگی، برای میزی که هر روز از آن استفاده می‌کنید.</p>
      <a class="orvio-btn orvio-btn--light" href="shop.html?cat=home" data-fa="خانه و دکور" data-en="Shop home">خانه و دکور</a>
    </div>
  </article>
</div></section>
<section class="orvio-section"><div class="orvio-container" data-carousel>
  <div class="orvio-section__head"><div><p class="orvio-kicker" data-fa="پرفروش" data-en="Bestsellers">پرفروش</p><h2 data-fa="چیزهایی که می‌مانند" data-en="Pieces that stay">چیزهایی که می‌مانند</h2></div>
    <div class="orvio-carousel__nav"><button type="button" data-prev aria-label="prev">{SVG["chev"]}</button><button type="button" data-next aria-label="next">{SVG["chev"]}</button></div>
  </div>
  <div class="orvio-carousel__view"><div class="orvio-carousel__track">{best}</div></div>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container">
  <div class="orvio-duo">
    <a href="product.html?id=coat"><img src="assets/images/banners/atelier.jpg" alt=""><span class="cap"><small data-fa="پوشاک" data-en="Apparel">پوشاک</small><strong data-fa="پالتو زغالی" data-en="Charcoal coat">پالتو زغالی</strong></span></a>
    <a href="product.html?id=headphones"><img src="assets/images/products/headphones.jpg" alt=""><span class="cap"><small data-fa="صدا" data-en="Audio">صدا</small><strong data-fa="هدفون آرام" data-en="Aram headphones">هدفون آرام</strong></span></a>
  </div>
</div></section>
<section class="orvio-section"><div class="orvio-container orvio-about">
  <img src="assets/images/about.jpg" alt="">
  <div>
    <p class="orvio-kicker" data-i18n="about">درباره ما</p>
    <h2 data-fa="از یک میز کار تا یک ویترین" data-en="From a worktable to a shop">از یک میز کار تا یک ویترین</h2>
    <div class="orvio-prose"><p data-fa="اُرویو با این فکر شروع شد که اشیاء روزمره باید هم زیبا باشند و هم سال‌ها بمانند. با کارگاه‌های کوچک کار می‌کنیم و هر قطعه را پیش از ورود به فروشگاه لمس می‌کنیم." data-en="Orvio began with a simple belief: everyday objects should be beautiful and built to stay. We work with small workshops and handle every piece before it reaches the shop.">اُرویو با این فکر شروع شد که اشیاء روزمره باید هم زیبا باشند و هم سال‌ها بمانند. با کارگاه‌های کوچک کار می‌کنیم و هر قطعه را پیش از ورود به فروشگاه لمس می‌کنیم.</p></div>
    <div class="orvio-stats"><div><strong>۶</strong><span data-fa="سال" data-en="years">سال</span></div><div><strong>۱۸</strong><span data-fa="کارگاه" data-en="workshops">کارگاه</span></div><div><strong>۱۰۰٪</strong><span data-fa="بررسی دستی" data-en="checked">بررسی دستی</span></div></div>
    <a class="orvio-btn orvio-btn--dark" href="about.html" style="margin-top:18px" data-fa="داستان کامل" data-en="Read the story">داستان کامل</a>
  </div>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container">
  <article class="orvio-banner orvio-banner--card">
    <img src="assets/images/banners/table.jpg" alt="">
    <div class="orvio-banner__copy">
      <p class="orvio-kicker" data-fa="میز" data-en="Table">میز</p>
      <h2 data-fa="میز را برای هر روز بچینید" data-en="Set the table for ordinary days">میز را برای هر روز بچینید</h2>
      <p data-fa="سرویس سنگی با لعاب دانه‌دار؛ لبه‌ای که دست را نشان می‌دهد." data-en="Speckled stoneware, with a rim that shows the hand.">سرویس سنگی با لعاب دانه‌دار؛ لبه‌ای که دست را نشان می‌دهد.</p>
      <a class="orvio-btn orvio-btn--dark" href="product.html?id=table" data-fa="مشاهده سرویس" data-en="View the set">مشاهده سرویس</a>
    </div>
  </article>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container">
  <article class="orvio-banner orvio-banner--overlay">
    <img src="assets/images/hero.jpg" alt="">
    <div class="orvio-banner__copy">
      <p class="orvio-kicker" style="color:#F0D2C4" data-fa="استودیو" data-en="Studio">استودیو</p>
      <h2 data-fa="ساخته‌شده برای ماندن" data-en="Made to remain">ساخته‌شده برای ماندن</h2>
      <a class="orvio-btn orvio-btn--ghost-light" href="about.html" data-fa="داستان اُرویو" data-en="The Orvio story">داستان اُرویو</a>
    </div>
  </article>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container">
  <div class="orvio-ribbon">
    <img src="assets/images/products/candle.jpg" alt="">
    <p><strong data-fa="ست شمع دست‌ساز" data-en="Handmade candle set">ست شمع دست‌ساز</strong><span data-fa="رایحه چوب و برگ انجیر. موجودی محدود." data-en="Wood and fig leaf. Limited stock.">رایحه چوب و برگ انجیر. موجودی محدود.</span></p>
    <a class="orvio-btn orvio-btn--light" href="product.html?id=candle" data-fa="مشاهده شمع" data-en="View candles">مشاهده شمع</a>
  </div>
</div></section>
<section class="orvio-section"><div class="orvio-container">
  <div class="orvio-section__head"><h2 data-fa="از خانه‌ها" data-en="From houses">از خانه‌ها</h2></div>
  <div class="orvio-quotes">
    <article class="orvio-quote"><div class="orvio-stars" style="--v:5"><span class="orvio-stars__fill">★★★★★</span><span>★★★★★</span></div><p data-fa="کتری را هر صبح استفاده می‌کنم. سنگین است، اما دقیقاً به اندازه‌ای که آدم عجله نکند." data-en="I use the kettle every morning. Heavy enough that I don't rush.">کتری را هر صبح استفاده می‌کنم. سنگین است، اما دقیقاً به اندازه‌ای که آدم عجله نکند.</p><footer data-fa="سارا · تهران" data-en="Sara · Tehran">سارا · تهران</footer></article>
    <article class="orvio-quote"><div class="orvio-stars" style="--v:5"><span class="orvio-stars__fill">★★★★★</span><span>★★★★★</span></div><p data-fa="پالتو بعد از باران هنوز فرم خودش را دارد. بسته‌بندی هم تمیز بود." data-en="The coat kept its shape after rain. Packing was careful too.">پالتو بعد از باران هنوز فرم خودش را دارد. بسته‌بندی هم تمیز بود.</p><footer data-fa="آرمان · اصفهان" data-en="Arman · Isfahan">آرمان · اصفهان</footer></article>
    <article class="orvio-quote"><div class="orvio-stars" style="--v:4"><span class="orvio-stars__fill">★★★★★</span><span>★★★★★</span></div><p data-fa="هدفون را برای کار طولانی گرفتم. گوش را فشار نمی‌دهد و ظاهرش داد نمی‌زند." data-en="Bought the headphones for long work days. They don't clamp, and they don't shout.">هدفون را برای کار طولانی گرفتم. گوش را فشار نمی‌دهد و ظاهرش داد نمی‌زند.</p><footer data-fa="پریسا · شیراز" data-en="Parisa · Shiraz">پریسا · شیراز</footer></article>
  </div>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container">
  <div class="orvio-news">
    <div><h2 data-fa="نامه‌های کوتاه" data-en="A short letter">نامه‌های کوتاه</h2><p data-fa="فقط وقتی چیزی واقعاً ارزش گفتن دارد. نه هر هفته." data-en="Only when something is actually worth saying.">فقط وقتی چیزی واقعاً ارزش گفتن دارد. نه هر هفته.</p></div>
    <form id="news-form"><input type="email" required placeholder="email@example.com" aria-label="email"><button class="orvio-btn orvio-btn--light" type="submit" data-i18n="subscribe">عضویت</button></form>
  </div>
</div></section>
'''

def shop():
    checks = "".join(
        f'<label class="orvio-check"><input type="checkbox" data-filter="cat" value="{cid}"><span data-fa="{e(fa)}" data-en="{e(en)}">{e(fa)}</span><span style="margin-inline-start:auto;color:var(--faint)">{count(cid)}</span></label>'
        for cid, fa, en, img, _ in CATS
    )
    colors = [("عاجی", "Ivory", "#E7E1D6"), ("زغالی", "Charcoal", "#2C2926"), ("کنیاک", "Cognac", "#8C4A24"), ("شن", "Sand", "#D9CBB8"), ("کرم", "Cream", "#F4F0E6")]
    swatches = "".join(f'<button type="button" class="orvio-swatch" data-filter-color="{hx.lower()}" style="background:{hx}" title="{en}" aria-label="{en}"></button>' for _, en, hx in colors)
    cards = "".join(card(p) for p in PRODUCTS)
    return f'''<div class="orvio-container orvio-pagehead">
  <nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><span data-i18n="shop">فروشگاه</span></nav>
  <h1 data-i18n="shop">فروشگاه</h1>
</div>
<div class="orvio-container orvio-shop">
  <aside class="orvio-filters" data-filters>
    <div style="display:flex;justify-content:space-between;align-items:center"><h2 data-i18n="filters">فیلترها</h2><button type="button" class="orvio-drawer__x" data-close>×</button></div>
    <div class="orvio-filter"><strong data-fa="دسته" data-en="Category">دسته</strong>{checks}</div>
    <div class="orvio-filter"><strong data-fa="قیمت تا" data-en="Price up to">قیمت تا</strong><div class="orvio-range"><input type="range" min="500000" max="8000000" value="8000000" data-price><span data-price-out>{money(8000000)}</span></div></div>
    <div class="orvio-filter"><strong data-i18n="color">رنگ</strong><div class="orvio-swatch-row">{swatches}</div></div>
    <div class="orvio-filter"><label class="orvio-check"><input type="checkbox" data-filter="sale"><span data-i18n="onSale">فقط تخفیف‌دار</span></label><label class="orvio-check"><input type="checkbox" data-filter="stock"><span data-i18n="inStock">فقط موجود</span></label></div>
    <button type="button" class="orvio-btn orvio-btn--ghost orvio-btn--full" data-clear data-i18n="clear">پاک کردن فیلترها</button>
  </aside>
  <div>
    <div class="orvio-toolbar">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
        <button type="button" class="orvio-btn orvio-btn--ghost orvio-btn--sm orvio-filter-toggle" data-open="filters" data-i18n="filters">فیلترها</button>
        <strong data-count>{fa_num(len(PRODUCTS))} کالا</strong>
        <input class="orvio-select" data-shop-q placeholder="…" data-i18n-placeholder="searchPh" aria-label="search" style="min-width:140px">
      </div>
      <div class="orvio-toolbar__tools">
        <select class="orvio-select" data-sort aria-label="sort">
          <option value="newest" data-i18n="newest">جدیدترین</option>
          <option value="priceAsc">ارزان‌ترین</option>
          <option value="priceDesc">گران‌ترین</option>
          <option value="rating">بالاترین امتیاز</option>
        </select>
        <button type="button" class="orvio-viewbtn is-on" data-view="grid" aria-label="grid">{SVG["grid"]}</button>
        <button type="button" class="orvio-viewbtn" data-view="list" aria-label="list"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M4 6h16M4 12h16M4 18h16" fill="none" stroke="currentColor" stroke-width="1.7"/></svg></button>
      </div>
    </div>
    <div class="orvio-grid" id="shop-grid" style="--cols:3">{cards}</div>
    <div class="orvio-empty" data-shop-empty hidden><h2 data-i18n="noResults">کالایی با این فیلتر پیدا نشد.</h2></div>
  </div>
</div>'''

def about():
    return '''<div class="orvio-container orvio-pagehead"><nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><span data-i18n="about">درباره ما</span></nav><h1 data-fa="خانه‌ای آرام‌تر، ذره‌ذره" data-en="A quieter house, piece by piece">خانه‌ای آرام‌تر، ذره‌ذره</h1></div>
<section class="orvio-section" style="padding-top:10px"><div class="orvio-container orvio-about">
  <img src="assets/images/about.jpg" alt="">
  <div class="orvio-prose">
    <p data-fa="اُرویو در سال ۱۳۹۸ پشت یک میز کار کوچک شروع شد. نه با انبار بزرگ، با چند قطعه که خودمان حاضر بودیم سال‌ها نگه داریم." data-en="Orvio started in 2019 at a small worktable. Not with a warehouse — with a few pieces we were willing to keep for years.">اُرویو در سال ۱۳۹۸ پشت یک میز کار کوچک شروع شد. نه با انبار بزرگ، با چند قطعه که خودمان حاضر بودیم سال‌ها نگه داریم.</p>
    <p data-fa="امروز با هجده کارگاه در ایران و بیرون از آن کار می‌کنیم. معیار ورود به ویترین ساده است: ماده خوب، ساخت قابل دفاع، و فرمی که بعد از یک فصل خسته نکند." data-en="Today we work with eighteen workshops, here and elsewhere. The bar for the edit is simple: honest material, defensible making, and a form that doesn't tire after a season.">امروز با هجده کارگاه در ایران و بیرون از آن کار می‌کنیم. معیار ورود به ویترین ساده است: ماده خوب، ساخت قابل دفاع، و فرمی که بعد از یک فصل خسته نکند.</p>
    <p data-fa="این صفحه، و کل این دمو، نمای زنده قالب وردپرس اُرویو است؛ همان پوسته‌ای که روی ووکامرس و المنتور می‌نشیند." data-en="This page, and this whole demo, is the live face of the Orvio WordPress theme — the same skin that sits on WooCommerce and Elementor.">این صفحه، و کل این دمو، نمای زنده قالب وردپرس اُرویو است؛ همان پوسته‌ای که روی ووکامرس و المنتور می‌نشیند.</p>
  </div>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container orvio-values">
  <article><h3 data-fa="ماده" data-en="Material">ماده</h3><p data-fa="سرامیک، چرم، پشم، چوب. اگر ماده‌ای داستان نداشته باشد، وارد ویترین نمی‌شود." data-en="Ceramic, leather, wool, wood. If a material has no story, it doesn't enter the edit.">سرامیک، چرم، پشم، چوب. اگر ماده‌ای داستان نداشته باشد، وارد ویترین نمی‌شود.</p></article>
  <article><h3 data-fa="کارگاه" data-en="Workshop">کارگاه</h3><p data-fa="با کارگاه‌های کوچک قرارداد می‌بندیم، نه با خط تولید بی‌نام." data-en="We contract small workshops, not nameless lines.">با کارگاه‌های کوچک قرارداد می‌بندیم، نه با خط تولید بی‌نام.</p></article>
  <article><h3 data-fa="زمان" data-en="Time">زمان</h3><p data-fa="کالا باید بعد از سه سال هم قابل دفاع باشد. مد فصل برای ما معیار نیست." data-en="A piece should still make sense in three years. Seasonal noise is not our measure.">کالا باید بعد از سه سال هم قابل دفاع باشد. مد فصل برای ما معیار نیست.</p></article>
</div></section>'''

def contact():
    return '''<div class="orvio-container orvio-pagehead"><nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><span data-i18n="contact">ارتباط با ما</span></nav><h1 data-i18n="contact">ارتباط با ما</h1></div>
<section class="orvio-section" style="padding-top:8px"><div class="orvio-container orvio-contact">
  <div class="orvio-info">
    <article><strong data-fa="استودیو" data-en="Studio">استودیو</strong><span data-fa="تهران، خیابان طراحی، پلاک ۱۲، استودیو اُرویو" data-en="12 Design Street, Tehran — Orvio studio">تهران، خیابان طراحی، پلاک ۱۲، استودیو اُرویو</span></article>
    <article><strong data-i18n="phone">موبایل</strong><a href="tel:+982191000042">۰۲۱−۹۱۰۰۰۰۴۲</a></article>
    <article><strong data-i18n="email">ایمیل</strong><a href="mailto:hello@orvio.shop">hello@orvio.shop</a></article>
    <article><strong data-fa="ساعت" data-en="Hours">ساعت</strong><span data-i18n="hours">شنبه تا پنجشنبه، ۱۰ تا ۱۸</span></article>
    <div class="orvio-map" data-fa="نقشه استودیو — نسخه نمایشی" data-en="Studio map — demo">نقشه استودیو — نسخه نمایشی</div>
  </div>
  <form class="orvio-panel" id="contact-form">
    <div class="orvio-fields">
      <label class="orvio-field"><span data-i18n="name">نام و نام خانوادگی</span><input name="name" required></label>
      <label class="orvio-field"><span data-i18n="phone">موبایل</span><input name="phone" required></label>
      <label class="orvio-field orvio-field--full"><span data-i18n="email">ایمیل</span><input type="email" name="email" required></label>
      <label class="orvio-field orvio-field--full"><span data-fa="پیام" data-en="Message">پیام</span><textarea name="message" required></textarea></label>
    </div>
    <button class="orvio-btn orvio-btn--primary" style="margin-top:12px" type="submit" data-i18n="send">ارسال پیام</button>
    <p class="orvio-note" style="margin-top:8px" data-fa="این فرم در دمو پیام را واقعاً ارسال نمی‌کند." data-en="This demo form does not send a real email.">این فرم در دمو پیام را واقعاً ارسال نمی‌کند.</p>
  </form>
</div></section>'''

def account():
    return '''<div class="orvio-container orvio-pagehead"><nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><span data-i18n="account">حساب</span></nav><h1 data-i18n="account">حساب</h1></div>
<div class="orvio-container orvio-account">
  <nav class="orvio-account__nav">
    <button type="button" class="is-on" data-tab="dash" data-i18n="dash">داشبورد</button>
    <button type="button" data-tab="orders" data-i18n="orders">سفارش‌ها</button>
    <button type="button" data-tab="addresses" data-i18n="addresses">آدرس‌ها</button>
    <button type="button" data-tab="details" data-i18n="details">اطلاعات حساب</button>
    <button type="button" data-tab="wish" data-i18n="wish">علاقه‌مندی</button>
    <a href="shop.html" data-i18n="logout">خروج</a>
  </nav>
  <div>
    <section data-panel="dash">
      <div class="orvio-welcome"><div><p class="orvio-note" style="color:#E7C3B0" data-fa="خوش آمدید" data-en="Welcome back">خوش آمدید</p><h2 data-i18n="guest">مهمان اُرویو</h2></div><a class="orvio-btn orvio-btn--light" href="shop.html" data-i18n="shop">فروشگاه</a></div>
      <div class="orvio-stats-row"><div class="orvio-stat"><strong>۳</strong><span data-i18n="orders">سفارش‌ها</span></div><div class="orvio-stat"><strong>۱</strong><span data-fa="در راه" data-en="On the way">در راه</span></div><div class="orvio-stat"><strong data-wish-count>۰</strong><span data-i18n="wish">علاقه‌مندی</span></div></div>
      <div class="orvio-panel"><h2 style="font-size:16px;letter-spacing:0;margin-bottom:8px" data-fa="آخرین سفارش‌ها" data-en="Recent orders">آخرین سفارش‌ها</h2>
        <table class="orvio-table"><thead><tr><th data-fa="شماره" data-en="No.">شماره</th><th data-fa="تاریخ" data-en="Date">تاریخ</th><th data-i18n="total">مبلغ</th><th data-fa="وضعیت" data-en="Status">وضعیت</th></tr></thead>
        <tbody>
          <tr><td data-label="no">ORV-2408</td><td>۱۲ مهر</td><td>۴٬۲۰۰٬۰۰۰</td><td><span class="orvio-status orvio-status--ship" data-fa="در حال ارسال" data-en="Shipping">در حال ارسال</span></td></tr>
          <tr><td>ORV-2381</td><td>۲ مهر</td><td>۱٬۸۹۰٬۰۰۰</td><td><span class="orvio-status orvio-status--done" data-fa="تحویل شد" data-en="Delivered">تحویل شد</span></td></tr>
          <tr><td>ORV-2310</td><td>۱۸ شهریور</td><td>۷۸۰٬۰۰۰</td><td><span class="orvio-status orvio-status--done" data-fa="تحویل شد" data-en="Delivered">تحویل شد</span></td></tr>
        </tbody></table>
      </div>
    </section>
    <section data-panel="orders" hidden>
      <div class="orvio-panel"><h2 style="font-size:18px;letter-spacing:0" data-i18n="orders">سفارش‌ها</h2>
      <table class="orvio-table"><thead><tr><th>#</th><th data-fa="کالاها" data-en="Items">کالاها</th><th data-i18n="total">مبلغ</th><th data-fa="وضعیت" data-en="Status">وضعیت</th></tr></thead>
      <tbody>
        <tr><td>ORV-2408</td><td data-fa="کیف چرم هفته" data-en="Weekender bag">کیف چرم هفته</td><td>۴٬۲۰۰٬۰۰۰</td><td><span class="orvio-status orvio-status--ship" data-fa="در حال ارسال" data-en="Shipping">در حال ارسال</span></td></tr>
        <tr><td>ORV-2381</td><td data-fa="کتری سرامیکی نُوا" data-en="Nova kettle">کتری سرامیکی نُوا</td><td>۱٬۸۹۰٬۰۰۰</td><td><span class="orvio-status orvio-status--done" data-fa="تحویل شد" data-en="Delivered">تحویل شد</span></td></tr>
        <tr><td>ORV-2294</td><td data-fa="چراغ رومیزی" data-en="Table lamp">چراغ رومیزی</td><td>۱٬۶۵۰٬۰۰۰</td><td><span class="orvio-status orvio-status--wait" data-fa="در انتظار پرداخت" data-en="Awaiting payment">در انتظار پرداخت</span></td></tr>
      </tbody></table></div>
    </section>
    <section data-panel="addresses" hidden>
      <div class="orvio-panel"><h2 style="font-size:18px;letter-spacing:0" data-i18n="addresses">آدرس‌ها</h2>
      <article class="orvio-info" style="margin-top:12px"><div><strong data-fa="خانه" data-en="Home">خانه</strong><p data-fa="تهران، خیابان طراحی، پلاک ۱۲، واحد ۳" data-en="12 Design Street, No. 3, Tehran">تهران، خیابان طراحی، پلاک ۱۲، واحد ۳</p><p class="orvio-note">۰۹۱۲۰۰۰۰۰۰۰</p></div></article>
      <button class="orvio-btn orvio-btn--ghost" style="margin-top:12px" type="button" data-fa="افزودن آدرس" data-en="Add address">افزودن آدرس</button>
      </div>
    </section>
    <section data-panel="details" hidden>
      <form class="orvio-panel" id="contact-form">
        <div class="orvio-fields">
          <label class="orvio-field"><span data-i18n="name">نام</span><input value="مهمان اُرویو" data-fa-value="مهمان اُرویو"></label>
          <label class="orvio-field"><span data-i18n="phone">موبایل</span><input value="09120000000"></label>
          <label class="orvio-field orvio-field--full"><span data-i18n="email">ایمیل</span><input type="email" value="guest@orvio.shop"></label>
        </div>
        <button class="orvio-btn orvio-btn--primary" style="margin-top:12px" type="submit" data-i18n="update">به‌روزرسانی</button>
      </form>
    </section>
    <section data-panel="wish" hidden><div data-account-wish></div></section>
  </div>
</div>'''

def theme_page():
    return '''<div class="orvio-container orvio-pagehead">
  <nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><span data-fa="قالب وردپرس" data-en="WordPress theme">قالب وردپرس</span></nav>
  <h1>Orvio</h1>
  <p class="orvio-lead" data-fa="این پوستهٔ وردپرس است. صفحه‌هایی که در دمو می‌بینید، ظاهر همین قالب‌اند. فایل نصب را از همین‌جا بردارید." data-en="This is the WordPress theme. The pages in this demo are its face. Download the installable package here.">این پوستهٔ وردپرس است. صفحه‌هایی که در دمو می‌بینید، ظاهر همین قالب‌اند. فایل نصب را از همین‌جا بردارید.</p>
  <p style="margin-top:14px"><a class="orvio-btn orvio-btn--primary" href="orvio.zip" download>orvio.zip</a></p>
</div>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container">
  <div class="orvio-section__head"><h2 data-fa="صفحه‌های قالب" data-en="Theme templates">صفحه‌های قالب</h2></div>
  <div class="orvio-grid" style="--cols:3">
    <a class="orvio-panel" href="shop.html"><strong data-fa="فروشگاه" data-en="Shop">فروشگاه</strong><p class="orvio-note">woocommerce/archive-product.php</p></a>
    <a class="orvio-panel" href="product.html?id=kettle"><strong data-fa="محصول" data-en="Product">محصول</strong><p class="orvio-note">woocommerce/content-single-product.php</p></a>
    <a class="orvio-panel" href="cart.html"><strong data-fa="سبد" data-en="Cart">سبد</strong><p class="orvio-note">woocommerce/cart/cart.php</p></a>
    <a class="orvio-panel" href="checkout.html"><strong data-fa="صورتحساب" data-en="Checkout">صورتحساب</strong><p class="orvio-note">woocommerce/checkout/form-checkout.php</p></a>
    <a class="orvio-panel" href="account.html"><strong data-fa="حساب کاربری" data-en="Account">حساب کاربری</strong><p class="orvio-note">woocommerce/myaccount/my-account.php</p></a>
    <a class="orvio-panel" href="contact.html"><strong data-fa="ارتباط و درباره" data-en="Contact and about">ارتباط و درباره</strong><p class="orvio-note">inc/elementor-widgets.php</p></a>
  </div>
</div></section>
<section class="orvio-section" style="padding-top:0"><div class="orvio-container orvio-panel">
  <h2 style="font-size:22px;letter-spacing:0" data-fa="داخل بستهٔ نصب" data-en="Inside the package">داخل بستهٔ نصب</h2>
  <ul class="orvio-prose" style="margin-top:12px">
    <li data-fa="هدر، جستجو، دکمهٔ سبد، منوی دسته و کشوی سبد" data-en="Header, search, cart button, category menu and cart drawer">هدر، جستجو، دکمهٔ سبد، منوی دسته و کشوی سبد</li>
    <li data-fa="تنظیمات رنگ، هدر، فوتر، فروشگاه و تماس از منوی Orvio در پیشخوان" data-en="Color, header, footer, shop and contact settings from the Orvio admin menu">تنظیمات رنگ، هدر، فوتر، فروشگاه و تماس از منوی Orvio در پیشخوان</li>
    <li data-fa="ویجت المنتور: کالا در چهار چیدمان، بنر در پنج مدل، تماس، درباره، هدر و فوتر" data-en="Elementor widgets: products in four layouts, banners in five models, contact, about, header and footer">ویجت المنتور: کالا در چهار چیدمان، بنر در پنج مدل، تماس، درباره، هدر و فوتر</li>
    <li data-fa="نصب کاتالوگ دمو از همان منوی تنظیمات، بعد از فعال کردن ووکامرس" data-en="Demo catalog import from the same settings menu, after WooCommerce is active">نصب کاتالوگ دمو از همان منوی تنظیمات، بعد از فعال کردن ووکامرس</li>
  </ul>
  <p class="orvio-note" style="margin-top:14px" data-fa="نصب: orvio.zip را در ظاهر ← قالب‌ها ← افزودن بارگذاری کنید. بعد ووکامرس و المنتور را فعال کنید." data-en="Install: upload orvio.zip in Appearance → Themes → Add New. Then activate WooCommerce and Elementor.">نصب: orvio.zip را در ظاهر ← قالب‌ها ← افزودن بارگذاری کنید. بعد ووکامرس و المنتور را فعال کنید.</p>
</div></section>'''

def main():
    catalog = []
    for p in PRODUCTS:
        catalog.append({k: p[k] for k in p})
    (ROOT / "catalog.js").write_text("window.ORVIO_CATALOG = " + json.dumps(catalog, ensure_ascii=False) + ";\n", encoding="utf-8")
    pages = {
        "index.html": shell("home", "اُرویو — فروشگاه اشیاء آرام", home()),
        "shop.html": shell("shop", "فروشگاه — اُرویو", shop()),
        "product.html": shell("product", "کالا — اُرویو", '<div class="orvio-container orvio-pagehead" id="product-root"></div>'),
        "cart.html": shell("cart", "سبد خرید — اُرویو", '<div class="orvio-container orvio-pagehead"><nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><span data-i18n="cart">سبد</span></nav><h1 data-i18n="cart">سبد</h1></div><div class="orvio-container" id="cart-root"></div>'),
        "checkout.html": shell("checkout", "صورتحساب — اُرویو", '<div class="orvio-container orvio-pagehead"><nav class="orvio-crumb"><a href="index.html" data-i18n="home">خانه</a><span class="orvio-crumb__sep">/</span><a href="cart.html" data-i18n="cart">سبد</a><span class="orvio-crumb__sep">/</span><span data-i18n="checkout">تسویه</span></nav><h1 data-i18n="checkout">تسویه و صورتحساب</h1></div><div class="orvio-container" id="checkout-root"></div>'),
        "account.html": shell("account", "حساب کاربری — اُرویو", account()),
        "about.html": shell("about", "درباره ما — اُرویو", about()),
        "contact.html": shell("contact", "ارتباط با ما — اُرویو", contact()),
        "theme.html": shell("theme", "قالب وردپرس — اُرویو", theme_page()),
    }
    for name, content in pages.items():
        (ROOT / name).write_text(content, encoding="utf-8")
        print("wrote", name, len(content))

if __name__ == "__main__":
    main()
