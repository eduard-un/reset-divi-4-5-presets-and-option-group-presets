# Reset Divi Presets

- **Contributors:** Pavel Kolpakov, Eduard Ungureanu
- **Requires at least:** 5.0
- **Tested up to:** 6.4
- **Stable tag:** 2.0.0
- **License:** GPLv2 or later
- **License URI:** https://www.gnu.org/licenses/gpl-2.0.html

Adds a convenient admin bar menu to quickly reset Divi 4 and Divi 5 global presets without leaving the page you are on.

## Description

This plugin provides a simple and efficient way to clear Divi's 4 Element Presets as well as Divi 5 Element and Option Group Presets. After activation, a new menu item, "Reset Divi Presets," is added to the WordPress admin bar, visible to users with `manage_options` capabilities.

This menu contains three options:

*   **Reset Divi 4 Presets:** Deletes the global presets associated with Divi 4.
*   **Reset Divi 5 Presets:** Deletes the global presets associated with Divi 5.
*   **Reset Global Variables:** Clears the `et_global_data` from the `et_divi` option and deletes the `et_divi_global_variables` option from the database.

## How It Works

The plugin is designed to be non-intrusive and easy to use:

1.  **Works on Frontend and Backend:** You can reset presets from anywhere on your site, whether you are in the WordPress admin area or viewing the live site.
2.  **No Page Reloads:** Clicking a reset option will not redirect you. You remain on the current page, allowing for a seamless workflow.
3.  **Confirmation Dialog:** To prevent accidental resets, a confirmation prompt will appear before any action is taken.
4.  **Instant Feedback:** A notice will appear confirming that the presets have been reset.

This tool is particularly useful for developers who need to clear out old or unwanted preset styles during site development or maintenance.
