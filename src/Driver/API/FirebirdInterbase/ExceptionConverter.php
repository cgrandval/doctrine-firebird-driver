<?php

declare(strict_types=1);

namespace Kafoso\DoctrineFirebirdDriver\Driver\API\FirebirdInterbase;

use Doctrine\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\InvalidFieldNameException;
use Doctrine\DBAL\Exception\NonUniqueFieldNameException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use Doctrine\DBAL\Exception\TableExistsException;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Query;

/**
 * @internal
 */
final class ExceptionConverter implements ExceptionConverterInterface
{
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        switch ($exception->getCode()) {
            case -104:
                return new SyntaxErrorException($exception, $query);
            case -204:
                if (preg_match('/.*(dynamic sql error).*(table unknown).*/i', $exception->getMessage())) {
                    return new TableNotFoundException($exception, $query);
                }
                if (preg_match('/.*(dynamic sql error).*(ambiguous field name).*/i', $exception->getMessage())) {
                    return new NonUniqueFieldNameException($exception, $query);
                }
                break;
            case -206:
                if (preg_match('/.*(dynamic sql error).*(table unknown).*/i', $exception->getMessage())) {
                    return new InvalidFieldNameException($exception, $query);
                }
                break;
            case -803:
                return new UniqueConstraintViolationException($exception, $query);
            case -530:
                return new ForeignKeyConstraintViolationException($exception, $query);
            case -607:
                if (preg_match('/.*(unsuccessful metadata update Table).*(already exists).*/i', $exception->getMessage())) {
                    return new TableExistsException($exception, $query);
                }
                break;
            case -902:
                return new ConnectionException($exception, $query);
        }
        return new DriverException($exception, $query);
    }
}
