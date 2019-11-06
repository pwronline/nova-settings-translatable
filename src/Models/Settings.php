<?php

namespace Pwronline\NovaSettingsTranslatable\Models;

use Illuminate\Database\Eloquent\Model;
use Pwronline\NovaSettingsTranslatable\NovaSettings;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasTranslations;
    
    protected $primaryKey = 'key';
    protected $table = 'nova_settings';
    public $incrementing = false;
    public $timestamps = false;
    public $fillable = ['key', 'value'];

    public $translatable = ['value'];

    public function getValueAttribute($value)
    {
        $customFormatter = NovaSettings::getCustomFormatter();

        if (isset($customFormatter)) return call_user_func($customFormatter, $this->key, $value);

        return $value;
    }

    public static function getValueForKey($key)
    {
        $setting = static::where('key', $key)->get()->first();
        return isset($setting) ? $setting->value : null;
    }
}
