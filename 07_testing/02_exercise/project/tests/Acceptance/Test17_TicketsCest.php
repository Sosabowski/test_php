<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class Test17_TicketsCest
{
    // tests
    public function test(AcceptanceTester $I): void
    {
        $I->amOnPage("/");

        $I->amGoingTo("open the tickets page");
        $I->click("Tickets");

        $I->seeCurrentUrlEquals("/tickets");

        $I->seeInTitle("Tickets");

        $I->see("Tickets", "h1");
    }
}
