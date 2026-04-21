<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\MUser::where('username', 'admin')->first();
if ($user) {
    echo "User found: " . $user->username . "\n";
    echo "Hash: " . $user->password . "\n";
    if (\Illuminate\Support\Facades\Hash::check('login', $user->password)) {
        echo "Password 'login' is CORRECT\n";
    } else {
        echo "Password 'login' is WRONG\n";
    }
} else {
    echo "User NOT found\n";
}
