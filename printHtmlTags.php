<?php

class printHtmlTags
{

    static public function horizontalRule()
    {
        echo '<hr>';
    }

    static public function headingOne($text)
    {
        echo '<h1>' . $text . '</h1>';
    }
}

?>