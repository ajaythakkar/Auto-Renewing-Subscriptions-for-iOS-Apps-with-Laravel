## Auto Renewing Subscriptions for iOS Apps with Laravel

This repository help you to handle iOS Application Subscription on server side. 

It provides

- Save and Check User Subscription
- Check Webhook Logs
- Simple Admin panel for Check App User with device token and User subscription

## Getting Started
This demo for handel iOS Application Subscription server side.

### Installing
- Download the repository by cloning it or in zip format & extract to your project folder
- Run 'composer install' to install the packages used in this project.

```
composer install     
```
- Copy .env.example to .env & update the necessary parameters.
- import database/migrate (apple_subscription.sql), If your importing database credential email : admin, password : admin
```
php artisan migrate     
```  

### How it's works?
- There one api `api/subscribe` which is used for save/check subscription with parameters `original_transaction_id` and `device_token`
- This iOS app is made for usable for without login/register, So for that we are creating user with device token.
- For saving subscription store `original_transaction_id` which is we can get after apple subscription response.
- For checking subscription we are checking end_date from database which is update from webhook, 
API for webhook `api/webhook` and URL for webhook `https://example.com/api/webhook` this url we have to add in Apple account and `https` is must for Apple webhook.
- The `end_date` is updated from webhook when the some one cancel or subscription has beed expired.
- If you want to check webhook is working fine and check logs you can check all logs at `/logs`

## Source
- There are not clear documentation available but you can get more details <a href="https://medium.com/@AlexFaunt/auto-renewing-subscriptions-for-ios-apps-8d12b700a98f">here</a>
- I have get all idea from this source and created this demo for others     

## License

This project is free for anyone who wishes to copy and replicate / customize for their needs as long as they adhere to the license terms & conditions of the packages included.
