# GooglePolyline

[![run-tests](https://github.com/Traewelling/GooglePolyline/actions/workflows/php-tests.yml/badge.svg)](https://github.com/Traewelling/GooglePolyline/actions/workflows/php-tests.yml)
[![PHPStan](https://github.com/Traewelling/GooglePolyline/actions/workflows/phpstan.yml/badge.svg)](https://github.com/Traewelling/GooglePolyline/actions/workflows/phpstan.yml)
![GitHub License](https://img.shields.io/github/license/Traewelling/GooglePolyline)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/e8fcc71d1de9447db8893cb0944bf102)](https://app.codacy.com/gh/Traewelling/GooglePolyline/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
[![Codacy Badge](https://app.codacy.com/project/badge/Coverage/e8fcc71d1de9447db8893cb0944bf102)](https://app.codacy.com/gh/Traewelling/GooglePolyline/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_coverage)

Since [Transitous](https://transitous.org/)/[Motis](https://github.com/motis-project/motis) uses a non-standard
implementation of
Google's [Encoded Polyline Algorithm Format](https://developers.google.com/maps/documentation/utilities/polylinealgorithm),
we needed to implement a custom decoder for it.

Motis returns a EPAF string in the `legGeometry` field with a custom precision of 7 decimal places in v1 and 6 decimal
places in v2.
Google's implementation uses 5 decimal places, so we need to adjust the precision accordingly.

This package supports every possible precision but is only tested with 5 and 6 decimal places.
