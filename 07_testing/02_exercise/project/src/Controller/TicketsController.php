<?php

namespace Controller;

use Controller\Controller;

class TicketsController extends Controller
{
    public function index(): Result
    {
        return view('tickets.index')->withTitle('Tickets');
    }
}
