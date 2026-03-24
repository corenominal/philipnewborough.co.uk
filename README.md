# philipnewborough.co.uk

Personal portfolio site for Philip Newborough, built with [CodeIgniter 4](https://codeigniter.com/).

## Features

- **Dynamic hero section** — rotating taglines with an animated typing effect, an active bio, and call-to-action links to external services (blog, status, bookmarks, GitHub)
- **GitHub activity feed** — fetches recent public events via the GitHub API and displays them in a terminal-style interface with icons, badges, and relative timestamps
- **Content aggregation** — pulls the latest blog posts, status updates, and bookmarks from external microservice APIs
- **Admin dashboard** — authenticated management interface for taglines, bio versions, GitHub activity records, and cache files

## Tech Stack

| Layer | Choice |
|---|---|
| Framework | CodeIgniter 4 (PHP ≥ 8.2) |
| Styling | Bootstrap 5 |
| JavaScript | Vanilla JS — ESLint (Airbnb style guide) |
| Database | MySQL (three migrations: `taglines`, `bios`, `github_activity`) |
| Testing | PHPUnit 10 + FakerPHP |
| Code style | PSR-12 |

Notable PHP dependencies: `hermawan/codeigniter4-datatables`, `ramsey/uuid`.

## Project Structure

```
app/
  Config/          # Framework and application configuration
  Controllers/     # Public, Admin/, Api/, CLI/, Debug/ controllers
  Database/        # Migrations and seeders
  Filters/         # Auth, admin, API, and debug filters
  Libraries/       # Markdown, Notification, Sendmail service wrappers
  Models/          # BioModel, TaglineModel, GitHubActivityModel
  Views/           # Blade-style PHP templates and partials
public/            # Web root (index.php, assets)
tests/             # PHPUnit unit and database tests
writable/          # Cache, logs, sessions, uploads (git-ignored)
```

## Admin

The admin area (`/admin`) is protected by a session-based `AdminFilter`. It provides:

- **Taglines** — create, edit, delete, and reorder taglines; toggle active status
- **Bio** — manage multiple bio versions and activate one at a time
- **GitHub Activity** — paginated DataTables view with inline label/link editing and bulk delete
- **Cache** — list cached files with expiry metadata; clear individual files or all at once

## CLI / Scheduled Tasks

```bash
# Fetch latest GitHub public events and store new ones in the database
php spark cli/fetch-github-activity
```

Intended to be run via crontab.

## API

| Method | Endpoint | Description |
|---|---|---|
| `GET` / `OPTIONS` | `/api/test/ping` | Health check — returns `{"status":"success","message":"pong"}` |
| `POST` | `/metrics/receive` | Receive anonymous page-performance metrics |

## Configuration

Copy `env` to `.env` and set values for:

- `app.baseURL`
- Database credentials (`database.default.*`)
- `GitHub.username` / `GitHub.token`
- `ApiKeys.masterKey` — shared key for inter-service API calls
- URLs for external services in `app/Config/Urls.php` (blog, status, bookmarks, auth, sendmail, notifications, metrics, markdown)

## Getting Started

```bash
# Install PHP dependencies
composer install

# Install JS dev dependencies
npm install

# Set up the database
php spark migrate

# Start the development server
php spark serve
```

## Testing

```bash
vendor/bin/phpunit
```

## Licence

See [LICENSE](LICENSE).
