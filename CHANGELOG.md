# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

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