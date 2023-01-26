## Repository Maker (Laravel)
Generate repository and interface files easily in your laravel projects.

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

## New update:

## Generate a New Service File
```
$ php artisan make:service NewService
```
It will generate service file with name "NewService" in App\Services

## Generate New Service with Interface File
```
$ php artisan make:service NewService --i
```
It will generate service file with name "NewService" in App\Services and "NewServiceInterface" in App\Services\Interfaces