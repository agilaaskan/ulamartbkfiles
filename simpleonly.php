<?php
$row=0;
$file =  fopen('check.csv', "r");	
$counter = 0;	 

while (($column = fgetcsv($file, 10000, ",")) !== FALSE) { 
  if ($row > 0) {
    $counter++;
    
$url = 'http://localhost/m2ulamart/';
$token_url=$url."rest/V1/integration/admin/token";
$product_url=$url. "rest/V1/products";
$ch = curl_init();
$data = array("username" => ulamart, "password" => Ulamart123);
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
// $category_ids=array();
// $sampleProductData=array();
	   

    $type = $column[0];
    $category_ids= $column[1];
    $sku = $column[2];
    $name = $column[3];
    // $visibility=$column[4];
    $price = $column[4];
    // $attribute_code	= $column[7];
    // $attr_value	= $column[8];
    // $description = $column[9];	
    // $short_description = $column[10];	
    $qty = $column[5];	
    // $img_url=$column[12];
    // $filepath=$column[13];	
    // $img_name=$column[14];
    // echo $img_url;

// $media=array(); 
// $image_mime=array();
// $content=array();
// $base=array();
// $i=0;
$cat = explode(',', $category_ids);

// $urls = explode(',', $img_url);
// $fpath = explode(',', $filepath);
// $inames = explode(',', $img_name);

// $result = $url . ' ' . $fpath[0];
// $len=sizeof($urls);

// for($i=0;$i<$len;$i++)
// {
// $image_mime[$i] = image_type_to_mime_type(exif_imagetype($urls[$i])); 
// $content[$i] = file_get_contents($urls[$i]);
// $base[$i]=base64_encode($content[$i]);
// $media[$i]=array(
//     'id'=> 0,
//     'media_type'=> 'image',
//     'label'=> 'IMAGE',
//     'position'=> 0,
//     'disabled'=> 0,
//     'types' => array('image','small_image','thumbnail'),
//     'file' => $fpath[$i],
//     'content' => array(
//             'base64_encoded_data' =>$base[$i],
//             "type"=> $image_mime[$i],
//             'name'=> $inames[$i] 
//             )
//     );
// }

// print_r($media);
    // exit();

    // $productDesc = escapeJsonString(trim($description));
    // $productfDesc = escapeJsonString(strip_tags($productDesc));
    // $productSDesc = escapeJsonString(trim($short_description));
    // $productshtfDesc = escapeJsonString(strip_tags($productSDesc));
    // $prodMetaTitle = escapeJsonString($meta_title);
    // $prodMetaDesc = escapeJsonString($meta_description);
    // echo $productfDesc;
// exit();
$sampleProductData = array(
    'sku'               => $sku,
    'name'              => $name,
    'visibility'        => 4,
    'type_id'           => 'simple',
    'price'             => $price,
    'status'            => 1,
    'attribute_set_id'  => 4,
    'weight'            => 0,
    'extension_attributes' => array(
            "stock_item"=>array(
                    'qty' => $qty, 'is_in_stock' => 1,'manage_stock' => 1,'use_config_manage_stock' => 1,'min_qty' => 0,'use_config_min_qty' => 1,'min_sale_qty' => 1,'use_config_min_sale_qty' => 1,'use_config_max_sale_qty' => 1,'is_qty_decimal' => 0,'backorders' => 0,'use_config_backorders' => 1,'notify_stock_qty' => 1,'use_config_notify_stock_qty' => 1

            ),
          ),
          
    // 'media_gallery_entries' => $media,
    
    'custom_attributes' => array(
        array( 'attribute_code' => 'category_ids', 'value' => $cat ),
        // array( 'attribute_code' => 'description', 'value' => $productDesc ),
        // array( 'attribute_code' => 'short_description', 'value' => $productSDesc),
        // array( 'attribute_code' => 'meta_title', 'value' => $prodMetaTitle ),
        // array( 'attribute_code' => 'meta_description', 'value' => $prodMetaDesc ),
        // array( 'attribute_code' => $attribute_code,'value'=>$attr_value),
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

}   
$row++;
}







