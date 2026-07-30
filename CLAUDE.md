# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

Laravel 12 village government website ("Website Desa Ngrejo"). Public-facing pages (profile, potensi desa, informasi, struktur organisasi, surat/letter requests) plus an authenticated admin panel. No SPA framework — server-rendered Blade views with Tailwind CSS v4 via Vite. Auth is Google OAuth only (Laravel Socialite), restricted to a single hardcoded email (`app/Http/Controllers/Auth/SocialiteController.php`).

## Commands

Run PHP tooling through the local `composer.phar` since Composer isn't installed globally in this environment:

```
php composer.phar install
php composer.phar dump-autoload
```

Common dev commands:

```
composer dev              # runs server + queue listener + pail logs + vite concurrently
php artisan serve
npm run dev                # vite dev server
npm run build               # vite production build
```

Testing:

```
php artisan test                        # full suite (phpunit.xml wraps Unit + Feature)
php artisan test --filter=TestName      # single test
php artisan test tests/Feature/Xyz.php  # single file
```

Note: `composer test` clears config cache first (`php artisan config:clear`) before running tests — prefer that when config caching is a suspect.

Code style: `vendor/bin/pint` (Laravel Pint) — no separate lint command is configured beyond this.

Database: MySQL in dev/prod (`DB_CONNECTION=mysql`, see `.env.example`), SQLite in-memory for tests (set in `phpunit.xml`). Migrations live in `database/migrations/`.

## Architecture

**Route split (`routes/web.php`)**: two zones —
- Public routes, unauthenticated, under `/` and `/user/*`, served by `PublicViewController` (read-only pages: profile, potensi desa, informasi, struktur organisasi) and `SuratDesaController` (public letter-request submission form).
- Admin routes under `/admin/*`, gated by `auth` middleware, one controller per resource (`DesaController`, `StrukturOrganisasiController`, `InformasiController`, `PotensiDesaController`, `SuratDesaController`, `PeternakController`). Route names follow `admin.<resource>.<action>`.

Login is Google-only: `/auth/google` → `SocialiteController::redirectToGoogle`, callback restricted to one whitelisted email; anyone else is bounced back with an error. There's no local username/password registration flow in the app despite `LoginController` existing.

**Surat Desa (letter request) flow**: a citizen submits a request via the public form (`SuratDesaController@store`), optionally attaching images stored under `data_pendukung` (private disk, served through an authorization-checked `showImage` action rather than a public URL). Admin reviews and marks it `selesai` via `updateStatus`, which queues `App\Jobs\DeleteSuratDesa` to purge the request and its attachments after a delay (cleanup job, not the initial creation path).

**Peternak (livestock data) module**: `Peternak` has many `PeternakanDetail` (aliased as `ternaks()`). Admin form submits one `Peternak` (owner/household) plus multiple ternak rows split by `jenis_kelamin` (Jantan/Betina) computed from separate jantan/betina counts in the request. `PeternakController@index` re-groups paginated results in PHP by name+alamat+periode+tahun for display, and `PeternakExport` (Maatwebsite Excel) handles XLSX export — check `PeternakExport` when altering the exported columns instead of adding a second export path.

**Models**: plain Eloquent, mostly thin (fillable + relations only — no scopes/observers/casts of note). Key relations: `SuratDesa hasMany DataPendukung`, `Peternak hasMany PeternakanDetail` (as `ternaks`), `Informasi hasMany Lampiran`, `StrukturOrganisasi`/`AnggotaStruktur` are separate models (one struktur record + many anggota records).

**Views (`resources/views`)**: split into `Admin/` and `User/` top-level folders mirroring the route split, plus a shared `layout/`. Each admin resource has its own subfolder (e.g. `Admin/SuratDesa`, `Admin/DataTernak`, `Admin/StrukturAnggota`).

**File uploads**: admin-uploaded images (struktur foto, desa logo, potensi desa) go to the `public` disk under descriptive subfolders (`struktur_anggota`, `logos`, `images`) and are deleted before being overwritten on update. Public letter-request attachments go to the default (private) disk under `data_pendukung` and are never directly public — always served through `SuratDesaController@showImage` with an ownership check against `DataPendukung`.

## Dependencies of note

- `barryvdh/laravel-dompdf`, `phpoffice/phpword`, `spatie/browsershot` are installed for document/PDF generation but not yet wired into any controller — check before assuming a document-export feature exists.
- `maatwebsite/excel` is actively used only by `PeternakExport`.
- `laravel/socialite` is the sole auth mechanism (Google).
