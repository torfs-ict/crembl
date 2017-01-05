<?php

namespace Crembl\Exception;

use JMS\Serializer\Annotation\Type;

class Info {
    /**
     * @Type("string")
     * @var string
     */
    public $type;
    /**
     * @Type("string")
     * @var string
     */
    public $reason;
}