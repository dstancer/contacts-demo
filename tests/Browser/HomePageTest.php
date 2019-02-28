<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;

class HomePageTest extends DuskTestCase
{
    public function testLayout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->assertTitleContains('Contacts')
                ->assertVisible('@content')
                ->assertVisible('@navbar')
                ->assertVisible('@maintable')
                ->assertVisible('@favoritesfilter')
                ->assertVisible('@newcontactbtn')
                ->assertVisible('@maindatatable')
                ->assertVisible('@editlink')
            ;
        });
    }

    public function testNewButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage());
            $browser->clickLink('New Contact')
                ->assertVisible('@content')
                ->assertVisible('@firstname')
                ->assertVisible('@lastname')
                ->assertVisible('@email')
                ->assertVisible('@submit')
            ;
        });
    }

    public function testEditButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage());
            $browser->click('@editlink')
                ->assertVisible('@content')
                ->assertVisible('@firstname')
                ->assertVisible('@lastname')
                ->assertVisible('@email')
                ->assertVisible('@submit')
                ->assertVisible('@numbersTable')
            ;
        });
    }
}
