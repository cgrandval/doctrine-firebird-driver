<?php

declare(strict_types=1);

namespace Kafoso\DoctrineFirebirdDriver\Driver\FirebirdInterbase;

use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Driver\FetchUtils;
use Kafoso\DoctrineFirebirdDriver\Driver\FirebirdInterbase\Exception\StatementError;
use Doctrine\DBAL\Driver\Result as ResultInterface;

use function ibase_fetch_assoc;
use function ibase_fetch_object;
use function ibase_free_result;
use function ibase_num_fields;
use function ibase_affected_rows;
use function ibase_errmsg;

final class Result implements ResultInterface
{
    /** @var resource */
    private $statement;

    /** @var resource */
    private $ibaseResultResource;

    /** @var int */
    private $affectedRows;

    /** @var int */
    private $numFields;

    /**
     * The result can be only instantiated by its driver connection or statement.
     *
     * @param resource $statement
     */
    public function __construct($statement, $ibaseResultResource, $affectedRows, $numFields)
    {
        $this->statement = $statement;
        $this->ibaseResultResource = $ibaseResultResource;
        $this->affectedRows = $affectedRows;
        $this->numFields = $numFields;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchNumeric()
    {
        // TODO: Implement fetchNumeric() method.
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAssociative()
    {
        // TODO: Implement fetchAssociative() method.
    }

    /**
     * {@inheritDoc}
     */
    public function fetchOne()
    {
        // TODO: Implement fetchOne() method.
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAllNumeric(): array
    {
        // TODO: Implement fetchAllNumeric() method.
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAllAssociative(): array
    {
        // TODO: Implement fetchAllAssociative() method.
    }

    /**
     * {@inheritDoc}
     */
    public function fetchFirstColumn(): array
    {
        // TODO: Implement fetchFirstColumn() method.
    }

    /**
     * {@inheritDoc}
     */
    public function rowCount(): int
    {
        return $this->affectedRows;
    }

    /**
     * {@inheritDoc}
     */
    public function columnCount(): int
    {
        return $this->numFields;
    }

    /**
     * {@inheritDoc}
     */
    public function free(): void
    {
        ibase_free_result($this->ibaseResultResource);
    }
}
