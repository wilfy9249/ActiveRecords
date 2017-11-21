<?php
class printHtmlTags
{

    static public function horizontalRule()
    {
        return '<hr>';
    }

    static public function headingOne($text)
    {
        return '<h1>' . $text . '</h1>';
    }
}

?>