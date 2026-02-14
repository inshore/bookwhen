# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - TBD

### Added

- **Spec-driven development:** `docs/FUNCTIONAL_SPEC.md` and `docs/ENGINEERING_SPEC.md` define behaviour and engineering standards for all future amendments.
- **EditorConfig:** `.editorconfig` for consistent indentation and line endings.
- **Strict types and docblocks:** All `src/` files use `declare(strict_types=1);` and full docblocks for public API.
- **Named arguments:** Public API and internal call sites use named arguments where multiple optional parameters are used for clarity and refactor-safety.
- **CHANGELOG:** This file; README links to it for upgrade and migration.

### Changed

- **PHP requirement:** Raised from `^8.1 || ^8.2` to **`^8.3`**. PHP 8.1 and 8.2 are no longer supported.
- **PSR-12 and latest PHP style:** Codebase formatted to PSR-12; unused imports removed; use statements ordered alphabetically.
- **`Location` constructor:** Parameter order changed so required `id` comes first, then optional parameters (`additionalInfo`, `addressText`, `latitude`, `longitude`, `mapUrl`, `zoom`). All internal call sites updated to use **named arguments** when constructing `Location`. If you construct `Location` yourself, use named arguments or the new parameter order.
- **`Client`:** Constructor parameter `$transporter` is now typed (`Contracts\TransporterContract`). Unused imports removed; docblocks added.
- **`Factory`:** Added `declare(strict_types=1);`; docblock for `make()` corrected from "Open AI" to "Bookwhen".
- **Validation exception message:** Typo `includeEventssAttachments` corrected to `includeEventsAttachments` in `Bookwhen::ticket()` and `Bookwhen::tickets()`.
- **Scrutinizer:** Configuration updated for PHP 8.3 and post-refactor checks (see `.scrutinizer.yml`).

### Fixed

- **PHP 8+ deprecation:** Optional constructor parameters in `Domain\Location` were declared before required `$id`; reordered so required parameters come first.
- **README:** Requirements updated to PHP 8.3; code examples fixed (e.g. stray parentheses); link to this CHANGELOG added.

### Breaking changes summary

1. **PHP version:** You must run PHP 8.3 or newer. Composer will refuse to install on older PHP.
2. **`Location` constructor:** If you instantiate `InShore\Bookwhen\Domain\Location` directly, the parameter order has changed. Use named arguments for compatibility, e.g.  
   `new Location(id: $id, addressText: $addr, additionalInfo: $info, ...)`.
3. **`Client` constructor:** The `$transporter` parameter is now strictly typed; any custom transporter must implement `InShore\Bookwhen\Contracts\TransporterContract`.

---

[1.0.0]: https://github.com/inshore/bookwhen/compare/v0.10.0...v1.0.0
