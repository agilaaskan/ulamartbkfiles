<? php
$url = ulamartmagento.pmhere.xyz/;
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

$sampleProductData = array(
    'sku'               => 'sppc',
    'name'              => 'sample product php curl',
    'visibility'        => 4,
    'type_id'           => 'simple',
    'price'             => 150,
    'status'            => 1,
    'attribute_set_id'  => 4,
    'weight'            => 1,
    'extension_attributes' => array(
            "stock_item"=>array(
                    'qty' => $inventory_stock,'is_in_stock' => 1,'manage_stock' => 1,'use_config_manage_stock' => 1,'min_qty' => 0,'use_config_min_qty' => 1,'min_sale_qty' => 1,'use_config_min_sale_qty' => 1,'max_sale_qty ' => 10,'use_config_max_sale_qty' => 1,'is_qty_decimal' => 0,'backorders' => 0,'use_config_backorders' => 1,'notify_stock_qty' => 1,'use_config_notify_stock_qty' => 1
            ),
        ),
    // ),
    // 'custom_attributes' => array(
    //     array( 'attribute_code' => 'category_ids', 'value' => ["43"] ),
    //     array( 'attribute_code' => 'description', 'value' => $description ),
    //     array( 'attribute_code' => 'short_description', 'value' => $short_description ),
    //     array( 'attribute_code' => 'meta_title', 'value' => $meta_title),
    //     array( 'attribute_code' => 'meta_keyword', 'value' => $meta_keyword),
    //     array( 'attribute_code' => 'meta_description', 'value' => $meta_description),
    // ),
);

$productData = json_encode(array('product' => $sampleProductData));

$setHaders = array('Content-Type:application/json','Authorization:Bearer  '.$adminToken);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $product_url);
curl_setopt($ch,CURLOPT_POSTFIELDS, $productData);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, $setHaders);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);