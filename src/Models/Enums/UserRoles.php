<?php

namespace LegoCMS\Models\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class UserRoles
 *
 * @category Enums
 * @package  LegoCMS\Models\Enums
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Models/Enums/UserRoles.php
 */
class UserRoles extends Enum
{
    const ADMIN = 'ADMIN';
    const VISITOR = 'VISITOR';
}
