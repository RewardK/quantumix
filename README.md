# Quantumix Corporate Website & Admin Platform

Website complet pentru Quantumix (servicii software & IT), compatibil cu shared hosting și fără dependențe externe (fără NodeJS). Include site public, panou admin și API intern.

## Cerințe server
- PHP >= 8.0
- MySQL >= 5.7
- Extensii PHP: PDO, PDO_MySQL, mbstring, openssl

## Instalare
1. Uploadează toate fișierele pe server (ex: `/public` ca document root).
2. Creează baza de date MySQL și importă schema:
   ```sql
   SOURCE /sql/schema.sql;
   ```
3. Configurează `config/config.php`:
   - Date DB
   - `base_url` (ex: `https://siteul-tau.ro`)
   - `csrf_key` și `api_token`
4. Setează permisiuni write pentru:
   - `/uploads`
   - `/logs`

## Autentificare admin
- URL: `/admin/login.php`
- User default:
  - Email: `admin@quantumix.com`
  - Parolă: `Admin123!`

> Recomandat: schimbă parola imediat după instalare.

## Structură proiect
```
/public
/assets
  /css
  /js
/config
/core
/modules
/admin
/api
/uploads
/logs
/sql
README.md
```

## Funcționalități
- Site public complet (home, despre, servicii, portofoliu, blog, contact, FAQ, terms, pagini CMS)
- CRUD admin pentru utilizatori, servicii, proiecte, blog, pagini
- Sistem autentificare, resetare parolă, confirmare email
- API intern cu token
- CSRF protection, SQL injection protection via PDO, XSS protection
- Sitemap + robots.txt

## Configurare email
Funcția `mail()` este folosită pentru notificări. Configură emailul în `config/config.php` (`mail.from`).

## Extensii / Personalizare
- Adaugă pagini CMS din admin (`/admin/pages.php`).
- Editează CSS în `/assets/css/style.css`.
- Pentru API, actualizează token în `config/config.php`.

## Troubleshooting
- Dacă primesți erori 500, verifică PHP error logs și permisiunile în `/logs`.
- Dacă nu se trimite email, configurează corect serverul SMTP sau folosește un relay.
- Dacă paginile nu se încarcă, verifică document root și `.htaccess`.
