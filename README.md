# WeatherAPI

## About The Project

I have created this project for a reason of deepening my laravel and php knowledge,
because of self interest and possibilities of creating something more advanced and useful in everyday
world.

### Challenges

* Implementing Docker into built laravel project (was not done)
* Writting mocked unit tests for the project
* Learning and implementing SOLID principles
* Creating a strategy for efficient project implementation

### Built With

A list of libraries, tools and frameworks used in project.

* [Laravel](https://laravel.com)
* [PHP](https://www.php.net/)
* [PHPUnit](https://phpunit.de/)
* [Faker](https://faker.readthedocs.io/en/master/)
* [Mockery](http://docs.mockery.io/en/latest/index.html)

## Getting Started

Instructions to run project and set it up.

### Installation and set up

1. Clone repository
   ```sh
   https://github.com/Apozzz/WeatherAPI.git
   ```
2. Go to laravel project in file system
   ```sh
   cd laravel
   ```
3. Install composer
   ```sh
   composer install
   ```
4. Delete laravel.log file in laravel\storage\logs
5. Change .env.example file to .env and modify it
   according to your database + set up.
6. Generate new key
   ```sh
   php artisan key:generate
   ```
7. If database is not set up, then run
   ```sh
   php artisan migrate:fresh
   ```
   afterwards run
   ```sh
   php artisan db:seed
   ```
   
### Project launch and tests

To run tests you have to populate database first
and then run command
   ```sh
   php artisan test
   ```
To run project itself run command
   ```sh
   php artisan serve
   ```
   
## Use of API service

Add this part to the current URL.
   ```sh 
   /api/products/recommended/'city name'
   ``` 
URL example with localhost. 
   ```sh
   127.0.0.1.8000/api/products/recommended/mazeikiai
   ```
City can not contain lithuanian letters, but it can start with capital first letter.
