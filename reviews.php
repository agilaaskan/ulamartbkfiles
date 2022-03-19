<?php
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

ini_set('display_errors', 1);
echo "HELLO STACK EXCHANGE";

  $i=0;
  $file = fopen("reviews1.csv","r");
   while($row = fgetcsv($file)) {
       if($i > 0) {
        $productId=$row[0];
        if (trim($row[4]) == 'Null') {
            $customerId=Null;//for Guest user $customerId=Null;
        }
        else {
            $customerId=$row[4]; 
        }
        $customerNickName=$row[3];
        if (trim($row[1]) == 'NULL') {
            $reviewTitle=' ';//for Guest user $customerId=Null;
        }
        else {
        $reviewTitle=$row[1];
        }
        if (trim($row[2]) == 'NULL') {
            $reviewDetail=' ';//for Guest user $customerId=Null;
        }
        else {
        $reviewDetail=$row[2];
        }
        $StoreId=1;
        $title=$row[1];
        // echo $row[0]."<br>";
        // echo $row[1]."<br>";
        // echo $row[2]."<br>";
        // echo $row[3]."<br>";
        // echo $customerId."<br>";
        
        // if ($i == 5) {
        //     break;
        // }



        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $_review = $objectManager->get("Magento\Review\Model\Review")
        // ->setEntityPkValue($productId)    //product Id
        // ->setStatusId(\Magento\Review\Model\Review::STATUS_APPROVED)// pending/approved
        // ->setTitle($reviewTitle)
        // ->setDetail($reviewDetail)
        // ->setEntityId(1)
        // ->setStoreId($StoreId)
        // ->setStores(1)
        // ->setCustomerId($customerId)//get dynamically here 
        // ->setNickname($customerNickName)
        // ->save()
        // ->aggregate();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_review = $objectManager->get("Magento\Review\Model\ReviewFactory");
        //$productId = $value->getId();
            $reviewFinalData['ratings'][1] = 5;
            $reviewFinalData['ratings'][2] = 5;
            $reviewFinalData['ratings'][3] = 5;
            $reviewFinalData['nickname'] = $customerNickName; //add user nickname
            $reviewFinalData['title'] = $reviewTitle; //add title of the review
            $reviewFinalData['detail'] = $reviewDetail; //add details of the review
            $review = $_review->create()->setData($reviewFinalData);
            $review->unsetData('review_id');
            $review->setEntityId($review->getEntityIdByCode(\Magento\Review\Model\Review::ENTITY_PRODUCT_CODE))
                ->setEntityPkValue($productId)
                ->setStatusId(\Magento\Review\Model\Review::STATUS_APPROVED) //By default set approved
                ->setStoreId($StoreId)
                ->setStores(1)
                ->save();
        $_rating = $objectManager->get("Magento\Review\Model\RatingFactory");
            foreach ($reviewFinalData['ratings'] as $ratingId => $optionId) {
                $_rating->create()
                    ->setRatingId($ratingId)
                    ->setReviewId($review->getId())
                    ->addOptionVote($optionId, $productId);
            }
            $review->aggregate();
            echo $i."<br>";
       
    }
    $i++;
}

?>