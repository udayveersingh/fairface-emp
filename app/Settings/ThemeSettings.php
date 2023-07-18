<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ThemeSettings extends Settings{

    public string $site_name,$logo,$favicon,$currency_symbol,$currency_code,$theme_color;
    
    
    public static function group(): string
    {
        return 'theme';
    }
}