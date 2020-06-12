<?php

namespace LegoCMS\Core\View;

use LegoCMS\Core\Component;

class AppShell extends Component
{
    protected $component = "legocms-shell";

    protected function prepareVueAttributes(): array
    {
        return [
            'token' => \csrf_token(),
        ];
    }
}
