<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('marketify:welcome', function () {
    $this->comment('Marketify ecommerce starter is ready.');
})->purpose('Display a Marketify welcome message');
