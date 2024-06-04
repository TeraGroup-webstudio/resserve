<?php
class ControllerExtensionImportImportXml extends Controller {

    public $langRuId = 1;//
    public $langUkId = 3;//
    public $langEnId = 2;// disable
    public $attribute_group_id = 7;// disable
    public $fileBlock = 50000;
    public $stock_in_stock = 7; //В наявності
    public $stock_not_available = 5; //Немає в наявності
    public $stock_to_order = 8; // Під замовлення

    public function index() {
        //$start = microtime(true);
        //set_time_limit(0);
       /* setting */
        $type_upload = $this->config->get('import_import_xml_type');
       /* setting */
        $this->save(); // Збереження даних в файл на сервер
        $this->photoCsv(); // Підготовка файла для імпорту фото
        $this->attrCsv();
        //echo 'Тип завантаження - '.$type_upload.'<br>';
        if($type_upload == 0){ //Працюємо з файлом
            //echo 'Дані взято з файлу<br/>';
            //$filename = $_SERVER['DOCUMENT_ROOT'].'upload/file/xml/import.xml';
            //$xml = simplexml_load_file($filename);


        } else if($type_upload == 1){ //Працюємо з посиланням
            //$url = $this->config->get('import_import_xml_url');
            //$url =  $this->url_explode_alias();
            //echo 'Дані взято з посилання! <br/>';
            //if($url != ''){
               // $xml = file_get_contents($url);
            //} else {
            //    echo 'Поле для посилання не заповнене';

           // }
        }
        echo "✅ Данные подготовлены успешно!";
       // echo 'Затрачений час на виконання скрипта : ' . (microtime(true) - $start) . ' сек.</br>';
    }

