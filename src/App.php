<?php

namespace App;

use Symfony\Component\Console\Application;

class App extends Application
{

    public function __construct()
    {
        parent::__construct(
            'Directory counter',
            '0.1'
        );

    }


}