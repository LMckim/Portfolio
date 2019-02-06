<?php

class pageBuilder
{
    public function buildPage($param)
    {
        $user = $param['user'];
        $header = $this->buildHeader($user);

        $loggedIn = $param['loggedIn'];
        $navbar = $this->buildNavBar($loggedIn);

        $sidebar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/sideBar.html');
        $footer  = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/footer.html');

        $page = $header . $navbar . $sidebar . $footer;

        return($page);
    }
    private function buildHeader($user)
    {
        $header = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/header.html');
        $title = "Lukes Portfolio";
        if($user == 1)
        {
            $title = 'Administrator';
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
}
?>