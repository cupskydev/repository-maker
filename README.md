## Repository Maker
Generate repository and interface files easily.

## Installation
You need to install it via composer
```
$ composer require cupskydev/repository-maker
```

## Generate a New Repository File
```
$ php artisan make:repository NewRepository
```
It will generate repository file with name "NewRepository" in App\Repositories

## Generate New Repository with Interface File
```
$ php artisan make:repository NewRepository --i
```
It will generate repository file with name "NewRepository" in App\Repositories and "NewRepositoryInterface" in App\Repositories\Interfaces