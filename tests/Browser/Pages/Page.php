<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Page as BasePage;
use PHPUnit\Framework\Assert as PHPUnit;

use Illuminate\Support\Facades\Auth;
use App\User;

abstract class Page extends BasePage
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
