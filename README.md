# SoulCodes
A WP plugin that allows creation and management of shortcodes via a GUI.

## Build
This package may depend on other WP plugin packages. If in WordPress environment, add the following
the following configuration before `composer install` to install dependencies which are WP plugins
alongside this plugin:

```json
{
    "extra": {
        "installer-paths": {
            "../{$name}/": ["type:wordpress-plugin"]
        }
    }
}
```