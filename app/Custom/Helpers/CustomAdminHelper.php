<?php

namespace App\Custom\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait CustomAdminHelper
{

    private $admin_url = '';

    function __construct()
    {
        $this->admin_url = $this->http_protocol . env('ADMIN_SUBDOMAIN') . str_replace($this->http_protocol, '', Config::get('app.url'));
    }

    public function is_admin()
    {
        return is_int(strpos(request()->root(), env('ADMIN_SUBDOMAIN')));
    }

    public function admin_url()
    {
        return $this->admin_url;
    }

    public function get_pagination()
    {
        return [10, 25, 50, 100];
    }


    public function get_admin_menus()
    {
        if (!Auth::check()) {
            return false;
        }
        // return menu by employee type - admin, superadmin, employee etc
        $menubars = [
            'active' => (isset($this->getPathActions()['as'])) ? $this->getPathActions()['as'] : '',
        ];
        $menubars = array_merge($menubars, $this->get_admin_menus_by_type());

        return $menubars;
    }

    public function validate_admin_page($page)
    {
        if (empty($page)) {
            return true;
        }
        $menuList = [];
        foreach ($this->get_admin_menus_by_type() as $menuId => $menubar) {
            $menuList = array_merge($menuList, $menubar);
        }

        return isset($menuList[$page]);
    }

    public function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = [])
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }

        return $url;
    }
}
