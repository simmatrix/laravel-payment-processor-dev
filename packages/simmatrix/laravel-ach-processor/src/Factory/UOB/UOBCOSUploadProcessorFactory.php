<?php

namespace Simmatrix\PaymentProcessor\Factory\UOB;

use Simmatrix\PaymentProcessor\Factory\UOB\Header\UOBFileHeader;
use Simmatrix\PaymentProcessor\Factory\UOB\Header\UOBBatchHeader;
use Simmatrix\PaymentProcessor\Factory\UOB\Header\UOBBatchTrailer;
use Simmatrix\PaymentProcessor\Factory\UOB\UOBBeneficiaryFactory;

use Simmatrix\PaymentProcessor\Adapter\Beneficiary\BeneficiaryAdapterInterface;
use Simmatrix\PaymentProcessor\COSUploadProcessor;

use Illuminate\Config\Repository;

class UOBCOSUploadProcessorFactory
{
    /**
     * @param Collection of entries to be passed into the adapter
     * @param String The config key to read from
     * @param Int The sequence number for file name generation. If multiple files are generated in a day, this number should be incremented.
     * @return ACHUploadProcessor
     */
    public static function create($beneficiaries, $config_key, $sequence_number = 1)
    {
        $config = new Repository(config($config_key));
        $adapter_class = $config['beneficiary_adapter'];

        $beneficiaries = $beneficiaries -> map( function($payment) use($adapter_class){
            return new $adapter_class($payment);
        }) -> toArray();

        $beneficiary_lines = collect($beneficiaries) -> map( function(BeneficiaryAdapterInterface $beneficiary) use($config_key){
            return UOBBeneficiaryFactory::create($beneficiary, $config_key);
        }) -> toArray();

        $cos = new ACHUploadProcessor($beneficiaries, $config_key);

        $file_name = static::getFileName($sequence_number);
        $cos -> setFileName($file_name);
        $cos -> setFileExtension('txt');
        $file_header = new UOBFileHeader($beneficiaries, $config_key);
        $file_header -> setFileName($file_name);
        //UOB uses fixed length strings, so no column delimiters are needed
        $file_header -> setColumnDelimiter("");

        $batch_header = new UOBBatchHeader($beneficiaries, $config_key);
        $batch_header -> setColumnDelimiter("");

        $batch_trailer = new UOBBatchTrailer($beneficiaries, $config_key);
        $batch_trailer -> setColumnDelimiter("");

        $cos -> setFileHeader($file_header);
        $cos -> setBatchHeader($batch_header);
        $cos -> setBatchTrailer($batch_trailer);
        $cos -> setBeneficiaryLines($beneficiary_lines);
        $cos -> setIdentifier($file_header -> getCheckSum());
        return $cos;
    }

    /**
    * @return String
    */
    public static function getFileName($sequence_number){
        return sprintf("UCPI%s%s", date('dm'), str_pad($sequence_number, 2, STR_PAD_LEFT, '0') );
    }
}
