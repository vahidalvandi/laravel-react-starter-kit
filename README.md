# laravel-react-starter-kit
A Laravel back-end &amp; React front-end starter kit with registration, login, authentication &amp; logout (laravel/passport, React router, Redux, Axios &amp; Interceptor )

## Requirements
- Node JS - version 16+
- PHP - version 8+
- Laravel - version 10+

## Installation
Clone the repository: (You may use ssh or github cli)
```sh
https://github.com/nazmussakib44/laravel-react-starter-kit
```
## For Back-end
Go to starter backend folder and edit .env file to connect your database.
> You may find env.example file just rename it to .env file and connect your database.

```sh
cd starter-backend
```

Open .env file and edit
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=starter // add your database name
DB_USERNAME=root // your username
DB_PASSWORD=root //your password
```

Generate app key
```
php artisan key:generate
```

Install composer
```sh
composer install
```

Install passport if you have not installed before
```
php artisan install:api --passport
```

Generate passport keys
```
php artisan passport:keys
```

Update your passport personal access client id and client secret.
```
PASSPORT_PERSONAL_ACCESS_CLIENT_ID=.........
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=........
```

Run backend
```sh
php artisan serve
```
You should see the ready URL with. 

## For Front-end
Go to frontend folder
```sh
cd starter-frontend
npm install --legacy-peer-deps
```
Open config.js file and change apiUrl based on your environment
```
const env = 'dev'; //change it to const env  = 'prod'; for build and run command npm run build

const dev = {
    apiUrl: 'http://127.0.0.1:8000', //for development environment
    env: env
};

const prod = {
    apiUrl: 'https://cloud.net.au', //for production environment
    env: env
};

const config = {
    dev,
    prod
};

module.exports = config[env];
```
Run the front-end
```sh
npm run dev
```


**!!!And you are ready to go!!!**

## License

MIT