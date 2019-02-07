<?php

class pageBuilder
{
    public function buildPage($param)
    {
        $elements = array();

        $user = $param['user'];
        $header = $this->buildHeader($user);
        $elements[] = $header;

        $loggedIn = $param['loggedIn'];
        $navbar = $this->buildNavBar($loggedIn);
        $elements[] = $navbar;

        $sidebar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/sideBar.html');
        $elements[] = $sidebar;

        /* May deprecate this
        if($param['content'])
        {
            $content = $this->buildContent($param['content']);
            $elements[] = $content;
        }
        */
        $content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/content.html');
        $elements[] = $content;

        $footer  = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/footer.html');
        $elements[] = $footer;

        $page = "";
        foreach($elements as $element)
        {
            $page .= $element;
        }
        profGen_log($page);

        return($page);
    }
    private function buildHeader($user)
    {
        $header = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/header.html');
        $title = "Lukes Portfolio";
        if($user == 1)
        {
            $title = 'Portfolio Administrator';
        }
        // this will be used for our own templating engine, well pull this function out later
        $len = strlen('{{Title}}');
        $insertionPoint = strpos($header,'{{Title}}');
        $header = substr_replace($header,$title,$insertionPoint,$len);
        return $header;
    }

    private function buildNavBar($loggedIn)
    {
        $navbar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/navBar.html');
        if($loggedIn == true)
        {
            $accountOptions = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/elements/AccountOptions_LoggedIn.html');
            $len = strlen('Account-Options');
            $insertionPoint = strpos($navbar,'Account-Options') + $len + 2; // +2 to get past the "> in the html
            $navbar = substr_replace($navbar,$accountOptions,$insertionPoint,0);
            return $navbar;

        }else{
            $accountOptions = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/elements/AccountOptions_Default.html');
            $len = strlen('Account-Options');
            $insertionPoint = strpos($navbar,'Account-Options') + $len + 2;
            $navbar = substr_replace($navbar,$accountOptions,$insertionPoint,0);
            return $navbar;
        }
    }

    /* May deprecate this
    private function buildContent($file)
    {
        $base = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/content.html');
        $html = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/content/' . $file . '.html');
        $content = $this->htmlInsert($base,'content',$html);
        return $content;
    }
    */

    private function htmlInsert($file,$id,$html)
    {
        $len = strlen($id);
        $insertionPoint = strpos($file,$id) + $len + 2; // +2 to get past the "> in the html
        $newFile = substr_replace($file,$html,$insertionPoint,0);
        return $newFile;
    }

    // possibly deprecated, may become its own class
    /* 
    public function grabElement($param)
    {
        $req = $param['element'];
        $element  = file_get_contents($_SESSIOM['DOCUMENT_ROOT'].'pages/elements/'. $req);
        return $element;
    }
    */
}
?>