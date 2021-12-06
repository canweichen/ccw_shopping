<?php
namespace Modules\Admin\Enums;

class OrderEnum{
    const ORDER_CANCEL = -1;
    const ORDER_WAIT_PAY = 0;
    const ORDER_ALREADY_PAY = 1;
    const ORDER_REFUND = 2;
}
