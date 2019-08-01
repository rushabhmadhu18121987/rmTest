<?php
namespace backend\components;

use Yii;
use Aws\S3;
use Aws\S3\S3Client;
use Aws\CommandPool;
use yii\base\Component;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Generallib
 *
 * @author Indra Shastri
 */



class S3BucketHelper  extends Component {

    private $s3Client="",$minutesforlink='+20 minutes',$bucket='';
    
    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: This function is used to intialize s3buket key and scret
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    
    public function __construct($bucket="",$minutesforlink="",$configuration=array())
    {
        $configuration = array_replace(
            [
                'region' => AWS_REGION,
                'version' => AWS_VERSION,
                'credentials' => [
                    'key'    => AWS_ACCESS_KEY,
                    'secret' => AWS_SECRET_KEY,
                ],
    
            ]
        ,$configuration);
        $this->s3Client = new S3Client($configuration);
        $this->bucket = $bucket;
        if($minutesforlink!=""){
            $this->minutesforlink=$minutesforlink;
        }
    }
    
    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: this function is used for creating presigened url
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    
    public function getPresignedBucketObjectURI($url)
    {
        $cmd = $this->s3Client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $url
        ]);
        return (string) $this->s3Client->createPresignedRequest($cmd, $this->minutesforlink)->getUri();
    }

    
   /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: this function is all key and from the bucket
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    
    public function getAllKeys(){
        // Use the high-level iterators (returns ALL of your objects).
        try {
            $results = $this->s3Client->getPaginator('ListObjects', [
                'Bucket' => $this->bucket
            ]);
            $objectcontains = [];
            if(isset($results) && $results!=""){
                foreach ($results as $result) {
                    if(isset($result['Contents']) && $result['Contents']!=""){
                        foreach ($result['Contents'] as $object) {
                            $objectcontains[] =  $object['Key'];
                        }
                    }
                }
            }
           
            return $objectcontains;
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            exit;
        }
    }

     /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: this function is all key releted to one folder, also returning presigned url and object of that key
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */

    public function getAllKeysFromFolder($folder){
        $allkeys = [];

        $objects = $this->s3Client->getIterator('ListObjects', array(
            "Bucket" => $this->bucket,
            "Prefix" => $folder //must have the trailing forward slash "/"
        ));
      
        foreach ($objects as $object) {
            $allkeys[] = [
                "key"=>$object['Key'],
                "url"=>$this->getPresignedBucketObjectURI($object['Key']),
                "object"=>$this->getObject($object['Key'])
            ];
        }

        return $allkeys;
    }

    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose:Gets the object form s3 buket
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    public function getObject($key)
    {
        return $this->s3Client->getObject([
                    'Bucket' => $this->bucket,
                    'Key'    => $key,
                ]);
    }

    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: this function takes foldeer name as string and creats folder on s3buket
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    
    public function createFolder($foldername){
        if(!$this->s3Client->doesObjectExist($this->bucket,$foldername)){
            $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => "$foldername",
            ]);
        }
    }

    
    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: this function takes folder name as string and delets its from s3buket
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    
     public function deleteFolder($foldername){
        if($this->IsExists($foldername)){
            $this->s3Client->deleteMatchingObjects($this->bucket, $foldername);
        }
    }

    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: check if the object exists or not 
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */

    public function IsExists($foldername){
        return $this->s3Client->doesObjectExist($this->bucket,$foldername);
    }
       /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: this function takes delete key array and deletes them from s3bucket
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    public function DeleteKeys($keys=[]){
       
            try {
                $this->s3Client->deleteObjects([
                    'Bucket'  => $this->bucket,
                    'Delete' => [ 'Objects' => array_map(function ($key) { return ['Key' => $key];}, $keys)],
                ]); 
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                exit;
            }
    }


    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: Uploads file on S3bucket and takes relaved data array for it 
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    public function uploadFileS3bucket($data = array()){
        $this->s3Client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $data['dir'] . "/" . $data['name'], // aws path to upload
            'Body' => file_get_contents($data['tmp_name'], false), //remote URL
            'ContentType' => $data['type'] ?? NULL,
        ]);
    }

    /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: Uploads more than one file on s3 buket at one time
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    public function uploadMultipleFileS3bucket($data){
        foreach ($data as $key => $file) {
            $commands[]           = $this->s3Client->getCommand('PutObject', array(
                'Bucket'          => $this->bucket,
                'Key'             => $file["pathname"],
                'SourceFile'      => $file["tmp_name"],
                'ContentType'      => $file["type"] ?? NULL,
                'ServerSideEncryption' => 'AES256',
            ));
        }
        $pool = new CommandPool($this->s3Client, $commands);
        // Initiate the pool transfers
        $promise = $pool->promise();
        // Force the pool to complete synchronously
        $promise->wait();
        return 1;
    }

     /* * *********************************************************************
    * Created By : Indra Shastri
    * Development Group: Space o technology
    * Created On : 18-July-2019 (Thu)
    * Modified By:
    * Purpose: Delets one key from s3 buket
    * Last Modified on:
    * Modified Code:
    * Controler URL:
    * ******************************************************************** */
    public function deleteObject($keyname){
        // Delete an object from the bucket.
        $this->s3Client->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $keyname
        ]);
        return 1;
    }
}