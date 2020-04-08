<?php

class EmojiCalculator
{
    public $unicodeList;

    public $emojiList;

    public function __construct()
    {
        $this->unicodeList = $this->getUnicodeList();
        $this->emojiList = $this->getEmojiList();
    }

    public function calculate($text)
    {
        $result = "🤷";

        $text = $this->removeEmpty($text);
        $text = $this->convertAsciiToUnicode($text);
        $text = $this->convertUnicodeToAsciiWithEmoji($text);

        if ($this->lastCheckBeforeCalculate($text)) {
            $text = eval('return ' . $text . ';');
            return $this->convertAsciiToEmoji($text);
        }

        return $result;
    }

    public function removeEmpty($text)
    {
        $text = str_replace(" ", "", $text);

        return $text;
    }

    public function unicodeFormat($str)
    {
        $copy = false;
        $len = strlen($str);
        $res = '';

        for ($i = 0; $i < $len; ++$i) {
            $ch = $str[$i];

            if (!$copy) {
                if ($ch != '0') {
                    $copy = true;
                } else if (($i + 1) == $len) {
                    $res = '0';
                }
            }

            if ($copy) {
                $res .= $ch;
            }
        }

        return 'U+' . strtoupper($res);
    }

    public function convertAsciiToUnicode($text)
    {
        $text = mb_convert_encoding($text, 'UTF-32', 'UTF-8');
        $hex = bin2hex($text);

        $hex_len = strlen($hex) / 8;
        $chunks = array();

        for ($i = 0; $i < $hex_len; ++$i) {
            $tmp = substr($hex, $i * 8, 8);
            $chunks[$i] = $this->unicodeFormat($tmp);
        }

        return implode($chunks, '');
    }

    public function convertUnicodeToAsciiWithEmoji($text)
    {
        foreach ($this->unicodeList as $key => $value) {
            $text = str_replace($key, $value, $text);
        }

        return $text;
    }

    public function convertAsciiToEmoji($text)
    {
        if (is_numeric($text)) {
            foreach ($this->emojiList as $key => $value) {
                $text = str_replace($value, $key, $text);
            }

            return $text;
        } else {
            return "🤷";
        }
    }

    public function lastCheckBeforeCalculate($text)
    {
        $searchList = ['*', '+', '-', '/'];

        $text = str_replace($searchList, '', $text);

        if (is_numeric($text)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUnicodeList()
    {
        return [
            'U+30U+FE0FU+20E3' => 0,
            'U+30U+FE0F' => 0,
            'U+0030' => 0,
            'U+30' => 0,

            'U+31U+FE0FU+20E3' => 1,
            'U+31U+FE0F' => 1,
            'U+0031' => 1,
            'U+31' => 1,

            'U+32U+FE0FU+20E3' => 2,
            'U+32U+FE0F' => 2,
            'U+0032' => 2,
            'U+32' => 2,

            'U+33U+FE0FU+20E3' => 3,
            'U+33U+FE0F' => 3,
            'U+0033' => 3,
            'U+33' => 3,

            'U+34U+FE0FU+20E3' => 4,
            'U+34U+FE0F' => 4,
            'U+0034' => 4,
            'U+34' => 4,

            'U+35U+FE0FU+20E3' => 5,
            'U+35U+FE0F' => 5,
            'U+0035' => 5,
            'U+35' => 5,

            'U+36U+FE0FU+20E3' => 6,
            'U+36U+FE0F' => 6,
            'U+0036' => 6,
            'U+36' => 6,

            'U+37U+FE0FU+20E3' => 7,
            'U+37U+FE0F' => 7,
            'U+0037' => 7,
            'U+37' => 7,

            'U+38U+FE0FU+20E3' => 8,
            'U+38U+FE0F' => 8,
            'U+0038' => 8,
            'U+1F3B1' => 8,
            'U+38' => 8,

            'U+39U+FE0FU+20E3' => 9,
            'U+39U+FE0F' => 9,
            'U+0039' => 9,
            'U+39' => 9,

            "U+1F4AF" => 100,
            "U+1F51F" => 10,

            "U+2716U+FE0F" => '*', // ✖
            "U+2716" => '*', // ✖
            "U+78" => '*', // x
            "U+2A" => '*', // *
            "U+D7" => '*', // ×
            "U+74U+69U+6DU+65U+73" => '*', // times

            "U+2795U+FE0F" => '+', // ➕
            "U+2795" => '+', // ➕
            "U+70U+6CU+75U+73" => '+', // plus
            'U+20' => '+', // +
            'U+2B' => '+', // +

            "U+2796U+FE0F" => '-', // ➖
            "U+2796" => '-', // ➖
            "U+2D" => '-',
            "U+6DU+69U+6EU+75U+73" => '-', // minus

            "U+2797U+FE0F" => '/', // ➗
            "U+2797" => '/', // ➗
            "U+2F" => "/", // /
            "U+F7" => '/', // ÷
            "U+2014" => '/', // —
            "U+64U+69U+76U+69U+64U+65U+64U+62U+79" => '/', // dividedby
        ];
    }

    public function getEmojiList()
    {
        return [
            "💯" => "100",
            "🔟" => "10",
            "0️" => "0",
            "1️" => "1",
            "2️" => "2",
            "3️" => "3",
            "4️" => "4",
            "5️" => "5",
            "6️" => "6",
            "7️" => "7",
            "🎱" => "8",
            '9️' => "9",
        ];
    }
}
