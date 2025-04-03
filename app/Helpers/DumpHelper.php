<?php

namespace App\Helpers;

class DumpHelper
{
    /**
     * Выводит данные в лог для отладки
     */
    public static function debug($data, $label = null)
    {
        if (config('app.debug')) {
            $output = $label ? "DEBUG [{$label}]: " : "DEBUG: ";
            
            if (is_array($data) || is_object($data)) {
                $output .= print_r($data, true);
            } else {
                $output .= $data;
            }
            
            \Log::debug($output);
        }
    }
} 