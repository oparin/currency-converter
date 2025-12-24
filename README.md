# 1. Create directories structure
mkdir -p app/Modules/CurrencyConverter/{Contracts,Services,Jobs,Console/Commands,Models,Providers,Facades,Http/Controllers/Admin,Resources/views/admin/exchange-rates,Database/{Migrations,Seeders},Tests}

# 2. Register provider bootstrap/providers.php
return [
// ...
App\Modules\CurrencyConverter\Providers\CurrencyConverterServiceProvider::class,
],

# 3. Create config file and migrations
php artisan vendor:publish --tag=currency-converter-files

# 4. Run migrations
php artisan migrate

# 5. Run seeder
php artisan db:seed --class="App\Modules\CurrencyConverter\Database\Seeders\CurrencySeeder"

# 6. Update rates
php artisan currency:update-rates
