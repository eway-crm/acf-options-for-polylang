=== ACF Options For Polylang ===
Contributors: momo360modena, BeAPI
Author URI: https://beapi.fr
Plugin URL: https://github.com/BeAPI/acf-options-for-polylang
Requires at Least: 4.7
Tested Up To: 5.2
Tags: acf, polylang, option, options, options page, advanced custom fields
Stable tag: 1.1.6
Requires PHP: 5.6

Add ACF options page support for Polylang.

== Description ==

You are using Advanced Custom Fields for creating option pages and you have Polylang installed for awsome multilingual site ?

Sadly, Polylang is not handling ACF's Option Pages. Which means values will be the same for all languages you have set.

We are here to save your life ! Once this plugin is activated, you will be able to set a different value for each language, and if none is set, the "All languages" value will be used as default one.

***Please refer to [Github](https://github.com/BeAPI/acf-options-for-polylang) for detailed usage instructions and issues.***

## Features

- Almost simple fields (text, textarea, links, etc)
- Repeater fields (with simple fields)

**How ?**

This plugin will store a value for each language into database. Then Polylang's languages are used to get the values from the DB. <b>That means at activation, all existing data will not be anymore available, but still in database. You will retrieve it ad plugin deactivation.</b>

Then to set and contribute your option page, simply use the Polylang's language admin flags ui.

== Frequently Asked Questions ==

**Requirements**

* [Advanced Custom Fields](https://www.advancedcustomfields.com/pro) 5.6.0+
* [Polylang](https://polylang.pro/)

**Installation**

First activate and configure ACF & Polylang on you site.
Then activate ACF Options For Polylang to handle ACF Options in setted Polylang's languages.

***WordPress***

- Download and install using the built-in WordPress plugin installer.
- Site activate in the "Plugins" area of the admin.
- Optionally drop the entire `acf-options-for-polylang` directory into mu-plugins.
- Nothing more, this plugin is ready to use !

***Composer***

- Add repository source : `{ "type": "vcs", "url": "https://github.com/BeAPI/acf-options-for-polylang" }`.
- Include `"bea/acf-options-for-polylang": "dev-master"` in your composer file for last master's commits or a tag released.
- Nothing more, this plugin is ready to use !

== Changelog ==

*  1.1.7 - XX May 2019
    * Feature: Add a context-sensitive help to the user on ACF options page (tired of updating the generic options ...)
    * Feature: Improve object detection from ACF with get_field()
    * Feature: Add translation POT and french translation
    * Test: Test up on WP 5.2
    * FIX [#41](https://github.com/BeAPI/acf-options-for-polylang/issues/41) : fix bug with all language failback and repeater
* 1.1.6 - 19 Mar 2019
    * FIX [#32](https://github.com/BeAPI/acf-options-for-polylang/issues/32) & [#40](https://github.com/BeAPI/acf-options-for-polylang/issues/40) : fix `get_field()` if an object is provided (WP Term, WP Post, WP Comment)
* 1.1.5 - 11 Dec 2018
    * FIX wrong constant
* 1.1.4 - 13 Nov 2018
    * Refactor by adding the Helpers class
    * FEATURE [#26](https://github.com/BeAPI/acf-options-for-polylang/issues/26) : allow to precise to show or hide default values for a specific option page
    * FEATURE [#21](https://github.com/BeAPI/acf-options-for-polylang/pull/21) : handle custom option id
* 1.1.3 - 2 Aug 2018
    * FEATURE [#23](https://github.com/BeAPI/acf-options-for-polylang/pull/23) : requirement to php5.6 whereas namespace are 5.3
* 1.1.2 - 31 Jul 2018
    * FIX [#22](https://github.com/BeAPI/acf-options-for-polylang/pull/22) : error with repeater fields default values
* 1.1.1 - 9 Mai 2018
    * FIX [#15](https://github.com/BeAPI/acf-options-for-polylang/issues/15) : way requirements are checked to trigger on front / admin
* 1.1.0 - Mar 2018
    * True (complet) plugin.
    * Add check for ACF 5.6.
* 1.0.2 - 23 Dec 2017
    * Refactor and reformat.
    * Handle all options page and custom post_id.
    * Now load only if ACF & Polylang are activated.
    * Load later at plugins loaded.
* 1.0.1 - 19 Sep 2016
    * Plugin update.
* 1.0.0 - 8 Mar 2016
    * Init plugin.
