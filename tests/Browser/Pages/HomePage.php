<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        //
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@content' => '.container-fluid',
            '@navbar' => '.navbar-nav',
            '@maintable' => '#contacts',
            '@favoritesfilter' => '#favoritesBtn',
            '@newcontactbtn' => '#newBtn',
            '@maindatatable' => '#contacts_wrapper',
            '@firstname' => '#name',
            '@lastname' => '#surname',
            '@email' => '#email',
            '@submit' => '#submit',
            '@editlink' => '.dt-body-center > a[href$="/edit"]',
            '@favlink' => '.dt-body-center > a[href$="/favToggle"]',
            '@deletelink' => '.dt-body-center > a[href$="/destroy"]',
            '@numbersTable' => '#numbers',
        ];
    }
}
