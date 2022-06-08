<?php

declare(strict_types=1);

namespace Kafoso\DoctrineFirebirdDriver\Driver\FirebirdInterbase\Exception;

use Doctrine\DBAL\Driver\AbstractException;

use function ibase_errcode;
use function ibase_errmsg;

final class StatementError extends AbstractException
{
    public static function new(): self
    {
        $message  = ibase_errmsg();
        $code = ibase_errcode();

        return new self($message,'', $code);
    }
}
