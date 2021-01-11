<?
define("STOP_STATISTICS", true); ?>
<? define("NO_AGENT_CHECK", true); ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$soapUrl = "http://37.186.126.226:8087/TradeService/TradeService.svc?wsdl";
$user = "Userd";
$pass = "123";
$dbname = "NoyanTapanLLC";

if (!CModule::IncludeModule("iblock")) return;

$armsoft = new Armsoft($soapUrl, $user, $pass, $dbname);

$aHTTP['http']['header'] = "User-Agent: PHP-SOAP/5.5.11\r\n";
$context = stream_context_create($aHTTP);

try {
    $client = new SoapClient($armsoft->soapUrl, array('trace' => 1, "stream_context" => $context));
} catch (Exception $e) {
    echo '<h3>Sorry connection has been lost </h3>';
}


$products = $armsoft->getProducts($client);

dump($products);

//$productsPrice = $armsoft->getPrice($client);

//$productsImages = $armsoft->getImages($client);



//
//$fileDir = __DIR__ . '/import/' ;
//$files = scandir($fileDir);
//unset($files[0],$files[1]);
//print_r($files);
//
////$files = array('products_9.json', 'products_50.json', 'products_160.json');
//
//if (!empty($files)) {
//
//    foreach ($files as $file) {
//
//        $filePath = __DIR__ . '/import/' . $file;
//
//        if (file_exists($filePath)) {
//
//            echo 'Importing ' . $filePath . '<br>';
//
//            $fileData = file_get_contents($filePath);
//            $arProducts = json_decode($fileData, true);
//
//
//            if (!empty($arProducts)) {
//
//                foreach ($arProducts as $arProduct) {
//                    if (!empty($arProduct['Image'])) {
//                        $filePath = __DIR__ . '/images/' . $arProduct['Id'] . '.jpg';
//                        file_put_contents($filePath, base64_decode($arProduct['Image']));
//
//                        echo "Making Image .$filePath. <br>";
//
//                    }
//                }
//
//            }
//
////            echo("<pre>");
////            print_r($arProducts);
////            echo("</pre>");
//
//        }
//
//    }
//
//    file_put_contents(__DIR__ . '/import.log', 'Import finished' . date('d.m.Y'));
//}



















//    echo ("<pre>");
//    print_r($productsImages);
//    echo ("</pre>");


//foreach ($productsImages->GetProductPricesWithImagesResult->Rows->PriceListRow as $images) {

//    echo ("<pre>");
//    print_r($images);
//    echo ("</pre>");


//    if(!empty($images->PriceListRow->Image)){
//        file_put_contents(__DIR__.'/images/'.$images->PriceListRow->Id.'.jpg', base64_decode($images->PriceListRow->Image));
//    }


//  $arPrice[$price->Code] = $price;
//}


////print_r($products->GetProductsListResult->Rows->ProductListRow);
// echo ("<pre>");
//print_r($arPrice);
//
//echo ("</pre>");


//$armsoft->ImportProduct($products->GetProductsListResult->Rows->ProductListRow, $arPrice);








