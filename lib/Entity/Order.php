<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (Order.php)
 */


namespace Xibo\Platform\Entity;

use Api\Error\InvalidArgumentException;

class Order extends Base
{
    use EntityTrait;

    public $orderId;
    public $subTotal;
    public $discount;
    public $vat;
    public $total;

    public $state;
    public $message;

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