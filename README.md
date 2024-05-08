# Ed-tech Rostering App


---

## Quick Start/Installation

To start the application, clone the repository and run the following commands to install dependencies, build
assets, create the development environment, seed the database and run bellow commands:

* cp .env.example .env
* update database credentials in .env file
* composer install
* php artisan migrate --seed
* php artisan serve
```

## Developing

Test users are provided with the following credentials:

| Email                 | Password   | User Type|
|-----------------------|------------|----------|
| `teacher@test.com.au` | `password` | Teacher  |
| `student@test.com.au` | `password` | Student  |

You can use this to login to the application and access the various pages.


