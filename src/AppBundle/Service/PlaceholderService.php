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
    const DEFAULT_FONT_COLOR = '000000';
    const FONT_SIZE = 20;

    private $text;
    private $height;
    private $width;
    private $bgColor;
    private $fontColor;
    private $fontSize;

    public function generatePlaceholderImage(
        $text = null,
        $height = null,
        $width = null,
        $color = null,
        $fontColor = null,
        $fontSize = null,
        $filePath = null
    )
    {

        list($this->text, $this->height, $this->width, $this->bgColor, $this->fontColor, $this->fontSize) = $this->populateParameters($text, $height, $width, $color, $fontColor, $fontSize);

        $image = $this->getImage($width, $height, $color);
        $image = $this->putTextOnImage($image, $text);

        if ($filePath) {
            return $this->saveImageToFile($image, $filePath);
        }

        return $image;

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
                $fullHex .= $char;
                $fullHex .= $char;
            }
            $hexColor = $fullHex;
            return $hexColor;
        }

        throw new \Exception('Incorrect color value');
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
            $this->fontSize,
            0,
            $font,
            $text,
            $this->width - ($offset * 2)
        );

        $textBox = imagettfbbox(
            $this->fontSize,
            0,
            $font,
            $text
        );

        $offsetY = ($this->height - $textBox[1]) / 2;
        $offsetX = ($this->width - $textBox[2]) / 2;

        $fontColor = imagecolorallocate(
            $image,
            $this->fontColor[0],
            $this->fontColor[1],
            $this->fontColor[2]
        );
//        $shadowOffset = 20;
//        $fontShadow = imagecolorallocate(
//            $image,
//            $this->fontColor[0] - $shadowOffset,
//            $this->fontColor[1] - $shadowOffset,
//            $this->fontColor[2] - $shadowOffset
//        );

        imagettftext($image, $this->fontSize, 0, $offsetX, $offsetY, $fontColor, $font, $text);
//        imagettftext($image, $this->fontSize, 0, $offsetX, $offsetY, $fontShadow, $font, $text);

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

    private function populateParameters($text, $height, $width, $color, $fontColor, $fontSize)
    {
        $params = array();
        $params[] = $text;

        if (!$height) $height = self::DEFAULT_HEIGHT;
        $params[] = $height;

        if (!$width) $width = self::DEFAULT_WIDTH;
        $params[] = $width;

        if (!$color) $color = self::DEFAULT_COLOR;
        $params[] = $this->convertHexToRgb($color);

        if (!$fontColor) $fontColor = self::DEFAULT_FONT_COLOR;
        $params[] = $this->convertHexToRgb($fontColor);

        if (!(int)$fontSize) {
            $fontSize = self::FONT_SIZE;
        }
        $params[] = $fontSize;

        return $params;
    }

    private function saveImageToFile($image, $filePath)
    {
        if (!imagepng($image, $filePath)) {
            $filePath = null;
        }
        return $filePath;
    }

}