    public function category(){
        $type_upload = $this->config->get('import_import_xml_type');
        $status_category = $this->config->get('import_import_xml_status_category'); // Статус категорій, імпортувати чи ні
        //echo 'Тип завантаження - '.$type_upload.'<br>';
        if($type_upload == 0){ //Працюємо з файлом
            //echo 'Дані взято з файлу<br/>';
            $filename = $_SERVER['DOCUMENT_ROOT'].'upload/file/xml/import.xml';
            $xml = simplexml_load_file($filename);
        } else if($type_upload == 1){ //Працюємо з посиланням
            //$url = $this->config->get('import_import_xml_url');
            $url =  $this->url_explode_alias();
            //echo 'Дані взято з посилання! <br/>';
            if($url != ''){
                $xml = file_get_contents($url);
            } else {
                echo 'Поле для посилання не заповнене';

            }
        }
        // Працюємо с категоріями
        foreach ($xml->shop->categories->category as $category) {
            $category_id = (string)$category['id'];

            $name = (string)$category;
            $query_category = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category` WHERE category_id = '" . (int)$category_id . "'");
            if($query_category->num_rows >0){ // Якщо категорія існує, то оновлюємо дані
                echo 'Оновлюємо категорію - '.$category_id.'<br>';// що оновлювати?
                $parentId = isset($category['parentId']) ? (string)$category['parentId'] : 0;
                $this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");
                $level = 0;

                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parentId . "' ORDER BY `level` ASC");

                foreach ($query->rows as $result) {
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

                    $level++;
                }

                $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

                /**/
                //$this->db->query("UPDATE " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', name = '" . $this->db->escape($name) . "' WHERE  language_id = '" . (int)$this->langRuId . "' AND category_id='".(int)$category_id."'");
                //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$this->langUkId . "', name = '" . $this->db->escape($name) . "'");

                /**/

                /*$url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE query LIKE 'category_id=" . $category_id . "'");

                if($url_alias->num_rows == 0){
                    $key_seo =  $this->translit($name);
                    $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE keyword = '" . $key_seo . "'");
                    if ($url_alias->num_rows > 0) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($key_seo.'_'.$category_id) . "', seomanager=0");
                    } else {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($key_seo) . "', seomanager=0");
                    }
                }*/
                //ЧПУ
               /* $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query LIKE 'category_id=" . $category_id . "'");
                if($url_alias->num_rows == 0){
                    $key_seo =  $this->translit($name);
                    $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $key_seo . "'");
                    if ($url_alias->num_rows > 0) {
                        //$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($key_seo.'_'.$product_id) . "', language_id = '" .  (int)$this->langRuId  . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($this->translit($name).'_'.$category_id) . "', language_id = '1'");
                    } else {
                        //$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($key_seo) . "', language_id = '" .  (int)$this->langRuId  . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($this->translit($name)) . "', language_id = '1'");
                    }
                }*/

            } else { // Якщо категорії не існує, то додаємо нову
                echo 'Додаємо категорію - '.$category_id.'<br>';
                $parentId = isset($category['parentId']) ? (string)$category['parentId'] : 0;
                $this->db->query("INSERT INTO " . DB_PREFIX . "category SET category_id = '".(int)$category_id."',parent_id = '" . (int)$parentId . "', `top` = 0, `column` = 1, sort_order = 0, status = 1, date_modified = NOW(), date_added = NOW()");
                //echo "INSERT INTO " . DB_PREFIX . "category SET category_id = '".(int)$category_id."',parent_id = '" . (int)$parentId . "', `top` = 0, `column` = 1, sort_order = 0, status = 1, noindex = 1, date_modified = NOW(), date_added = NOW()";
                //echo '<br/>';

                //$category_id = $this->db->getLastId();
                $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$this->langRuId . "', name = '" . $this->db->escape($name) . "', description = '', meta_title = '" . $this->db->escape($name) . "', meta_description = '', meta_keyword = ''");
                $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$this->langUkId . "', name = '" . $this->db->escape($name) . "', description = '', meta_title = '" . $this->db->escape($name) . "', meta_description = '', meta_keyword = ''");

                $level = 0;

                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parentId . "' ORDER BY `level` ASC");

                foreach ($query->rows as $result) {
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

                    $level++;
                }

                $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

                $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = 0");
                $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = 0, layout_id = 0");

                //ЧПУ
                $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query LIKE 'category_id=" . $category_id . "'");
                if($url_alias->num_rows == 0){
                    $key_seo =  $this->translit($name);
                    $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $key_seo . "'");
                    if ($url_alias->num_rows > 0) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($key_seo.'_'.$category_id) . "', language_id = '" .  (int)$this->langRuId  . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($this->translit($name).'_'.$category_id) . "', language_id = '" .  (int)$this->langUkId  . "'");
                    } else {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($key_seo) . "', language_id = '" .  (int)$this->langRuId  . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($this->translit($name)) . "', language_id = '" .  (int)$this->langUkId  . "'");
                    }
                }

            }

        }
        echo "✅ Данные по Категориям успешно обновлены!";
    }

    public function product(){
        $type_upload = $this->config->get('import_import_xml_type');
        $status_product = $this->config->get('import_import_xml_status_product'); // Статус товарів, імпортувати чи ні
        $status_disable_product = $this->config->get('import_import_xml_status_disable_product'); // Статус товарів, Вкл/Викл

        if($type_upload == 0){ //Працюємо з файлом
            //echo 'Дані взято з файлу<br/>';
            $filename = $_SERVER['DOCUMENT_ROOT'].'upload/file/xml/import.xml';
            $xml = simplexml_load_file($filename);
        } else if($type_upload == 1){ //Працюємо з посиланням
            //$url = $this->config->get('import_import_xml_url');
            $url =  $this->url_explode_alias();
            //echo 'Дані взято з посилання! <br/>';
            if($url != ''){
                $xml = file_get_contents($url);
            } else {
                echo 'Поле для посилання не заповнене';

            }
        }

        if($xml){
            if($status_product == 1){
//
                if($status_disable_product == 1){
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET status = 0");
                } else {
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET status = 1");
                }


                foreach ($xml->shop->offers->offer as $product) {
                    $product_id = $product['id'];
                    //echo 'product_id - '.$product_id.'<br/>';
                    $category_id = $product->categoryId;
                    $article = $product->vendorCode;
                    $price = $product->price;
                    $oldprice = $product->oldprice;
                    $quantity =  0;
                    $shipping = ($product->delivery == 'true' ? '1' : '0');
                   // echo 'shipping - '.$shipping.'<br>';
                    $manufacturer_id = $this->manufacturer($product->vendor);
                    $name_ru = $product->name;
                    $name_ua = $product->name_ua;
                    $description_ru = str_replace(']]','',str_replace('<![CDATA[','',$product->description));
                    $description_ua = str_replace(']]','',str_replace('<![CDATA[','',$product->description_ua));
                    $stock_status_id = 0;

                    if((string)$product->pickup == 'true' && (string)$product->delivery == 'true'){
                        $stock_status_id = $this->stock_in_stock;
                        $quantity =  100;
                    } else if((string)$product->pickup == 'false' && (string)$product->delivery == 'true'){
                        $stock_status_id = $this->stock_to_order;
                    } else if((string)$product->pickup == 'false' && (string)$product->delivery == 'false'){
                        $stock_status_id = $this->stock_not_available;
                    }


                    $еmpty_product = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
                    if($еmpty_product->num_rows == 0){ // Якщо товара не має то додаємо
                        //echo 'product add - '.$product_id.'<br>';
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product SET product_id = '".(int)$product_id."',model = '" . $this->db->escape($article) . "', sku = '" . $this->db->escape($article) . "', upc = '', ean = '', jan = '', isbn = '', mpn = '', location = '', quantity = '" . (int)$quantity . "', minimum = '1', subtract = '', stock_status_id = '" . (int)$stock_status_id . "', date_available = '', manufacturer_id = '" . (int)$manufacturer_id . "', shipping = '" . (int)$shipping . "', price = '" . (float)$price. "', points = '', weight = '', weight_class_id = '', length = '', width = '', height = '', length_class_id = '', status = 1,  tax_class_id = '', sort_order = 0, date_added = NOW()");

                        // Опис
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" .  (int)$this->langUkId  . "', name = '" . $this->db->escape($name_ua) . "', description = '" . nl2br(addslashes($description_ua)) . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" .  (int)$this->langRuId  . "', name = '" . $this->db->escape($name_ru) . "', description = '" . nl2br(addslashes($description_ru)) . "'");

                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = 0");

                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = 0, layout_id = 0");

                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id. "'");


                        if($product->picture){
                            $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
                            $x = 1;
                            foreach($product->picture as $pic){
                                //$this->save_product_photo($pic); str_replace('%20','_',$filename)
                                if($x==1){
                                    $image = $this->image($pic);
                                    $this->db->query("UPDATE " . DB_PREFIX . "product SET  image = '" . 'catalog/product/'.$this->db->escape(str_replace('%20','_',$image)) . "' WHERE product_id = '" . (int)$product_id . "'");
                                } else {
                                    $image = $this->image($pic);
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . 'catalog/product/'.$this->db->escape(str_replace('%20','_',$image)) . "', sort_order = '".$x."'");
                                }

                                $x++;
                            }
                        }

                        if(isset($oldprice) && $oldprice !=''){
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '1', priority = '0', price = '" . (float)$price . "', date_start = '', date_end = ''");
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$oldprice . "' WHERE product_id = '" . (int)$product_id . "'");
                        }
                        //ЧПУ
                        $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query LIKE 'product_id=" . $product_id . "'");
                        if($url_alias->num_rows == 0){
                            $key_seo =  $this->translit($name_ru);
                            $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $key_seo . "'");
                            if ($url_alias->num_rows > 0) {
                                //$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($key_seo.'_'.$product_id) . "', language_id = '" .  (int)$this->langRuId  . "'");
                                $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($this->translit($name_ru).'_'.$product_id) . "', language_id = '" .  (int)$this->langRuId  . "'");
                                $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($this->translit($name_ru).'_'.$product_id) . "', language_id = '" .  (int)$this->langUkId  . "'");
                            } else {
                                //$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($key_seo) . "', language_id = '" .  (int)$this->langRuId  . "'");
                                $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($this->translit($name_ru)) . "', language_id = '" .  (int)$this->langRuId  . "'");
                                $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($this->translit($name_ru)) . "', language_id = '" .  (int)$this->langUkId  . "'");
                            }
                        }

                    } else { //Якщо товар є то оновлюємо
                        //echo 'Оновлення товара '.$product_id.'<br>';
                        //$product_id = $еmpty_product->row['product_id'];
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET  manufacturer_id = '" . (int)$manufacturer_id . "', model = '" . $this->db->escape($article) . "', shipping = '" . (int)$shipping . "', price = '" . (float)$price . "',  quantity = '".(int)$quantity."',  stock_status_id = '" . (int)$stock_status_id . "', status = 1, date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
                        //echo 'original price - '.$product->price.'<br>';
                        //echo "UPDATE " . DB_PREFIX . "product SET  manufacturer_id = '" . (int)$manufacturer_id . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "',  quantity = '".(int)$quantity."',  status = 1, date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'";
                        //echo '=============================<br>';
                        /*$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" .  (int)$this->langUkId  . "', name = '" . $this->db->escape($product->name_ua) . "', description = '" . nl2br(addslashes($description_ua)) . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" .  (int)$this->langRuId  . "', name = '" . $this->db->escape($name) . "', description = '" . nl2br(addslashes($description)) . "'");*/


                        //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" .  (int)$this->langRuId  . "', name = '" . $this->db->escape($name) . "', description = '" . nl2br(addslashes($description)) . "'");
                        //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '1', name = '" . $this->db->escape($name) . "', description = '" . nl2br(addslashes($description)) . "'");


                        $this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($name_ru) . "', description = '" . $this->db->escape($description_ru) . "' WHERE  language_id = '" .  (int)$this->langRuId  . "' AND product_id = '" . (int)$product_id . "'");
                        $this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($name_ua) . "', description = '" . $this->db->escape($description_ua) . "' WHERE  language_id = '" .  (int)$this->langUkId  . "' AND product_id = '" . (int)$product_id . "'");

                        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");

                        //echo '<br>';

                        /**/
                        $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
                        if(isset($oldprice) && $oldprice !=''){
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '1', priority = '0', price = '" . (float)$price . "', date_start = '', date_end = ''");
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$oldprice . "' WHERE product_id = '" . (int)$product_id . "'");
                        }
                        /**/

                        if($product->picture){
                            $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
                            $x = 1;
                            foreach($product->picture as $pic){
                                if($x==1){
                                    $image = $this->image($pic);
                                    $this->db->query("UPDATE " . DB_PREFIX . "product SET  image = '" . 'catalog/product/'.$this->db->escape(str_replace('%20','_',$image)) . "' WHERE product_id = '" . (int)$product_id . "'");
                                } else {
                                    $image = $this->image($pic);
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . 'catalog/product/'.$this->db->escape(str_replace('%20','_',$image)) . "', sort_order = '".$x."'");
                                }

                                $x++;
                            }
                        }

                    }


                }
            }
        }

        echo "✅ Данные по Товарам успешно обновлены!";
    }

    public function attr(){
        //$start = microtime(true);
        //set_time_limit(0);
        $listFiles = glob($_SERVER['DOCUMENT_ROOT']."upload/file/xml/import_attr_*.csv");
        if (count($listFiles)>0) {
            echo "✅ Найдено  файлов для импорта:".count($listFiles)."<br>";
            if (($handle = fopen($listFiles[0], 'r')) !== FALSE) {
                echo "Загрузка данных из файла " . $listFiles[0] . "<br>";
                while (($row = fgetcsv($handle, 0, ',')) !== FALSE) {
                    $attr_list[] = $row;
                }
            }
            fclose($handle);

            //print_r($attr_list);
            foreach ($attr_list as $product) {
                //echo '==================<br>';
                //echo 'product_id - '.$product[0].'<br/>';
                //$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$this->attribute_group_id . "', sort_order = '0'");

                //$attribute_id = $this->db->getLastId();
                //$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langUkId . "', name = '" . $this->db->escape($name_attribute) . "'");
                //$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langRuId . "', name = '" . $this->db->escape($product[1]) . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product[0] . "'");


                $empty_attr = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE name = '" . addslashes($product[1]) . "' AND language_id = '" . $this->langRuId . "'");
                //print_r($empty_attr);
                if ($empty_attr->num_rows > 0) { // атрибут існує, привязуємо до товара

                    $attribute_id = $empty_attr->row['attribute_id'];

                } else {

                    $this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$this->attribute_group_id . "', sort_order = '0'");

                    $attribute_id = $this->db->getLastId();
                    //$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langUkId . "', name = '" . $this->db->escape($name_attribute) . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langRuId . "', name = '" . $this->db->escape($product[1]) . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langUkId . "', name = '" . $this->db->escape($product[1]) . "'");


                }
                // Запис та оновлення значень атрибутів в товарі
                // Рос мова
                $empty_attr_value_ru = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product[0] . "' AND language_id = '" . (int)$this->langRuId . "' AND attribute_id = '" . (int)$attribute_id . "'");
                if($empty_attr_value_ru->num_rows > 0){
                    $this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET  text='" . $this->db->escape($product[2]) . "' WHERE product_id = '" . (int)$product[0] . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$this->langRuId . "'");

                } else {
                    $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product[0] . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langRuId . "', text='" . $this->db->escape($product[2]) . "'");
                }
                // Укр мова
                $empty_attr_value_ua = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product[0] . "' AND language_id = '" . (int)$this->langUkId . "' AND attribute_id = '" . (int)$attribute_id . "'");
                if($empty_attr_value_ua->num_rows > 0){
                    //$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET  text='" . $this->db->escape($product[2]) . "' WHERE product_id = '" . (int)$product[0] . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langRuId . "',");

                } else {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product[0] . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langUkId . "', text='" . $this->db->escape($product[2]) . "'");
                }



                //$this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product[0] . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langUkId . "', text='" . $this->db->escape($product[2]) . "'");
                //$this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product[0] . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$this->langRuId . "', text='" . $this->db->escape($product[2]) . "'");

            }
            //echo "✅ Данные загружены, количество записей:".(count($attr_list)-1)."<br>";
            unlink($listFiles[0]);
        } else {
            echo 'all';
        }


    }

    public function productPhoto(){
        $images = $_SERVER['DOCUMENT_ROOT']."/upload/file/xml/photo.csv";
        $file_server = $this->scanfile(); // список файлів на хостингу
        $error = array();
        $row = 1;
        if (($handle = fopen($images, 'r')) !== FALSE) {
            //echo "Загрузка данных из файла " . $listFiles[0] . "<br>";
            while (($listFiles[] = fgetcsv($handle, 0, ',')) !== FALSE) {
                $row++;
            }
        }

        fclose($handle);
        if($listFiles){
            echo 'Загружаю фото...<br>';
            foreach ($listFiles as $product) {
                //if($i < 10) {
                $is = 0;

                // Папка, в которую нужно сохранить изображение
                $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/image/catalog/product/';
                if(isset($product[1])){
                    $imageUrl = $product[1];
                } else {
                    $imageUrl = '';
                }

                $filename = basename($imageUrl);
                $filename = str_replace('%20','_',$filename);
                if (in_array($filename, $file_server)) {
                    $is = 1;
                } else {
                    //echo 'Нет такой фото'.$filename.'<br>';
                }
                if($is == 0){
                    //echo 'copy - '.$imageUrl.' -> '.$folderPath . '' . $filename.'<br>';
                    $image_data = @file_get_contents($imageUrl);

                    if ($image_data === false) {
                        // Помилка, фото не існує по посиланню.
                        $error[] = $imageUrl;
                    } else {
                        copy($imageUrl, $folderPath . '' . $filename);
                    }

                }
            }
        } else {
            echo 'Файл не знайдено.';
        }

    }

    /* Додаткові функції */

    public function url_explode_alias(){

        $href = $this->config->get('import_import_xml_url');

        $params = array();
        $mass = parse_url($href);

        if($mass){
            $param = str_replace('&amp;','&',$mass['query']);
            $param = str_replace('%2C',',',$param);

            $param = explode("&", $param);
            foreach ($param as $par){
                $items =  explode('=',$par);
                if($items[1] !=''){
                    $params[$items[0]] = $items[1];
                }
            }
            $list_params = [$params];

            $start_url = $mass['scheme'].'://'.$mass['host'].$mass['path'].'?';

            $url = $start_url . http_build_query($list_params[0]);

            return $url;

        } else {
            echo "Проверьте ссылку! Может ссылка была не полностью скопирована!";
        }

    }

    public function manufacturer($name){
        $Empty_manufacturer = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE name = '" . $this->db->escape($name) . "'");

        if($Empty_manufacturer->num_rows == 0){ // Якщо виробника не знайдено, то додаємо
            $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($name) . "', sort_order = 0");
            $manufacturer_id = $this->db->getLastId();
            $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = 0");
            $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query LIKE 'manufacturer_id=" . $manufacturer_id . "'");

            if($url_alias->num_rows == 0){
                $key_seo =  $this->translit($name);
                $url_alias = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $key_seo . "'");
                if ($url_alias->num_rows > 0) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', language_id= '" . (int)$this->langRuId . "' , query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($key_seo.'_'.$manufacturer_id) . "'");
                } else {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id='0', language_id= '" . (int)$this->langRuId . "' , query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($key_seo) . "'");
                }
            }

            return $manufacturer_id;
        } else { // Якщо виробник знайдено то беремого його ідентифікатор
            $manufacturer_id = $Empty_manufacturer->row['manufacturer_id'];

            return $manufacturer_id;
        }
    }

    public function save(){

        $href = $this->config->get('import_import_xml_url');

        $params = array();
        $mass = parse_url($href);

        if($mass){
            $param = str_replace('&amp;','&',$mass['query']);
            $param = str_replace('%2C',',',$param);

            $param = explode("&", $param);
            foreach ($param as $par){
                $items =  explode('=',$par);
                if($items[1] !=''){
                    //echo $items[0].'    ---   ';
                    // $params .= $items[0].'=>'.$items[1].',';

                    $params[$items[0]] = $items[1];
                }
            }
            $list_params = [$params];

            $start_url = $mass['scheme'].'://'.$mass['host'].$mass['path'].'?';

            $url = $start_url . http_build_query($list_params[0]);
            //$feed = simplexml_load_file($this->request->get['url']);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $filename = $_SERVER['DOCUMENT_ROOT'].'/upload/file/xml/import.xml'; // Например, 'files/new_file.txt' (относительный путь) или '/var/www/html/files/new_file.txt' (абсолютный путь)


            if (file_put_contents($filename, $response) !== false) {
                echo "Файл успешно создан и данные записаны.<br/>";
            } else {
                echo "Не удалось создать файл.";
            }
        } else {
            echo "Проверьте ссылку! Может ссылка была не полностью скопирована!";
        }

    }

    private function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','і'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    private function image($url){
        $filename = basename($url);

        return $filename;
    }

    public function photoCsv(){ // Подготовка файла для списка фото для подальшой работы
        $list = array();
        //$filename = $_SERVER['DOCUMENT_ROOT'].'/upload/file/dotimen/import_dotimen.xml';
        $filename = $this->config->get('import_import_xml_url');
        $xml = simplexml_load_file($filename);
        foreach ($xml->shop->offers->offer as $product) {
            foreach($product->picture as $picture){
                $list[] = array($product['id'], $picture);
            }
        }

        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/upload/file/xml/photo.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    public function scanfile(){
        $directory = $_SERVER['DOCUMENT_ROOT'] . '/image/catalog/product/'; // Вкажіть шлях до папки, яку потрібно перевірити

        // Асинхронний запит до файлової системи за допомогою scandir()
        $files = scandir($directory, SCANDIR_SORT_NONE); // Використовуйте SCANDIR_SORT_NONE для уникнення сортування файлів

        // Обробка результатів асинхронного запиту
        if ($files !== false) {
            foreach ($files as $file) {
                $list_file[] = $file;
            }

        } else {
            echo "Помилка при скануванні папки.";
        }
        unset($list_file[0]);
        unset($list_file[1]);
        return $list_file;
    }

    public function attrCsv(){
        $list = array();
        //$start = microtime(true);
        //set_time_limit(0);

        $filename = $_SERVER['DOCUMENT_ROOT'].'upload/file/xml/import.xml';
        $xml = simplexml_load_file($filename);
        foreach ($xml->shop->offers->offer as $product) {
            foreach($product->param as $attribute){
                if(isset($attribute['unit']) && $attribute['unit'] != ''){
                    $unit = ', '.$attribute['unit'];
                } else {
                    $unit = '';
                }
                $list[] = array($product['id'], $attribute['name'].$unit, $attribute);
            }
        }

        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'upload/file/xml/attr.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        $this->explodecsv();

    }

    public function explodecsv()
    {
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . 'upload/file/xml/attr.csv';
        if (($handle = fopen($uploaddir, 'r')) !== FALSE)
        {
            while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
                //print_r($data);
                // $data=$this->convertToUTF($data);
                $lines[] = $data;
            }
            fclose($handle);
            echo "✅ Подотовка выполнена";

        }
        $i=0;

        foreach ( array_chunk( $lines, $this->fileBlock ) as $_lines )
        {

            $file_n = $_SERVER['DOCUMENT_ROOT'].'upload/file/xml/import_attr_'.$i.'.csv';
            $i++;
            $fp = fopen($file_n, 'w');
            foreach ($_lines as $fields) {
                fputcsv($fp, $fields, ',');
            }
            fclose($fp);
        }
    }

}
