<?php

namespace Crembl\Task;

use JMS\Serializer\Annotation\PostDeserialize;
use JMS\Serializer\Annotation\Type;

class Details {
    /**
     * @Type("string")
     * @var string
     */
    public $status;
    /**
     * @Type("integer")
     * @var int The creation timestamp measured in the number of milliseconds since the Unix Epoch (January 1 1970 00:00:00 GMT).
     */
    public $creationDate;
    /**
     * @Type("string")
     * @var string
     */
    public $envelopeType;
    /**
     * @Type("string")
     * @var string
     */
    public $taskDescription;
    /**
     * @Type("boolean")
     * @var bool
     */
    public $useCoverSheet;
    /**
     * @Type("boolean")
     * @var bool
     */
    public $printDuplex;
    /**
     * @Type("string")
     * @var string
     */
    public $externalDocumentReference;
    /**
     * @Type("string")
     * @var string
     */
    public $externalContactReference;
    /**
     * @Type("string")
     * @var string
     */
    public $taskSendType;
    /**
     * @Type("string")
     * @var string
     */
    public $sourceFile;
    /**
     * @Type("string")
     * @var string
     */
    public $addresseeLine1;
    /**
     * @Type("string")
     * @var string
     */
    public $addresseeLine2;
    /**
     * @Type("string")
     * @var string
     */
    public $addresseeLine3;
    /**
     * @Type("string")
     * @var string
     */
    public $addressCountry;
    /**
     * @Type("string")
     * @var string
     */
    public $addressZipCode;
    /**
     * @Type("string")
     * @var string
     */
    public $addressCity;
    /**
     * @Type("string")
     * @var string
     */
    public $addressStreetName;
    /**
     * @Type("string")
     * @var string
     */
    public $addressStreetNumber;
    /**
     * @Type("string")
     * @var string
     */
    public $addressBox;

    /**
     * @PostDeserialize()
     */
    private function postDeserialize() {
        if (!empty($this->creationDate)) {
            $this->creationDate = \DateTime::createFromFormat('U', $this->creationDate / 1000);
        }
    }
}