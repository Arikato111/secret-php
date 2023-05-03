<p align="center">
<img align="center" alt="php" height="30" width="40" src="https://raw.githubusercontent.com/Arikato111/Arikato111/main/icons/php-plain.svg">
<img align="center" alt="mysql" height="30" width="40" src="https://github.com/Arikato111/Arikato111/raw/main/icons/mysql-original-wordmark.svg">
<img align="center" alt="tailwindcss" height="30" width="40" src="https://github.com/devicons/devicon/raw/master/icons/tailwindcss/tailwindcss-plain.svg">
</p>

# <p align="center">Social web php</p>

This is a project to create a social media website to send teachers.
but this can be production and I try to write a real use case.

## Others

 - #### [social web react](https://github.com/Arikato111/social-web-react)  -> this is the front-end website to working with api (not release)

 - #### [android app](https://github.com/Arikato111/social-web-php/tree/flutter-app) -> application version on android but it's just open website in app. `I'm not sure it really works.`
    - [download app click here](https://github.com/Arikato111/social-web-php/blob/flutter-app/release/v1.0.0.apk?raw=true)
## Get started

#### with apache

- clone this repository
- move all **files** and **folders** in this repository to `./htdocs`
- **don't create others folder**
- import `database.sql` to your database
- create `.env` like `.env.example` and enter your database connection
- `yarn` or `npm i` to install packages
- if using `linux` don't forget to change permission `public` folders and all inside
- open [localhost](http://localhost) on your browser
- login with the admin account
  - username : `nawasan`
  - password : `admin`

## Inside it

- PHP-8.1 + MySQL
- [Tailwindcss](https://tailwindcss.com)
- [control](https://github.com/Arikato111/control)
- [spelte](https://github.com/Arikato111/spelte-php)
  - [use-import](https://github.com/Arikato111/use-import/tree/master)
  - [spelte](https://github.com/Arikato111/spelte-php/tree/module)
  - [dotenv](https://github.com/Arikato111/php-dotenv/tree/main)
  - [wisit-router](https://github.com/Arikato111/wisit-router/tree/master)
  - [wisit-express](https://github.com/Arikato111/wisit-express/tree/Release1.0)

## Need to know

- about api method must use only GET, POST; 
- when use others method use $_GET['method'] to check method
- when frond-end request with others method will use params in url : example `/api/post?method=delete`