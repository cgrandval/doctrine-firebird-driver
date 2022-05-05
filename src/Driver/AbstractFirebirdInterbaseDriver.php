<?php
namespace Kafoso\DoctrineFirebirdDriver\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Kafoso\DoctrineFirebirdDriver\Driver\API\FirebirdInterbase\ExceptionConverter;
use Kafoso\DoctrineFirebirdDriver\Platforms\FirebirdInterbasePlatform;
use Kafoso\DoctrineFirebirdDriver\Schema\FirebirdInterbaseSchemaManager;

/**
 * Abstract base implementation of the {@see Driver} interface for Firebird/Interbase based drivers.
 */

abstract class AbstractFirebirdInterbaseDriver implements Driver
{
    const ATTR_DOCTRINE_DEFAULT_TRANS_ISOLATION_LEVEL = 'doctrineTransactionIsolationLevel';

    const ATTR_DOCTRINE_DEFAULT_TRANS_WAIT = 'doctrineTransactionWait';

    private $_driverOptions = [];

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new FirebirdInterbasePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn, AbstractPlatform $platform)
    {
        assert($platform instanceof FirebirdInterbasePlatform);

        return new FirebirdInterbaseSchemaManager($conn, $platform);
    }

    public function getExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }

    /**
     * @param array $options
     * @return self
     */
    public function setDriverOptions($options): AbstractFirebirdInterbaseDriver
    {
        if (is_array($options)) {
            foreach ($options as $k => $v) {
                $this->setDriverOption($k, $v);
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setDriverOption($key, $value): AbstractFirebirdInterbaseDriver
    {
        if (trim($key) && in_array($key, self::getDriverOptionKeys())) {
            $this->_driverOptions[$key] = $value;
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();
        return $params['dbname'];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getDriverOption($key)
    {
        if (trim($key) && in_array($key, self::getDriverOptionKeys())) {
            return $this->_driverOptions[$key];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getDriverOptions(): array
    {
        return $this->_driverOptions;
    }

    /**
     * @return array
     */
    public static function getDriverOptionKeys(): array
    {
        return [
            self::ATTR_DOCTRINE_DEFAULT_TRANS_ISOLATION_LEVEL,
            self::ATTR_DOCTRINE_DEFAULT_TRANS_WAIT,
            \PDO::ATTR_AUTOCOMMIT,
        ];
    }
}
