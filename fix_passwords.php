<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

\App\Models\User::whereIn('email', ['test@example.com', 'user@test.com'])->update(['password' => bcrypt('password')]);

echo "Passwords updated successfully\n";