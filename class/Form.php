<?php
  namespace Fifi;
  
    class Form
    {
        public static $class = "";

        public static function checkbox(string $name, string $value, array $get): string 
        {
            $attributes = '';
            if (isset($get[$name]) && in_array($value, $get[$name])) {
              $attributes .= 'checked';
            }
            $attributes = 'class="' . self::$class . '"';
            return <<<HTML
            <input type='checkbox' name="{$name}[]" value="$value" $attributes>
HTML;
        }
        
        public static function radio(string $name, string $value, array $get): string 
        {
            $attributes = '';
            if (isset($get[$name]) && in_array($value, $get[$name])) {
              $attributes .= 'checked';
            }
            return <<<HTML
            <input type='radio' name="{$name}[]" value="$value" $attributes>
HTML;
        }
    }
?>