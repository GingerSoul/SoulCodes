# SoulCodes
A WP plugin that allows creation and management of shortcodes via a GUI.

## Build
To build this package, first install dependencies including dev by running
`composer install`. Then run Phing, giving it the version parameter, e.g.
`vendor/bin/phing -Dversion=0.1.0alpha1`. This will create an archive with
a corresponding name, plus project name and timestamp, in `build/release`
directory of the project. The build will only include what is committed
on the currently checked out branch. It will not include uncommitted
changes from the working directory. It will also not alter any files of
the project outside the `build` directory.
