# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [0.1.0] - 2025-12-25

### Added

- Global facade `D` (global namespace) and helper function `d()` for fast debugging.
- `D::reset()` to reset facade state (intended for tests).
- Examples: `examples/example06.php`, `examples/example07.php`.

### Fixed

- Call-site resolution: `d()` / `D::dump()` now reports the real user file/line instead of the facade file.
- `Debugger::errorHandler()` no longer appends garbage `\"` to the log message.
