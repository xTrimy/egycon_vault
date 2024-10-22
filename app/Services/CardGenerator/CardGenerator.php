<?php

namespace App\Services\CardGenerator;

use App\Models\Belonging;
use PhpParser\Node\Expr\StaticCall;

class CardGenerator
{

    public static function generateCard(Belonging $belonging)
    {
        $templatePath = public_path('images/card_templates/belonging-card-halloween-24.jpg');
        $template = self::addCode(self::loadTemplate($templatePath), $belonging->code);
        $path = "images/cards/{$belonging->code}.jpg";
        imagejpeg($template, public_path($path));
        return $path;
    }

    private static function loadTemplate($path)
    {
        // Load template from path
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != 'jpg') {
            throw new \Exception('Invalid template file');
        }

        return imagecreatefromjpeg($path);
    }

    private static function addCode($template, $code)
    {
        $font = public_path('fonts/CenturyGothic.ttf');
        $color = imagecolorallocate($template, 0, 0, 0);
        // get image width and height
        $width = imagesx($template);
        $height = imagesy($template);
        // calculate the position where the text will be displayed (centered)
        // calculate font size (the bigger of width and height divided by 10)
        $fontSize = max($width, $height) / 15;
        // calculate text width and height
        $text_box = imagettfbbox($fontSize, 0, $font, $code);
        $text_width = $text_box[2] - $text_box[0];
        $text_height = $text_box[7] - $text_box[1];
        // calculate the position where the text will be displayed (centered)
        $x = ($width - $text_width) / 2;
        $y = ($height - $text_height) / 2;
        // add text to image
        imagettftext($template, $fontSize, 0, $x, $y, $color, $font, $code);
        return $template;
    }
}
