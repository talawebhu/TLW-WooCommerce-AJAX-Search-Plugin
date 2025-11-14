# TLW WooCommerce AJAX Search Plugin

Egy modern, gyors és felhasználóbarát AJAX keresési plugin WooCommerce termékekhez.

## Funkciók

- **Valós idejű keresés**: Az AJAX technológia lehetővé teszi a termékek azonnali megjelenítését oldal újratöltés nélkül
- **Intelligens keresés**: Keres a termék címében, leírásában és SKU-ban
- **Vizuális visszajelzés**: Megjeleníti a termék képét, árát, raktárkészletet és rövid leírást
- **Billentyűzet navigáció**: Fel/le nyilakkal navigálhatsz az eredmények között, Enter-rel megnyithatod a terméket
- **Responsive design**: Tökéletesen működik mobil eszközökön is
- **Könnyen beilleszthető**: Shortcode segítségével bárhova elhelyezhető
- **Teljesítmény optimalizált**: Késleltetett keresés és kérés megszakítás a szerver terhelésének csökkentésére

## Telepítés

1. Töltsd le a plugin fájlokat
2. Másold a `TLW-WooCommerce-AJAX-Search-Plugin` mappát a `/wp-content/plugins/` könyvtárba
3. Aktiváld a plugint a WordPress admin felületén a 'Plugins' menüben
4. Győződj meg róla, hogy a WooCommerce plugin telepítve és aktiválva van

## Használat

### Shortcode használata

A keresőmező megjelenítéséhez használd a következő shortcode-ot:

```
[tlw_woo_search]
```

### Shortcode paraméterek

A shortcode testreszabható a következő paraméterekkel:

```
[tlw_woo_search placeholder="Termékek keresése..." button_text="Keresés" show_button="yes"]
```

**Elérhető paraméterek:**

- `placeholder` - A keresőmező placeholder szövege (alapértelmezett: "Search products...")
- `button_text` - A keresés gomb szövege (alapértelmezett: "Search")
- `show_button` - Keresés gomb megjelenítése (alapértelmezett: "no", értékek: "yes" vagy "no")

### Példák

**Egyszerű keresőmező:**
```
[tlw_woo_search]
```

**Magyar nyelvű keresőmező:**
```
[tlw_woo_search placeholder="Keresés a termékek között..."]
```

**Keresőmező gombbal:**
```
[tlw_woo_search placeholder="Mit keresel?" button_text="Keresés" show_button="yes"]
```

### Használat témában

Ha közvetlenül a témában szeretnéd használni PHP kódban:

```php
<?php echo do_shortcode('[tlw_woo_search]'); ?>
```

## Testreszabás

### CSS testreszabás

A plugin saját CSS fájlt használ, amely könnyedén felülírható a téma style.css fájljában. A főbb CSS osztályok:

- `.tlw-woo-search-container` - A teljes keresési konténer
- `.tlw-woo-search-input` - A keresési beviteli mező
- `.tlw-woo-search-results` - Az eredmények konténere
- `.tlw-search-result-item` - Egy termék eredmény
- `.tlw-search-result-title` - Termék címe
- `.tlw-search-result-price` - Termék ára
- `.tlw-search-result-stock` - Raktárkészlet állapot

### Példa CSS testreszabásra:

```css
/* Keresőmező színek módosítása */
.tlw-woo-search-input {
    border-color: #333;
}

.tlw-woo-search-input:focus {
    border-color: #ff6b6b;
}

/* Eredmények háttérszíne */
.tlw-search-result-item:hover {
    background-color: #f0f0f0;
}

/* Termék ár színe */
.tlw-search-result-price {
    color: #e74c3c;
}
```

## Követelmények

- WordPress 5.8 vagy újabb
- WooCommerce 5.0 vagy újabb
- PHP 7.4 vagy újabb

## Jellemzők

- **Keresési logika**: Minimum 2 karakter szükséges a kereséshez
- **Maximális eredmények**: 10 termék jelenik meg egyszerre
- **Késleltetés**: 300ms késleltetés az automatikus keresés előtt (gépelés közbeni túl sok kérés elkerülésére)
- **Biztonság**: WordPress nonce ellenőrzés minden AJAX kérésnél
- **SEO friendly**: A keresőmező form fallback-el rendelkezik JavaScript nélküli működéshez

## Hibaelhárítás

### A keresés nem működik

1. Ellenőrizd, hogy a WooCommerce aktiválva van-e
2. Ellenőrizd a böngésző konzolját JavaScript hibák után
3. Győződj meg róla, hogy a WordPress AJAX működik (admin-ajax.php elérhető)

### Az eredmények nem jelennek meg

1. Ellenőrizd, hogy vannak-e publikált termékek
2. Nézd meg, hogy a termékek nem "exclude-from-search" kategóriában vannak-e
3. Ellenőrizd a PHP error logot

### Stílus problémák

1. Töröld a böngésző cache-t
2. Ellenőrizd, hogy nincs-e témában CSS amely felülírja a plugin stílusát
3. Használj !important-ot ha szükséges a téma CSS-ben

## Changelog

### 1.0.0
- Első kiadás
- AJAX alapú termékkeresés
- Shortcode támogatás
- Responsive design
- Billentyűzet navigáció
- Raktárkészlet megjelenítés

## Támogatás

Ha bármilyen kérdésed vagy problémád van a pluginnal kapcsolatban, látogass el a [TalaWeb](https://talaweb.hu) weboldalára.

## Licensz

Ez a plugin GPL v2 vagy későbbi licensz alatt került kiadásra.

## Készítette

**TALAWEB - the freelance web geek**
- Weboldal: https://talaweb.hu
