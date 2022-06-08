<?php
declare(strict_types=1);

namespace Kafoso\DoctrineFirebirdDriver\Driver\FirebirdInterbase;

use Doctrine\DBAL\Driver\AbstractException;

class Exception extends AbstractException
{
    /**
     * @param array $error
     *
     * @return Exception
     */
    public static function fromErrorInfo($error)
    {
        return new self(strval($error['message']), null, intval($error['code']));
    }
}
