<?php
/**
 * Created by PhpStorm.
 * User: sergei
 * Date: 22.02.15
 * Time: 13:10
 */

namespace AppBundle\Service;


class PlaceholderService {

    const DEFAULT_HEIGHT = 300;
    const DEFAULT_WIDTH = 300;
    const DEFAULT_COLOR = 'CCCCCC';
    const FONT_SIZE = 20;

    private $text;
    private $height;
    private $width;
    private $bgColor;

    public function generatePlaceholderImage(
        $text = null,
        $height = null,
        $width = null,
        $color = null
    )
    {

        list($this->text, $this->height, $this->width, $this->bgColor) = $this->populateParameters($text, $height, $width, $color);

        $image = $this->getImage($width, $height, $color);
        $image = $this->putTextOnImage($image, $text);

        $filepath = $this->saveImageToFile($image, 'test.png');

        var_dump($filepath);

        die();

    }

    private function convertHexToRgb($hexColor)
    {

        $hexColor = $this->convertToFullHex($hexColor);

        $rgbColor = array();
        foreach (str_split($hexColor, 2) as $hexValue) {
            $rgbColor[] = hexdec($hexValue);
        }
        return $rgbColor;

    }

    private function convertToFullHex($hexColor)
    {
        if (strlen($hexColor) == 6) {
            return $hexColor;
        }

        if (strlen($hexColor) == 3) {
            $fullHex = '';
            foreach (str_split($hexColor) as $char) {
                var_dump($char);
                $fullHex .= $char;
                $fullHex .= $char;
            }
            $hexColor = $fullHex;
        }

        return self::DEFAULT_COLOR;
    }

    private function getImage()
    {
        $image = imagecreatetruecolor($this->width, $this->height);

        $bgColor = imagecolorallocate($image, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);

        imagefilledrectangle(
            $image,
            0,
            0,
            $this->width - 1,
            $this->height - 1,
            $bgColor
        );

        return $image;
    }

    private function putTextOnImage($image, $text)
    {

        if (!$text) return $image;

        $offset = 20;

        $font = $this->getFont('arial.ttf');
        $text = $this->wrapText(
            self::FONT_SIZE,
            0,
            $font,
            $text,
            $this->width - ($offset * 2)
        );

        $textBox = imagettfbbox(
            self::FONT_SIZE,
            0,
            $font,
            $text
        );

        $offsetY = ($this->height - $textBox[1]) / 2;
        $offsetX = ($this->width - $textBox[2]) / 2;

        $fontColor = imagecolorallocate($image, 0, 0, 0);

        imagettftext($image, self::FONT_SIZE, 0, $offsetX + 1, $offsetY + 1, $fontColor, $font, $text);
//        imagettftext($im, $fontSize, 0, $offsetX, $offsetY, $black, $font, $text);

        return $image;
    }

    private function getFont($fontName)
    {
        $font = realpath('') . '/bundles/app/fonts/' . $fontName;
        if (is_file($font)) return $font;
        return null;
    }

    private function wrapText($fontSize, $angle, $fontFace, $string, $width)
    {

        $ret = "";

        $arr = explode(' ', $string);

        foreach ($arr as $word) {

            $teststring = $ret . ' ' . $word;
            $testbox = imagettfbbox($fontSize, $angle, $fontFace, $teststring);
            if ($testbox[2] > $width) {
                $ret .= ($ret == "" ? "" : "\n") . $word;
            } else {
                $ret .= ($ret == "" ? "" : ' ') . $word;
            }
        }

        return $ret;

    }

    private function populateParameters($text, $height, $width, $color)
    {
        $params = array();
        $params[] = $text;

        if (!$height) $height = self::DEFAULT_HEIGHT;
        $params[] = $height;

        if (!$width) $width = self::DEFAULT_WIDTH;
        $params[] = $width;

        $params[] = $this->convertHexToRgb($color);

        return $params;
    }

    private function saveImageToFile($image, $fileName)
    {
        $filePath = realpath('') . '/tmp/' . $fileName;
        if (!imagepng($image, $filePath)) {
            $filePath = null;
        }
        imagedestroy($image);
        return $filePath;
    }

}