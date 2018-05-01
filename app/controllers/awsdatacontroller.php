<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AwsdataController extends BaseController
{

    public function beforeAction()
    {

    }


    public function get()
    {

        $this->render = 0;


        echo '<pre>';


        $bucket = 'pfstransfer';

        // Instantiate the client.
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1'
        ]);

        // Use the high-level iterators (returns ALL of your objects).
        try {

            $objects = $s3->getIterator('ListObjects', array(
                'Bucket' => $bucket,
                'Prefix' => 'files/'
            ));

            foreach ($objects as $object) {
                echo $object['Key'] . "\n";
            }

        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }



//        try {
//
//
//            $sdk = new Aws\Sdk([
//                'region'  => 'us-west-2',
//                'version' => 'latest',
//            ]);
//            $s3 = $sdk->createS3();
//
//            $result = $s3->listBuckets();
//
//            var_dump($result);
//
//        } catch (S3Exception $e) {
//            echo 'S3 Exception: ' . "\n";
//            echo $e->getMessage();
//        } catch (AwsException $e) {
//            echo 'AWS Exception: ' . "\n";
//            echo $e->getAwsRequestId() . "\n";
//            echo $e->getAwsErrorType() . "\n";
//            echo $e->getAwsErrorCode() . "\n";
//        } catch (Exception $e) {
//            echo 'Generic Exception: ' . "\n";
//            echo $e->getMessage() . "\n";
//        }


    }


}