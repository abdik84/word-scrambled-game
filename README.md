# Word Scrambled Game
## _Guess the Countries Name_

This project is created for Technical Test as a Web Backend Developer at StickEarn :)).

## How to play?
- Input your username then start the game.
- There will be 10 questions that contains scrambled countries name
- Every correct answer give you 10 points while the wrong answer deduct 10 of your points
- You will see your total points at the end of the game
- Refresh the page will reset all of your progress, do it carefully!


## Tech

This project uses a number of open source framework to work properly:

- [Laravel 8](https://laravel.com/) - The PHP Framework for Web Artisans
- [Bootstrap CSS](https://getbootstrap.com/) - CSS Framework
- [jQuery](https://jquery.com/) - Javascript Framework
- [SweetAlert2](https://sweetalert2.github.io/) - Javascript alert plugins
 
 ## Requirements
 - PHP >= 7.3
 - [Composer](https://getcomposer.org/)

## Installation
```sh
# clone the repository
git clone https://github.com/abdik84/word-scrambled-game.git
cd word-scrambled-game
# install laravel
composer install
# setup environment
cp .env.example .env
# generate app key
php artisan key:generate
# run laravel migration to generate table to database
# make sure you have setup your database configuration on .env file
php artisan migrate
# seed admin to table admin
php artisan db:seed
# start development server
php artisan serve
```

## Testing


#### Game 
Your development server will run at [localhost:8000](http://localhost:8000) by default

#### Administrative Panel
For administrative panel, visit [localhost:8000/admin](http://localhost:8000/admin)

username: admin
password: admin





## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

**Free Software :D**