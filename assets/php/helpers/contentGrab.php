<?php

class contentGrabber
{
    public function grabContent($content)
    {
        $content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/content/' . $content . '.html');
        return $content;
    }
}

?>