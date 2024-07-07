<h1>Note:</h1>
<p>Commend to activate the code when clone from GitHub and for env (note: for seed can seed only admin and it will create user also) </p>
<li>git clone <___link___>
<li>composer install</li>
<li>cp .env.example .env</li>
<li>php artisan key:generate</li>
<li>php artisan migrate --seed</li>
<li>php artisan serve</li>

<h2>Please insert this to env file for Folder Api in order to test Admin Api Work</h2>
<li>ADMIN_USER_ID=1</li>
