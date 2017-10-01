# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [1.1.0] - 2017-10-01
### Added
- Notifications

## [1.0.9] - 2017-01-26
### Added
- Merge Dev and Master branches
- Subscribe to newsletter form on theme admin page

### Fixed
- Code style
- Footer social buttons issue #7

## [1.0.8] - 2016-08-08
### Fixed
- Fix some code missing in last version

## [1.0.7] - 2016-07-29
### Fixed
- Fix WP editor read more tag image height (thanks @josephbydeign)

## [1.0.6] - 2016-04-27
### Added
- Theme admin page

### Changed
- Theme logo replaced with custom logo support

### Fixed
- Project list hero block (thanks @racheljcox)
- Page hero block

## [1.0.5] - 2016-04-11
### Changed
- Remove registration of color schemes styles

## [1.0.4] - 2016-04-07
### Added
- Inline docs for filters

### Changed
- Rename pine_portfolio_terms filter to pine_portfolio_taxonomy
- Remove registration of customize controls styles and scripts

### Removed
- Remove searchform HTML5 support. Theme already have searchform.php file.

## [1.0.3] - 2016-03-08
### Changed
- Fonts are loaded trough wp_enqueue_style.
- Change theme url
- Replace default logo with generic logo
- Fix file endings on php files

## [1.0.2] - 2016-03-07
### Added
- Images source and licence informations.

### Changed
- Removed web font loader script. Fonts are imported trough CSS.
- Header Customizer section. Header controls are moved to default Site Identity section.
- Front Page Customizer section name is replaced with default "Static Front Page".
- Footer text is translatable.
- Link to Background-check licence.

### Removed
- Custom background feature.
- Blank line on the end of page.php.

## [1.0.1] - 2016-03-04
### Added
- 'pine_portfolio_post_type', 'pine_portfolio_posts_per_page' and 'pine_portfolio_terms' filters
- Change log
- Branch for theme developers. Master branch follows WordPress.org releases.

### Changed
- Color scheme styles are separated
- Google web font loader url is replaced with jsdelivr
- Prefix specific theme functions with theme slug
- Remove 'featured-image-header' tag
- Prefix scripts and styles handlers with theme slug

### Fixed
- WordPress PHP Coding Standards errors and warnings
- Footer custom social icon class bug
- Fix Pine_Sanitize_Select constructor name

### Removed
- Slicejack dashboard widget
- languages/pine.pot file
- Minified css and js files
- Remove development files from master branch

## [1.0.0] - 2015-11-27
### Added
- Initial github release