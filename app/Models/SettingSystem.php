<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingSystem extends Model
{
    use HasFactory;

    protected $table = 'setting_systems';

    protected $fillable = [
        'close_door',
        'open_door',
        'hour_table',
    ];

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = self::first();
        }

        return self::$instance;
    }

    public static function getHourOpen()
    {
        $instance = self::getInstance();
        return $instance ? $instance->open_door : null;
    }
    
    public static function getHourTable()
    {
        $instance = self::getInstance();
        return $instance ? $instance->hour_table : null;
    }
    
    public static function getHourClose()
    {
        $instance = self::getInstance();
        return $instance ? $instance->close_door : null;
    }
}