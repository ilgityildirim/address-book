Information
========================
* Please excuse the layout as this was rather a backend task (or at least my take of it). 
Should you want ReactJS / VueJS / SPA / PWA on this project, please let me know.

* I used my own image, at the moment I did not have a ready PHP-FPM image for 7.0. Thus used what I had; PHP 7.2. 
However code is suitable for 7.0

* Since picture / upload was optional, I haven't added it. 
Instead, I spend a little additional time on preparing a better structure

* Controller approach is ADR. I find it cleaner & easier. Symfony 4.x would have a better implementation for ADR.

* Nginx (Docker) is using self-signed SSL certificate. Which is why your browser won't see it as valid. 
Just confirm the warning to proceed.

* Docker is tested on Linux OS. I don't own other OS so could not check & verify it at this time.

Requirements
--------------
The address book should contain the following data:

* Firstname
* Lastname
* Street and number
* Zip
* City
* Country
* Phonenumber
* Birthday
* Email address
* Picture (optional)

Please use the following techniques:
* Symfony 3.4
* Doctrine with SQLite
* Twig
* PHP 7.0

Installation
--------------
* Create `.env` file from `.env.dist` and setup a suitable IP (`DOCKER_GATEWAY_IP` and `DOCKER_SUBNET`). 
You don't have to change values.

* Add `[IP ADDRESS] [LOCAL DOMAIN]` to `/etc/hosts`. If you have not change values then it would be 
`172.90.0.1 local.addressbook.com`. LOCAL DOMAIN / URL can be anything you like. 

* Execute `make start` command in the root directory of this project. If it is **the very first time** you can use
`make init` command or follow 3 next **Only for the first time** steps below.

* **Only for the first time** execute `make composer_install` command in the root directory of this project to create 
SQLite database (only once is enough). Data is persistent.

* **Only for the first time** execute `make create_database` command in the root directory of this project to create 
SQLite database (only once is enough). Data is persistent.

* **Only for the first time** execute `make assets` command in the root directory of this project to generate assets.

* **Important;** if you have permission related issues, execute `make fix_permissions` command.

* See [docker.md](./doc/docker.md) for additional information about docker

