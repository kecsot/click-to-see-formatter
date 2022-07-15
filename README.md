# Click To See Formatter Drupal Module
This is text formatter (yet). This module is hide content until user doesn't click to '** Click to See **' text.
The content will be visible after the click.

> core_version_requirement: ^9 || ^10

# Important !
This module doesn't use ajax! The content is sent to client when it isn't visible! It's just CSS and JS.

# How to use?
Add github repository to you composer.json

    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:kecsot/click-to-see-formatter.git"
        }
        
Require module
>    composer require kecsot/click_to_see_formatter
 
Enable module
>    drush en click_to_see_formatter

Use formatter
