<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateThemeSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('theme.site_name',config('app.name'));
        $this->migrator->add('theme.logo','placeholder_image.jpg');
        $this->migrator->add('theme.favicon','1728028665.png');
        $this->migrator->add('theme.currency_symbol','$');
        $this->migrator->add('theme.currency_code','USD');
        $this->migrator->add('theme.theme_color','purple');
    }
}
