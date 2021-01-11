<?

//namespace armsoft;

class Armsoft
{

    public $soapUrl = '';
    private $username = '';
    private $password = '';
    private $dbName = '';

    function __construct($soapUrl, $username, $password, $dbName)
    {
        $this->soapUrl = $soapUrl; // must contain wsdl in the end
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    // GetAllProducts function
    public function getProducts($soapClient) //soapClient is given from level above in run php
    {
        $resultss = array();

        $result = $soapClient->__soapCall(
            "StartSession",
            array(
                "parameters" => array(
                    "UserName" => $this->username, "Password" => $this->password, "DBName" => $this->dbName
                )
            )
        );

        $resMat = $soapClient->__soapCall( //soapClient is given from level above in run php
            "GetProductsList",
            array(
                "parameters" => array(
                    "sessionId" => $result->StartSessionResult,
                    "seqNumber" => 1,
                    "Group" => '',
                    "LikeName" => 'գրիչ',
                    "PriceType" => 02,
                    "Type" => "All",
                    "ShowOnlyInPriceList" => false
                )
            )
        );

//        return $resMat;

        $totalImages = $resMat->GetProductsListResult->Total;
//        $allImages =  $resMat->GetProductsListResult->ProductListRow;

        for ($i = 2; $i <= intval(100 / 50); $i++) {
            echo $totalImages;
            echo $i . '<br>';

            $resImagesAll = $soapClient->__soapCall( //soapClient is given from level above in run php
                "GetProductPricesNextChunk",
                array(
                    "parameters" => array(
                        "sessionId" => $result->StartSessionResult,
                        "seqNumber" => $i
                    )
                )
            );



//            $d = (array)$resImagesAll->GetProductPricesNextChunkResult->Rows->PriceListRow;
//
//            echo 'Adding to json products_' . $i . '.json <br>';
//
//            file_put_contents(__DIR__ . '/../import/products_' . $i . '.json', json_encode($d, JSON_UNESCAPED_UNICODE));



        }


//        echo '<pre>';
//        $totalProducts = $resMat['GetProductsInfoList']['Total'];
//        $allProductsArray[1] = $resMat['GetProductsInfoList']['Rows']['MaterialInfo'];
//
//        for ($i = 2; $i <= intval($totalProducts / 50 + 1); $i++) {
//
//            $resMatAll = $soapClient->__soapCall( //soapClient is given from level above in run php
//                "GetProductsNextChunk",
//                array(
//                    "parameters" => array(
//                        "sessionId" => $result->StartSessionResult,
//                        "seqNumber" => $i
//                    )
//                )
//            );
//
//            $resMatAll = json_decode(json_encode($resMatAll), true);
//            $totalProductFromCHunk = $resMatAll['GetProductsNextChunkResult']['Rows']['MaterialInfo'];
//            $allProductsArray[$i] = $totalProductFromCHunk;
//
//            $allProductsArray[] = $i;
//        }
//        $allProductsArray['totalProducts'] = $totalProducts;

    }

    // GetPrices function
    public function getPrice($soapClient) //soapClient is given from level above in run php
    {

        $result = $soapClient->__soapCall(
            "StartSession",
            array(
                "parameters" => array(
                    "UserName" => $this->username, "Password" => $this->password, "DBName" => $this->dbName
                )
            )
        );

        $resPrice = $soapClient->__soapCall( //soapClient is given from level above in run php
            "GetProductPrices",
            array(
                "parameters" => array(
                    "sessionId" => $result->StartSessionResult,
                    "seqNumber" => 1,
                    "AsOfDate" => "2020-12-21T17:37:00",
                    "PriceType" => '02',
                    "ProductShowMode" => '',
                    "ShowAvailables" => false,
                    "Type" => "",
                    "ProductGroup" => '',
                    "ProductCode" => ''
                )
            )
        );
        return $resPrice;
    }

    //GetProductPricesWithImages function
    public function getImages($soapClient) //soapClient is given from level above in run php
    {



        $resultss = array();

        $result = $soapClient->__soapCall(
            "StartSession",
            array(
                "parameters" => array(
                    "UserName" => $this->username, "Password" => $this->password, "DBName" => $this->dbName
                )
            )
        );

        $resImages = $soapClient->__soapCall( //soapClient is given from level above in run php
            "GetProductPricesWithImages",
            array(
                "parameters" => array(
                    "sessionId" => $result->StartSessionResult,
                    "seqNumber" => 1,
                    "AsOfDate" => "2020-12-21T17:37:00",
                    "PriceType" => '02',
                    "ProductShowMode" => '',
                    "ShowAvailables" => false,
                    "Type" => "",
                    "ProductGroup" => '',
                    "ProductCode" => ''
                )
            )
        );
        $totalImages = $resImages->GetProductPricesWithImagesResult->Total;
//        $allImages = $resImages->GetProductPricesWithImagesResult->Rows->PriceListRow;
//        echo 'total Partners === '.$totalImages;

        for ($i = 2; $i <= intval($totalImages / 50); $i++) {
            //echo $totalProducts;
//            $resMatAll = false;
            echo $i . '<br>';

            $resImagesAll = $soapClient->__soapCall( //soapClient is given from level above in run php
                "GetProductPricesNextChunk",
                array(
                    "parameters" => array(
                        "sessionId" => $result->StartSessionResult,
                        "seqNumber" => $i
                    )
                )
            );

//           echo ("<pre>");
//           print_r($resImagesAll->GetProductPricesNextChunkResult->Rows->PriceListRow);
//           echo ("</pre>");

            $d = (array)$resImagesAll->GetProductPricesNextChunkResult->Rows->PriceListRow;

            echo 'Adding to json products_' . $i . '.json <br>';

            file_put_contents(__DIR__ . '/../import/products_' . $i . '.json', json_encode($d, JSON_UNESCAPED_UNICODE));

//            foreach ( $resImagesAll->GetProductPricesNextChunkResult->Rows->PriceListRow as $items){
//
//                $items = (array) $resImagesAll->GetProductPricesNextChunkResult->Rows->PriceListRow;
//                $resultss[] = $items;
////                echo ("<pre>");
////                print_r($items);
////                echo ("</pre>");
//           }


        }

//        echo ("<pre>");
//        print_r($resultss);
//        echo ("</pre>");


    }











//    public function getPartners($soapClient) //soapClient is given from level above in run php
//    {
//
//        $result = $soapClient->__soapCall(
//            "StartSession",
//            array(
//                "parameters" => array(
//                    "UserName" => $this->username, "Password" => $this->password, "DBName" => $this->dbName
//                )
//            )
//        );
//
//        $resMat = $soapClient->__soapCall( //soapClient is given from level above in run php
//            "GetPartnersList",
//            array(
//                "parameters" => array(
//                    "sessionId" => $result->StartSessionResult,
//                    "seqNumber" => 1
//                    //"UserName"=>"ADMIN", "Password"=>"", "DBName"=>"Sample_70"
//                )
//            )
//        );
//        $resMat = json_decode(json_encode($resMat), true);
//        echo '<pre>';
//        $totalPartners = $resMat['GetPartnersListResult']['Total'];
//        $allPartnersArray[1] = $resMat['GetPartnersListResult']['Rows']['PartnerInfo'];
//        echo 'total Partners === '.$totalPartners;
//        for ($i = 2; $i <= intval($totalPartners / 50 + 1); $i++) {
//            //echo $totalProducts;
//            $resMatAll = false;
//            // echo $i;
//            // echo '<br>';
//            $resMatAll = $soapClient->__soapCall( //soapClient is given from level above in run php
//                "GetPartnersNextChunk",
//                array(
//                    "parameters" => array(
//                        "sessionId" => $result->StartSessionResult,
//                        "seqNumber" => $i
//                    )
//                )
//            );
//            $resMatAll = json_decode(json_encode($resMatAll), true);
//            $totalPartnerFromCHunk = $resMatAll['GetPartnersNextChunkResult']['Rows']['PartnerInfo'];
//            $allPartnersArray[$i] = $totalPartnerFromCHunk;
//
//            $allPartnersArray[] = $i;
//        }
//       $allPartnersArray['totalPartners'] = $totalPartners;
//        return $allPartnersArray;
//    }
//
//
//
//    public function getGetAvailability($soapClient){
//
//        $result = $soapClient->__soapCall(
//            "StartSession",
//            array(
//                "parameters" => array(
//                    "UserName" => $this->username, "Password" => $this->password, "DBName" => $this->dbName
//                )
//            )
//        );
//
//        $resMat = $soapClient->__soapCall( //soapClient is given from level above in run php
//            "GetMTAvailability",
//            array(
//                "parameters" => array(
//                    "sessionId" => $result->StartSessionResult,
//                    "seqNumber" => 1
//                )
//            )
//        );
//        $resMat = json_decode(json_encode($resMat), true);
//    }


    function ImportProduct($products, $prices)
    {
//        echo ("<pre>");
//        print_r($prices);
//        echo ("</pre>");

//        foreach ($products as $product){
//
//            $el = new CIBlockElement;
//
////    $PROP = array();
////    $PROP[3] = 38; // свойству с кодом 3 присваиваем значение 38
//
//            $arLoadProductArray = Array(
//                "IBLOCK_ID"      => 15,
//                "IBLOCK_SECTION_ID"=>46,
//                "NAME"           => $product->Name,
//                "XML_ID"=>$product->Id,
////        "PROPERTY_VALUES"=> $PROP,
//                "ACTIVE"         => "Y",            // активен
//                "DETAIL_TEXT"    => "текст для детального просмотра"
//            );
//
//            if($PRODUCT_ID = $el->Add($arLoadProductArray))
//                echo "New ID: ".$PRODUCT_ID;
//            else
//                echo "Error: ".$el->LAST_ERROR;
//
//        }


    }


}
