<?php

namespace Crembl\Exception;

/**
 * Custom exception class including the error returned by the Crembl API.
 */
class Exception extends \Exception {
    private $info;

    public function __construct(Info $info) {
        $this->info = $info;
        parent::__construct($info->reason);
    }

    /**
     * Returns the error returned by the Crembl API.
     *
     * @return Info
     */
    public function getErrorInfo() {
        return $this->info;
    }
}