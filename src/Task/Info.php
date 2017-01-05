<?php

namespace Crembl\Task;

use JMS\Serializer\Annotation\Type;

class Info {
    /**
     * @Type("string")
     * @var string
     */
    public $feedback;
    /**
     * @Type("Crembl\Task\Details")
     * @var Details
     */
    public $task;
    /**
     * @Type("string")
     * @var string
     */
    public $apiRequestStatus;
    /**
     * @Type("string")
     * @var string
     */
    public $apiRequestKey;
}