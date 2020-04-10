<?php

require_once 'lib/EmojiCalculator.php';

if ($argc != 2) {
    echo "Example: php ./index.php 🔟x🔟" . PHP_EOL;
    exit(1);
}

function println($text)
{
    print($text . PHP_EOL);
    exit();
}

$text = trim($argv[1]);

$emojiCalculator = new EmojiCalculator();

$text = $emojiCalculator->execute($text);

println($text);
