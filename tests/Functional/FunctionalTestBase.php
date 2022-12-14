<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\DoctrineUserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTestBase extends WebTestCase
{
    use RecreateDatabaseTrait;

    private static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $baseClient = null;
    protected static ?KernelBrowser $authenticatedClient = null;
    protected static ?KernelBrowser $anotherAuthenticatedClient = null;

    public function setUp(): void
    {
        parent::setUp();

        if (null === self::$client) {
            self::$client = static::createClient();
        }

        if (null === self::$baseClient) {
            self::$baseClient = clone self::$client;
            self::$baseClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ]);
        }

         if (null === self::$authenticatedClient) {
             self::$authenticatedClient = clone self::$client;

             $user = static::$container->get(DoctrineUserRepository::class)->findOneByEmailOrFail('luis@api.com');
             $token = static::$container->get(JWTTokenManagerInterface::class)->create($user);

             self::$authenticatedClient->setServerParameters([
                 'CONTENT_TYPE' => 'application/json',
                 'HTTP_ACCEPT' => 'application/json',
                 'HTTP_Authorization' => \sprintf('Bearer %s', $token),
             ]);
         }

        if (null === self::$anotherAuthenticatedClient) {
            self::$anotherAuthenticatedClient = clone self::$client;

            $user = static::$container->get(DoctrineUserRepository::class)->findOneByEmailOrFail('another@api.com');
            $token = static::$container->get(JWTTokenManagerInterface::class)->create($user);

            self::$anotherAuthenticatedClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
            ]);
        }
    }

    protected static function initDBConnection(): Connection
    {
        if (null === static::$kernel) {
            static ::bootKernel();
        }

        return static::$kernel->getContainer()->get('doctrine')->getConnection();
    }

    /**
     * @throws Exception
     */
    protected function getLuisId()
    {
        return self::initDBConnection()->executeQuery('SELECT id FROM user WHERE email = "luis@api.com"')->fetchOne();
    }

    /**
     * @throws Exception
     */
    protected function getAnotherId()
    {
        return self::initDBConnection()->executeQuery('SELECT id FROM user WHERE email = "another@api.com"')->fetchOne();
    }

    /**
     * @throws Exception
     */
    protected function getWorkstation1234Id()
    {
        return self::initDBConnection()->executeQuery('SELECT id FROM workstation WHERE number = "1234"')->fetchOne();
    }
}