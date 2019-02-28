<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CreatePage;

class CreatePageTest extends DuskTestCase
{
    public function testCreatePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new CreatePage())
                ->assertSee('First Name')
                ->assertSee('Last Name')
                ->assertSee('e-mail')
                ->assertSee('Image')
                ->assertSee('Favorite')
                ->assertSee('Phone Label')
                ->assertSee('Phone Number')
                ->assertVisible('@firstname')
                ->assertVisible('@lastname')
                ->assertVisible('@email')
                ->assertVisible('@submit');
        });
    }
}
