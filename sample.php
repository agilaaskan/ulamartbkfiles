<?php
$url = 'http://ulamartmagento.pmhere.xyz/';
$token_url=$url."rest/V1/integration/admin/token";
$product_url=$url. "rest/V1/products";
$ch = curl_init();
$data = array("username" => ulamart, "password" => ulamart123);
$data_string = json_encode($data);
$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
    );
$token = curl_exec($ch);
$adminToken=  json_decode($token);
// /public_html/pub/media/catalog/product/a/l
$url1 = 'http://ulamartmagento.pmhere.xyz/pub/media/catalog/product/a/l/claypot1.jpg';
$image_mime1 = image_type_to_mime_type(exif_imagetype($url1)); 
$content1 = file_get_contents($url1);

$url2 = 'http://ulamartmagento.pmhere.xyz/pub/media/catalog/product/a/l/claypot2.jpg';
$image_mime2 = image_type_to_mime_type(exif_imagetype($url2)); 
$content2 = file_get_contents($url2);

$url3 = 'http://ulamartmagento.pmhere.xyz/pub/media/catalog/product/a/l/claypot3.jpg';
$image_mime3 = image_type_to_mime_type(exif_imagetype($url3)); 
$content3 = file_get_contents($url3);


$sampleProductData = array(
    'sku'               => '3-inch-clay-pot',
    'name'              => '3 INCH CLAY POT WITH LID - PACK OF 4| STORAGE POT',
    'visibility'        => 4,
    'type_id'           => 'simple',
    'price'             => 100,
    'status'            => 1,
    'attribute_set_id'  => 4,
    'weight'            => 2,
    'extension_attributes' => array(
            "stock_item"=>array(
                    'qty' => 10,'is_in_stock' => 1,'manage_stock' => 1,'use_config_manage_stock' => 1,'min_qty' => 0,'use_config_min_qty' => 1,'min_sale_qty' => 1,'use_config_min_sale_qty' => 1,'use_config_max_sale_qty' => 1,'is_qty_decimal' => 0,'backorders' => 0,'use_config_backorders' => 1,'notify_stock_qty' => 1,'use_config_notify_stock_qty' => 1
            ),
    ),
    'media_gallery_entries' => array(

            array(
                'id'=> 0,
                'media_type'=> 'image',
                'label'=> 'TESTIMAGE',
                'position'=> 0,
                'disabled'=> 0,
                'types' => array('image','small_image','thumbnail'),
                'file' => '/pub/media/catalog/product/a/l/claypot1.jpg',
                'content' => array(
                        'base64_encoded_data' => base64_encode($content1),
                        "type"=> $image_mime1,
                        'name'=> 'claypot1.jpg'
                    )
                ),
            array(
                'id'=> 0,
                'media_type'=> 'image',
                'label'=> 'TESTIMAGE',
                'position'=> 0,
                'disabled'=> 0,
                'types' => array('image','small_image','thumbnail'),
                'file' => '/pub/media/catalog/product/a/l/claypot2.jpg',
                'content' => array(
                        'base64_encoded_data' => base64_encode($content2),
                        "type"=> $image_mime2,
                        'name'=> 'claypot2.jpg'
                    )
                ),
            array(
                'id'=> 0,
                'media_type'=> 'image',
                'label'=> 'TESTIMAGE',
                'position'=> 0,
                'disabled'=> 0,
                'types' => array('image','small_image','thumbnail'),
                'file' => '/pub/media/catalog/product/a/l/claypot3.jpg',
                'content' => array(
                        'base64_encoded_data' => base64_encode($content3),
                        "type"=> $image_mime3,
                        'name'=> 'claypot3.jpg'
                    )
                )
    ),
    'custom_attributes' => array(
        array( 'attribute_code' => 'category_ids', 'value' => ["14"] ),
        array( 'attribute_code' => 'description', 'value' => "Premium 3 inch Clay Pot With Lid.  Our products are made of pure natural clay and are unglazed.  No chemical, No artificial colors.  Bio-degradable, Eco-friendly, Non-toxic" ),
        array( 'attribute_code' => 'short_description', 'value' => "Cleaning instructions:
 For the first use, soak the product in water for 24hrs.
 For regular usage, clean with hot water & brush. No chemical washing products are required.
 Use rock salt and scrub pad & soak in hot water for half an hour, to clean stubborn stains.
 Make use of baking soda to remove absorbed odors of garlic, onion etc." ),
        array( 'attribute_code' => 'meta_title', 'value' => "$meta_title"),
        array( 'attribute_code' => 'meta_keyword', 'value' => "$meta_keyword"),
        array( 'attribute_code' => 'meta_description', 'value' => "$meta_description"),
    ),
);

$productData = json_encode(array('product' => $sampleProductData));

$setHaders = array('Content-Type:application/json','Authorization:Bearer '.$adminToken);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $product_url);
curl_setopt($ch,CURLOPT_POSTFIELDS, $productData);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, $setHaders);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);


if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

