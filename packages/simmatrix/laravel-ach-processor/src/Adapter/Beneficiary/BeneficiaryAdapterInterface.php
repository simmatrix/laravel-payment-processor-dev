<?php
namespace Simmatrix\PaymentProcessor\Adapter\Beneficiary;

interface BeneficiaryAdapterInterface
{
    /**
     * Lines for the address. HSBC actually supports up to 5 lines.
     */
    public function getAddress1();
    public function getAddress2();
    public function getAddress3();

    //Used for HSBC
    public function getFullname();
    //Used for UOB
    public function getName1();
    public function getName2();
    public function getName3();

    public function getPaymentAmount();
    public function getPaymentDateTimeFormatted();
    public function getPaymentId();
    public function getPostcode();

    /**
     * @return String
     * For HSBC.
     * "M" - Mr
     * "R" - Mrs
     * "S" - Ms
     * "O" - Other
     */
    public function getRecipientTitleFlag();

    /**
     * @return String
     * A description for title flag, if the value was O.
     */
    public function getRecipientTitleDescription();
    public function getUserId();
}
