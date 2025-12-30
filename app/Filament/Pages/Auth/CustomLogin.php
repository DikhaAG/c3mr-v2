<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString; // Ini wajib ada untuk memperbaiki error "Found HtmlString"

class CustomLogin extends Login
{
    public function getHeading(): string|Htmlable
    {
        // Menggunakan HtmlString agar tag <img> dan <div> dirender sebagai HTML, bukan teks biasa
        return new HtmlString("
            <div class='flex flex-col  gap-4' style='display: block'>
                <img src='" . asset('images/logo-indihome.png') . "' width='200' height='200' alt='Logo' class='h-16 w-auto'>
                <span class='text-xl font-bold tracking-tight text-center text-red-600' style='color: red;'>C3MR - Data Calling</span>
            </div>
        ");
    }
}
