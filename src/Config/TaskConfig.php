<?php

namespace Crembl\Config;

/**
 * @method TaskConfig setAddresseeLine1(string $value) [REQUIRED] A line to indicate the addressee.
 * @method TaskConfig setAddresseeLine2(string $value) [OPTIONAL] An optional line to indicate the addressee.
 * @method TaskConfig setAddresseeLine3(string $value) [OPTIONAL] An optional line to indicate the addressee.
 * @method TaskConfig setAddressCountry(string $value) [OPTIONAL] The country to which this document is to be sent (two-char ISO 3166 code).
 * @method TaskConfig setAddressZipCode(string $value) [REQUIRED] The zipcode to which this document is to be sent.
 * @method TaskConfig setAddressCity(string $value) [REQUIRED] The city to which this document is to be sent.
 * @method TaskConfig setAddressStreetName(string $value) [REQUIRED] The streetname to which this document is to be sent.
 * @method TaskConfig setAddressStreetNumber(string $value) [REQUIRED] The streetnumber to which this document is to be sent.
 * @method TaskConfig setAddressBox(string $value) [OPTIONAL] The box to which this document is to be sent.
 * @method TaskConfig setAddressPoBox(string $value) [OPTIONAL] The PO box to which this document is to be sent. If this value is filled, the fields addressStreetName, addressStreetNumber and addressBox will be ignored and emptied.
 * @method TaskConfig setExternalContactReference(string $value) [OPTIONAL] An external identifier for the contact to which this document is being sent. This value is required to be unique.
 * @method TaskConfig setUseCoverSheet(bool $value) [OPTIONAL] Whether or not to use a cover sheet. When omitted, the default domain value is used.
 * @method TaskConfig setPrintDuplex(bool $value) [OPTIONAL] Whether or not to print the page two-sided. When omitted, the default domain value is used.
 * @method TaskConfig setTaskDescription(string $value) [OPTIONAL] A description of this document.
 * @method TaskConfig setExternalDocumentReference(string $value) [OPTIONAL] A unique external reference ID to this document. When set, this value is required to be unique.
 */
class TaskConfig extends AbstractConfig {
    protected $addresseeLine1 = '';
    protected $addresseeLine2 = '';
    protected $addresseeLine3 = '';
    protected $addressCountry = '';
    protected $addressZipCode = '';
    protected $addressCity = '';
    protected $addressStreetName = '';
    protected $addressStreetNumber = '';
    protected $addressBox = '';
    protected $addressPoBox = '';
    protected $externalContactReference = '';
    protected $useCoverSheet = false;
    protected $printDuplex = false;
    protected $taskDescription = '';
    protected $externalDocumentReference = '';

    public function __construct() {
        $this->setDocumentTypeRegular();
    }

    /**
     * Sets the type of document to send (regular mail or registered mail).
     *
     * @return TaskConfig
     */
    public function setDocumentTypeRegistered(): TaskConfig {
        $this->json['taskApiSendType'] = 'REGISTERED';
        return $this;
    }

    /**
     * Sets the type of document to send (regular mail or registered mail).
     *
     * @return TaskConfig
     */
    public function setDocumentTypeRegular(): TaskConfig {
        $this->json['taskApiSendType'] = 'MAIL';
        return $this;
    }

    /**
     * Disable setting the envelope type, the default domain value will be used by Crembl.
     *
     * @return TaskConfig
     */
    public function setEnvelopeTypeDefault(): TaskConfig {
        if (array_key_exists('envelopeType', $this->json)) unset($this->json['envelopeType']);
        return $this;
    }

    /**
     * Sets the envelope type to use: an envelope with two windows.
     * The second window at the top left of your envelope can then be used to display your company logo, to personalise your letter.
     *
     * @return TaskConfig
     */
    public function setEnvelopeTypeDoubleWindow(): TaskConfig {
        $this->json['envelopeType'] = 'DOUBLE_WINDOW';
        return $this;
    }

    /**
     * Sets the envelope type to use: an envelope with one window for the address.
     *
     * @return TaskConfig
     */
    public function setEnvelopeTypeSingleWindow(): TaskConfig {
        $this->json['envelopeType'] = 'SINGLE_WINDOW';
        return $this;
    }

    /**
     * Disable setting the duplex printing option, the default domain value will be used by Crembl.
     *
     * @return TaskConfig
     */
    public function setPrintDuplexPageDefault(): TaskConfig {
        if (array_key_exists('printDuplex', $this->json)) unset($this->json['printDuplex']);
        return $this;
    }

    /**
     * Disable setting the cover sheet option, the default domain value will be used by Crembl.
     *
     * @return TaskConfig
     */
    public function setUseCoverSheetDefault(): TaskConfig {
        if (array_key_exists('useCoverSheet', $this->json)) unset($this->json['useCoverSheet']);
        return $this;
    }
}