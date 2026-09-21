This repo contains the code for Philip Newborough's website.

## PHP

This site uses CodeIgniter 4, which is a PHP framework. The code style for this project follows the PSR-12 coding standard, which is a widely accepted standard for PHP code.

## JavaScript

This site uses JavaScript for interactivity and dynamic content. The code style for this project follows the Airbnb JavaScript Style Guide, which is a widely accepted standard for JavaScript code.

## CSS

The CSS framework is Bootstrap 5.3.8. Bootstrap Icons are available. Use Bootstrap utility classes where possible. If writing custom CSS classes, use existing bootstrap variables where possible for colours etc.

Custom styles live in `public/assets/sass/bootstrap-custom.scss` and compile to `public/assets/css/vendor/bootstrap-custom.css`. After editing the Sass, run `npm run sass` to compile (this watches for changes using the bundled Dart Sass binary in `misc/dart-sass`).

## Build & assets

Vendor assets (Bootstrap JS, Bootstrap Icons, Inter font) are copied from `node_modules` into `public/assets` via npm scripts rather than imported directly:

- `npm run copy-bootstrap-js`
- `npm run copy-bootstrap-icons`
- `npm run copy-inter`
- `npm run sass`

Re-run the relevant script after updating a dependency in `package.json`.

## Testing

Tests use PHPUnit and live in `tests/`. Run the suite with `composer test` (or `vendor/bin/phpunit`). Add or update tests when changing behaviour in `app/`.

## Misc

- When prompting for user feedback, e.g. Deleting a record, always use a bootstrap modal.
- There is a local apache instance running and this site is available at http://philipnewborough.localhost
- The overall design of this website needs to be very professional and work well on desktops, tablets and mobile devices.
- Never use em dashes within copy.