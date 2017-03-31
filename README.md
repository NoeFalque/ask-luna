Ask Luna
========
All your questions about space, answered every day with one image and one topic.

![Ask Luna](https://github.com/NoeFalque/intensive-space/blob/master/public/assets/img/screen.jpg?raw=true)

### Features
* Astronomy Picture of the Day
* Users w/profile & settings
* Questions w/likes
* Answers w/upvotes & downvotes
* Gamification w/achievements
* Search among APOD history
* Notifications
* Flash messages

### Usage
#### Requirements
* [Node.js](https://nodejs.org/en/) installed
* [Composer](https://getcomposer.org/) installed

#### Installation
- Use `composer install` on root folder
- Use `composer dump-autoload` on root folder
- Import database structure from `db.sql`
- Update config values in `App/config.yml`
- Set the `public` folder as Web server root

#### Edit the project
If you wish to update project files, all assets sources are available in the `src` folder with a gulp configuration to update output assets.

### Dependencies used
* [Twig](https://github.com/twigphp/Twig)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [YAML Parser](https://github.com/symfony/yaml)
* [League\Event](http://event.thephpleague.com/2.0/)
* [Google APIs Client](https://github.com/google/google-api-php-client)
