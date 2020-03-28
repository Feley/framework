<?php 

namespace Voom\Controller;

use Voom\Controller\Controller as BaseController;

/**
 * Site Controller
 */
class SiteController extends BaseController
{
    public function index()
    {
        return view('site.index');
    }

    public function test()
    {
        return view('site.index');
    }
}
?>