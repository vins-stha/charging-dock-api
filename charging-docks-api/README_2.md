
## About this application
Deployable in both local environment as well as via docker-environment
- endpoints
    - `/api/v1/company `
    -  `/api/v1/station`
    -  `/api/v1/company/{id}`
    -  `/api/v1/station/{id}`
    -  `/api/docs    `
#### How to get this app running
- clone the app `git clone https://github.com/vins-stha/charging-dock-api.git`
- pull from `develop` branch 
- install dependencies with `composer install` from the root directory
- make migrations via php `artisan migrate:fresh`
- deploy with` php artisan serve`
- test with  `php artisan test`

#### How to get this app running in docker
- clone the app `git clone https://github.com/vins-stha/charging-dock-api.git`
- pull from `develop` branch 
- from root folder` docker-compose up --build -d `
- access to terminal of the app with `docker exec -it CONTAINER_ID sh`
- make migrations via php `artisan migrate:fresh`
- deploy with `php artisan serve`

