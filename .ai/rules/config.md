---
paths:
  - config/app.php
---

# Config

## App timezone is Asia/Jakarta — sync with server & admin forms
The machine, MySQL, and admin datetime-local inputs all run in WIB (UTC+7), but config/app.php defaults 'timezone' to 'UTC' and does NOT read APP_TIMEZONE. Kept as env('APP_TIMEZONE', 'UTC') with APP_TIMEZONE=Asia/Jakarta in .env. Never hardcode UTC back: published_at saved from the admin form is local WIB time, and the Article::published() scope (published_at <= now()) will hide articles as "scheduled" if the app clock is 7h behind.
