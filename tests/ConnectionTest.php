<?php


namespace XiboTests;

/**
 * Class ConnectionTest
 * @package XiboTests
 */
class ConnectionTest extends TestCase
{
    /**
     * Tests the basic connection to the Platform.
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function testHome()
    {
        /** @var \Xibo\Platform\Entity\Account $me */
        $me = $this->getProvider()->me();

        $this->getProvider()->getLogger()->debug(json_encode($me));

        $this->assertNotEmpty($me->getId(), 'ID is empty');
    }

    public function testProductList()
    {
        $products = $this->getProvider()->get('/products');

        $this->assertNotEmpty($products);
    }
}