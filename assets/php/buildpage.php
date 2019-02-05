<?php

class pageBuilder
{
    public function buildPage($param)
    {
        $header = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/header.html');

        $loggedIn = $param['loggedIn'];
        $navbar = $this->buildNavBar($loggedIn);

        $sidebar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/sideBar.html');
        $footer  = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/footer.html');

        $page = $header . $navbar . $sidebar . $footer;

        return($page);
    }

    private function buildNavBar($loggedIn)
    {
        $navbar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/navBar.html');
        if($loggedIn == true)
        {
            $accountOptions = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/elements/AccountOptions_LoggedIn.html');
            $len = strlen('Account-Options');
            $insertionPoint = strpos($navbar,'Account-Options') + $len + 2;
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