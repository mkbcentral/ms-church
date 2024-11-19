<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleType extends Enum
{
    const ADMIN = 'ADMIN';
    const CONSUMER = 'CONSUMER';
    const CREATOR = 'CREATOR';
}
