<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreatePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/contact/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@firstname' => '#name',
            '@lastname' => '#surname',
            '@email' => '#email',
            '@submit' => '#submit',
        ];
    }
}
