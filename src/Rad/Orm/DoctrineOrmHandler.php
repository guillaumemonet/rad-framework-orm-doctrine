<?php

/*
 * The MIT License
 *
 * Copyright 2017 Guillaume Monet.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Rad\Orm;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;

final class DoctrineOrmHandler implements OrmInterface {

    private $entityManager = null;

    public function __construct() {
        $radConfig = \Rad\Config\Config::getServiceConfig('orm', 'doctrine')->config;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), $radConfig->dev);
        $config = new Configuration();
        $connectionParams = array(
            'dbname' => $radConfig->database,
            'user' => $radConfig->user,
            'password' => $radConfig->password,
            'host' => $radConfig->host,
            'driver' => $radConfig->driver,
        );
        $conn = DriverManager::getConnection($connectionParams, $config);

        $this->entityManager = EntityManager::create($conn, $config);
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

}
