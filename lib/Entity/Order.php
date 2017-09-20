<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (Order.php)
 */


namespace Xibo\Platform\Entity;

use Xibo\Platform\Api\Error\InvalidArgumentException;
use Xibo\Platform\Api\Error\NotFoundException;

class Order extends Base
{
    use EntityTrait;

    public $orderId;
    public $subTotal;
    public $discount;
    public $vat;
    public $total;
    public $rfStatus;

    public $state;
    public $message;

    /**
     * Get an order by its order Id
     * @param int $orderId
     * @return $this
     * @throws NotFoundException
     */
    public function getById($orderId)
    {
        $this->getProvider()->getLogger()->debug('Order getById for ' . $orderId);

        $result = $this->getProvider()->get('/user/orders', ['orderId' => $orderId]);

        if (count($result) <= 0)
            throw new NotFoundException();

        $this->hydrate($result[0]);

        return $this;
    }

    /**
     * Complete the order
     * @param bool $autoPay
     * @param string $webHookUrl
     * @return $this
     * @throws InvalidArgumentException
     */
    public function complete($autoPay = true, $webHookUrl = null)
    {
        if ($this->orderId == null || !is_numeric($this->orderId))
            throw new InvalidArgumentException('Please provide a valid orderId');

        $autoPay = ($autoPay) ? 1 : 0;

        $result = $this->getProvider()->post('/shop/processquote/' . $this->orderId, [
            'autoPay' => $autoPay,
            'webHookUrl' => $webHookUrl
        ]);

        $this->state = $result['state'];
        $this->message = $result['message'];

        return $this;
    }
}