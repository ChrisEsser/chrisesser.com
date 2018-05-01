<?php

use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

class DataController extends BaseController
{

    public function beforeAction()
    {

    }


    public function get()
    {

        $this->render = 0;


        echo '<pre>';
        try {


//            $sdk = new Aws\Sdk([
//                'region'  => 'us-west-2',
//                'version' => 'latest',
//                'scheme' => 'http'
//            ]);
//            $s3 = $sdk->createS3();

//            $result = $s3->listBuckets();

//            var_dump($result);

        } catch (S3Exception $e) {
            echo 'S3 Exception: ' . "\n";
            echo $e->getMessage();
        } catch (AwsException $e) {
            echo 'AWS Exception: ' . "\n";
            echo $e->getAwsRequestId() . "\n";
            echo $e->getAwsErrorType() . "\n";
            echo $e->getAwsErrorCode() . "\n";
        } catch (Exception $e) {
            echo 'Generic Exception: ' . "\n";
            echo $e->getMessage() . "\n";
        }


    }


}