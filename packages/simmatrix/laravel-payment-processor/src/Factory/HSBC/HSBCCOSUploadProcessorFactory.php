<?php

namespace Simmatrix\PaymentProcessor\Factory\HSBC;

use Simmatrix\PaymentProcessor\Factory\HSBC\Header\HSBCFileHeader;
use Simmatrix\PaymentProcessor\Factory\HSBC\Header\HSBCBatchHeader;

use Simmatrix\PaymentProcessor\Factory\HSBC\HSBCBeneficiaryFactory;
use Simmatrix\PaymentProcessor\Adapter\Beneficiary\BeneficiaryAdapterInterface;
use Simmatrix\PaymentProcessor\COSUploadProcessor;

use Illuminate\Config\Repository;

class HSBCCOSUploadProcessorFactory
{
    /**
     * @param Collection of entries to be passed into the adapter
     * @param String The key to read the config from
     * @return COSUploadProcessor
     */
    public static function create($beneficiaries, $config_key)
    {
        $config = new Repository(config($config_key));
        $adapter_class = $config['beneficiary_adapter'];

        $beneficiaries = $beneficiaries -> map( function($payment) use($adapter_class){
            return new $adapter_class($payment);
        }) -> toArray();

        $beneficiary_lines = collect($beneficiaries) -> map( function(BeneficiaryAdapterInterface $beneficiary) use ($config_key){
            return HSBCBeneficiaryFactory::create($beneficiary, $config_key);
        }) -> toArray();

        $cos = new COSUploadProcessor($beneficiaries);

        $file_header = new HSBCFileHeader($beneficiaries, $config_key);
        $batch_header = new HSBCBatchHeader($beneficiaries, $config_key);

        $cos -> setFileHeader($file_header);
        $cos -> setBatchHeader($batch_header);
        $cos -> setBeneficiaryLines($beneficiary_lines);
        $cos -> setIdentifier($file_header -> getFileReference());
        $cos -> setFileName('hsbc_cos_'.time());
        $cos -> setFileExtension('csv');
        return $cos;
    }
}
