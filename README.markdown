# WordPress Example Theme=

## Code Structure

```
themeDirectory/
    /css
    /js
        /vendor
    /img
    /scss
    /src
        /Namespace
            /ThemeName
                ThemeName.php
    /tests
    bootstrap.php
    404.php
    archive.php
    etc.php
    etc.php
    README.md
```

All themes should follow this directory structure, and be named using PSR-2
naming conventions. If you're writing for PHP 5.3+ then use namespaces, and
build a directory structure around those namespaces to enable use of a PSR-0
autoloader function. For example, if we're writing a plugin to create a custom
post type of Books for use in the WordPress admin, the class may look like this:

### Example PHP 5.3 Class
```
<?php

namespace KevinSPerrine\CustomTheme;

use KevinSPerrine\Facade\WordPress;

class CustomTheme
{
    public function __construct(WordPress $facade = null)
    {

    }
}
```

However, if you're writing for PHP < 5.3, then the structure stays the same, but the classes get altered slightly to account for PHP's lack of namespaces in older versions.

### Example PHP 5.2 Class
```
<?php

class KevinSPerrine_CustomTheme_CustomTheme
{
    public function __construct(KevinSPerrine_Facade_WordPress $facade = null)
    {

    }
}
```

In either case, the appropriate directory structure is `/src/KevinSPerrine/CustomTheme/CustomTheme.php`.

The Theme class should be initialized in the `functions.php` along a custom autoloader, and other constant declarations.

### Example functions.php
```
<?php

function CustomThemeAutoloader($className)
{
    $paths = array(
        'src/'
    );

    if (stripos($className, "KevinSPerrine") === false) {
        return;
    }

    foreach ($paths as $path) {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }
}

spl_autoload_register('CustomThemeAutoloader');

global $CustomTheme;

$CustomTheme = new KevinSPerrine_CustomTheme_CustomTheme(); // PHP 5.2
// $CustomTheme = new KevinSPerrine\CustomTheme\CustomTheme(); // PHP 5.3

$CustomTheme->initialize();
```

## Styleguide
All PHP must follow PSR-2. The full styleguide can be be found [here](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), but a few of these are:

* Code MUST use 4 spaces for indenting, not tabs.
* There MUST NOT be a hard limit on line length; the soft limit MUST be 120 characters; lines SHOULD be 80 characters or less.
* There MUST be one blank line after the namespace declaration, and there MUST be one blank line after the block of use declarations.
* Opening braces for classes MUST go on the next line, and closing braces MUST go on the next line after the body.
* Opening braces for methods MUST go on the next line, and closing braces MUST go on the next line after the body.
* Visibility MUST be declared on all properties and methods; abstract and final MUST be declared before the visibility; static MUST be declared after the visibility.
* Control structure keywords MUST have one space after them; method and function calls MUST NOT.
* Opening braces for control structures MUST go on the same line, and closing braces MUST go on the next line after the body.
* Opening parentheses for control structures MUST NOT have a space after them, and closing parentheses for control structures MUST NOT have a space before.


## Based on HTML5 Boilerplate for Wordpress
This theme is built on the [HTML5 Boilerplate](http://html5boilerplate.com/) by Paul Irish and Divya Manian. The sole purpose of this theme is to save developers the time it takes to apply the HTML5 Boilerplate to WordPress. The "HTML5 Boilerplate" name is used with permission from Paul Irish.

The layout is based on Bruce Lawson's [Designing a Blog with HTML5](http://html5doctor.com/designing-a-blog-with-html5/)

Instead of using only DIVs for content layout, it uses new HTML5 tags, including [header](http://html5doctor.com/the-header-element/),
[footer](http://www.w3schools.com/html5/tag_footer.asp),
[nav](http://www.w3schools.com/html5/tag_nav.asp),
[article](http://www.w3schools.com/html5/tag_article.asp),
and [section](http://html5doctor.com/the-section-element/).

It's a very bare layout, including only the base styles that come with the boilerplate and required WordPress styles, so layout is up to you. Alternatively, you could apply the methods used here to other themes.

Getting Started
---------------
1. Add the html5-boilerplate-for-wordpress folder to your wp-content/themes folder.
2. Activate the theme. WP-Admin > Appearance > Themes
3. Add some of the "Root Files" to the root directory of your website (explained below).
4. Style away, knowing that you're building on a super solid base with HTML5 awesomeness.

Root Files
----------
These files can be found in the html5-boilerplate folder in the theme (html5-boilerplate-for-wordpress/html5-boilerplate). Some of the files listed here should be (carefully) moved to the root of your site (same level as the wp-content directory). Read on for specific instructions.

### 404 Page
If you use permanlinks (WP-Admin > Settings > Permalinks), then WordPress handles any 404s with the 404.php included in the theme. If you don't use permalinks, then add the 404.html file to the root of your site.

### crossdomain.xml
If you don't know what this is, you probably don't need it.
www.adobe.com/devnet/flashplayer/articles/cross_domain_policy.html

### robots.txt
Tells all search engines that they can read and index all pages. This is handled by WordPress so you shouldn't need to move this to the root.

Root Images
-----------
These aren't included with the HTML5 Boilerplate, but links to them are, so these were created so that you don't return a 404 when the browser requests them. Better to include these or make your own, than not include any. The can be found in the images folder of the theme (html5-boilerplate-for-wordpress/images).

### favicon.ico
The favicon is the icon shown to the left of the URL at the top of your browser window.

### apple-touch-icon.png
On iPhones and iPads you can book mark a web page and have it show up on the home screen as an icon. The apple-touch-icon.png becomes this icon if used. Rounded corners and glossy finish are added by the device.

License
-------

The Unlicense (aka: public domain) http://unlicense.org
