# Fordítási útmutató - Translation Guide

## 🇭🇺 Magyar fordítás (Hungarian Translation)

A plugin már tartalmaz magyar fordítást. A fordítás automatikusan betöltődik, ha a WordPress nyelve magyar (hu_HU).

### Fájlok (Files)

- `tlw-woo-ajax-search.pot` - Fordítási template (Translation template)
- `tlw-woo-ajax-search-hu_HU.po` - Magyar fordítási fájl (Hungarian translation file)
- `tlw-woo-ajax-search-hu_HU.mo` - Lefordított bináris fájl (Compiled binary file)

## Új fordítás hozzáadása (Adding New Translation)

### 1. Módszer: Poedit használata (ajánlott)

1. Telepítsd a [Poedit](https://poedit.net/) programot
2. Nyisd meg a `tlw-woo-ajax-search.pot` fájlt
3. Válaszd ki a célnyelvet (pl. német: de_DE, francia: fr_FR)
4. Fordítsd le a szövegeket
5. Mentsd el - automatikusan létrejön a `.po` és `.mo` fájl

### 2. Módszer: Kézi szerkesztés

1. Másold le a `.pot` fájlt és nevezd át (pl. `tlw-woo-ajax-search-de_DE.po`)
2. Szerkeszd meg a fájlt és add meg a fordításokat az `msgstr ""` sorokban
3. Generáld le a `.mo` fájlt:
   ```bash
   msgfmt -o tlw-woo-ajax-search-de_DE.mo tlw-woo-ajax-search-de_DE.po
   ```

### 3. Módszer: WordPress admin (Loco Translate plugin)

1. Telepítsd a [Loco Translate](https://wordpress.org/plugins/loco-translate/) plugint
2. Menj a **Loco Translate → Plugins** menüpontra
3. Válaszd ki a "TLW WooCommerce AJAX Search" plugint
4. Kattints az "New language" gombra
5. Válaszd ki a nyelvet és fordítsd le a szövegeket
6. A plugin automatikusan létrehozza a `.po` és `.mo` fájlokat

## Nyelvi kódok (Language Codes)

Gyakori nyelvi kódok:
- Magyar: `hu_HU`
- Német: `de_DE`
- Francia: `fr_FR`
- Spanyol: `es_ES`
- Olasz: `it_IT`
- Román: `ro_RO`
- Angol (UK): `en_GB`
- Angol (US): `en_US`

## Fordítandó szövegek (Translatable Strings)

A pluginban jelenleg az alábbi szövegek fordíthatók:

### Admin üzenetek
- "TLW WooCommerce AJAX Search requires WooCommerce to be installed and active."
- "Please install and activate WooCommerce before activating TLW WooCommerce AJAX Search."

### Keresőmező
- "Search products..." (placeholder szöveg)
- "Search" (gomb szöveg)
- "Search products" (aria-label)

### AJAX válaszok
- "Security check failed"
- "Please enter at least 2 characters"
- "No products found"
- "In stock"
- "Out of stock"

## A fordítás frissítése (Updating Translation)

Ha új fordítandó szöveget adsz hozzá a kódban:

1. **Használj mindig a `__()` vagy `_e()` függvényeket:**
   ```php
   __('Szöveg', 'tlw-woo-ajax-search')
   _e('Szöveg', 'tlw-woo-ajax-search')
   ```

2. **Frissítsd a `.pot` fájlt** (ha van telepítve WP-CLI):
   ```bash
   wp i18n make-pot . languages/tlw-woo-ajax-search.pot
   ```

3. **Vagy használd a Poedit-ot:**
   - Nyisd meg a meglévő `.po` fájlt
   - Catalog → Update from POT file
   - Válaszd ki a frissített `.pot` fájlt

4. **Fordítsd le az új szövegeket** és mentsd el

## Tesztelés (Testing)

1. Állítsd be a WordPress nyelvet: **Beállítások → Általános → Webhely nyelve**
2. Frissítsd a plugin fordításait
3. Ellenőrizd, hogy a szövegek megfelelően jelennek-e meg

## Közreműködés (Contributing)

Ha új fordítást készítesz, szívesen fogadjuk! Küld el a `.po` és `.mo` fájlokat a következő címre:
info@talaweb.hu

---

**Készítette / Created by:** [TALAWEB](https://talaweb.hu)
