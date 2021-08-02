## Covid daily statistics

First table "Covid-19 statistics by request" show statistical data by user's submitted requests, according "from", "to" and "country" parameters. This results are fetched directrly from external API service.

By default it show last month data for Lithuania. 

<p align="center"><a href="" target="_blank"><img src="https://i.ibb.co/QvsgZQh/Screenshot-1.png" alt="Screenshot-1" border="0"></a></a></p>

Second table "Covid-19 latest statistics" show latest total statistical data for all country of last day. This daily updated data is fetched automatically from 3rd API service  once a day by our Task Scheduler/CRON, and then persisted into our local database. So we do not make calls to API service everytime anymore, until next day. All data showed in that table are retrivedfrom DB.  

<p align="center"><a href="https://ibb.co/N2N2tZq"><img src="https://i.ibb.co/d4p4jGv/Screenshot-2.png" alt="Screenshot-2" border="0"></a></p>

When we deploy app or first time, enter he following command "php artisan covid:update", to fetch data from API service instantly, and do not wait when CRON service updates data by schedule.  

- composer install
- php artisan key:generate
- php artisan migrate
- php artisan covid:update.
