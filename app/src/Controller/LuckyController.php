<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    public function number()
    {
        $number = \random_int(0, 100);

        return new response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
