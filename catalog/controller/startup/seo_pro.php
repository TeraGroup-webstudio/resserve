<?php
class ControllerStartupSeoPro extends Controller {
    private $cache_data = null;
    private $languages = array();
    private $config_language;
    private $prefix_full;
    private $save_language;

    private $config_store_id;

    private $config_language_id;

    public function __construct($registry) {
        parent::__construct($registry);

        if ($this->config->get('theme_default_prefix_lang_status') == 1) {
            $this->prefix_full = $this->config->get('theme_default_prefix_lang');
            $this->save_language = $this->config->get('theme_default_lang_cookie');

            $query = $this->db->query("SELECT `value` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_language'");
            if ($this->prefix_full) {
                $this->config_language = $query->row['value'];
            } else {
                $this->config_language = substr($query->row['value'], 0, 2);
            }


            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE status = '1'");
            foreach ($query->rows as $result) {
                if ($this->prefix_full) {
                    $result['shortcode'] = $result['code'];
                } else {
                    $result['shortcode'] = substr($result['code'], 0, 2);
                }
                $this->languages[$result['shortcode']] = $result;
            }
        }

        $this->config_store_id = $this->config->get('config_store_id');
        $this->config_language_id = $this->config->get('config_language_id');
        $this->cache_data = $this->cache->get('seo_pro.'.(int)$this->config->get('config_store_id').".".(int)$this->config->get('config_language_id'));
        if (!$this->cache_data) {
            $query = $this->db->query("SELECT LOWER(`keyword`) as 'keyword', `query` FROM " . DB_PREFIX . "seo_url WHERE store_id='".(int)$this->config_store_id."' AND language_id = '".(int)$this->config_language_id."' ORDER BY seo_url_id");
            $this->cache_data = array();
            foreach ($query->rows as $row) {
                if (isset($this->cache_data['keywords'][$row['keyword']])){
                    $this->cache_data['keywords'][$row['query']] = $this->cache_data['keywords'][$row['keyword']];
                    continue;
                }
                $this->cache_data['keywords'][$row['keyword']] = $row['query'];
                $this->cache_data['queries'][$row['query']] = $row['keyword'];
            }
            $this->cache->set('seo_pro.'.(int)$this->config_store_id.".".(int)$this->config_language_id, $this->cache_data);
        }
    }

    public function index() {
        /**/
        if ($this->config->get('theme_default_prefix_lang_status') == 1) {
            $code = null;

            if (isset($this->request->get['_route_'])) {
                $route_ = $this->request->get['_route_'];
                $tokens = explode('/', $this->request->get['_route_']);

                if (array_key_exists($tokens[0], $this->languages)) {
                    $code = $tokens[0];
                    $this->request->get['_route_'] = substr($this->request->get['_route_'], strlen($code) + 1);
                }

                if (trim($this->request->get['_route_']) == '' || trim($this->request->get['_route_']) == 'index.php') {
                    unset($this->request->get['_route_']);
                }
            }

            $xhttprequested = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && (strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

            if ((!$this->save_language && !isset($code) && $xhttprequested) || ($this->save_language && !isset($code) && (!isset($_SERVER['HTTP_REFERER']) || $xhttprequested))) {
                if (isset($this->session->data['language'])) {
                    if ($this->prefix_full) {
                        $code = $this->session->data['language'];
                    } else {
                        $code = substr($this->session->data['language'],0,2);
                    }
                } elseif (isset($this->request->cookie['language'])) {
                    if ($this->prefix_full) {
                        $code = $this->request->cookie['language'];
                    } else {
                        $code = substr($this->request->cookie['language'],0,2);
                    }
                } else {
                    $code = $this->config_language;
                }
            } elseif ((!$this->save_language && !isset($code) && !$xhttprequested) || ($this->save_language && !isset($code) && (isset($_SERVER['HTTP_REFERER']) || !$xhttprequested))) {
                $code = $this->config_language;
            }

            if ($this->prefix_full) {
                if (!isset($this->session->data['language']) || $this->session->data['language'] != $code) {
                    $this->session->data['language'] = $this->languages[$code]['code'];
                }
            } else {
                if (!isset($this->session->data['language']) || substr($this->session->data['language'],0,2) != $code) {
                    $this->session->data['language'] = $this->languages[$code]['code'];
                }
            }

            $captcha = isset($this->request->get['route']) && strripos($this->request->get['route'],'extension/captcha');

            if (!$xhttprequested && !$captcha) {
                setcookie('language', $this->languages[$code]['code'], time() + 60 * 60 * 24 * 30, '/',
                    ($this->request->server['HTTP_HOST'] != 'localhost') ? $this->request->server['HTTP_HOST'] : false);
            }

            $this->config->set('config_language_id', $this->languages[$code]['language_id']);
            $this->config->set('config_language', $this->languages[$code]['shortcode']);

            $language = new Language($this->languages[$code]['code']);
            $language->load('default');
            $language->load($this->languages[$code]['code']);
            $this->registry->set('language', $language);
        }
        /**/

        // Add rewrite to url class
        if ($this->config->get('config_seo_url')) {
            $this->url->addRewrite($this);
        } else {
            return;
        }

        // Decode URL
        if (!isset($this->request->get['_route_'])) {
            $this->validate();
        } else {
            $route_ = $route = $this->request->get['_route_'];
            unset($this->request->get['_route_']);
            $parts = explode('/', trim(utf8_strtolower($route), '/'));
            list($last_part) = explode('.', array_pop($parts));
            array_push($parts, $last_part);

            $rows = array();
            foreach ($parts as $keyword) {
                if (isset($this->cache_data['keywords'][$keyword])) {
                    $rows[] = array('keyword' => $keyword, 'query' => $this->cache_data['keywords'][$keyword]);
                } elseif ($keyword!='') {
                    $query_multilang = $this->db->query("SELECT `query` FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $keyword ."'");
                    if ($query_multilang->row) $rows[] = array('keyword' => $keyword, 'query' => $query_multilang->row['query']);
                }
            }

            if (isset($this->cache_data['keywords'][$route])){
                $keyword = $route;
                $parts = array($keyword);
                $rows = array(array('keyword' => $keyword, 'query' => $this->cache_data['keywords'][$keyword]));
            }

            if (count($rows) == sizeof($parts)) {
                $queries = array();
                foreach ($rows as $row) {
                    $queries[utf8_strtolower($row['keyword'])] = $row['query'];
                }

                reset($parts);
                foreach ($parts as $part) {
                    if(!isset($queries[$part])) return false;
                    $url = explode('=', $queries[$part], 2);

                    if ($url[0] == 'category_id') {
                        if (!isset($this->request->get['path'])) {
                            $this->request->get['path'] = $url[1];
                        } else {
                            $this->request->get['path'] .= '_' . $url[1];
                        }
                    } elseif (count($url) > 1) {
                        $this->request->get[$url[0]] = $url[1];
                    }
                }
            } else {
                $this->request->get['route'] = 'error/not_found';
            }

            if (isset($this->request->get['product_id'])) {
                $this->request->get['route'] = 'product/product';
                if (!isset($this->request->get['path'])) {
                    $path = $this->getPathByProduct($this->request->get['product_id']);
                    if ($path) $this->request->get['path'] = $path;
                }
            } elseif (isset($this->request->get['path'])) {
                $this->request->get['route'] = 'product/category';
            } elseif (isset($this->request->get['manufacturer_id'])) {
                $this->request->get['route'] = 'product/manufacturer/info';
            } elseif (isset($this->request->get['information_id'])) {
                $this->request->get['route'] = 'information/information';
            } elseif(isset($this->cache_data['queries'][$route_])) {
                header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
                $this->response->redirect($this->cache_data['queries'][$route_]);
            } else {
                if (isset($queries[$parts[0]])) {
                    $this->request->get['route'] = $queries[$parts[0]];
                }
            }

            $this->validate();

            if (isset($this->request->get['route'])) {
                return new Action($this->request->get['route']);
            }
        }
    }

    public function rewrite($link, $code = '') {

        /* редирект*/
        //$chpu = 'https://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']; // Отримуємо посилання з адресної строки
        //$this->load->model('tool/redirect');

        $protocol = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://';
        $chpu = $protocol.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']; // Отримуємо посилання з адресної строки

        $this->load->model('tool/redirect');

        $url = $this->model_tool_redirect->getRedirect(trim($chpu));

        if(isset($url['old_url'])){
            if($chpu === str_replace('&amp;','&',$url['old_url'])){
                $seo = $url['new_url'];
                header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
                $this->response->redirect($seo,301);
            }
        }

        /* редирект*/

        if($this->config->get('theme_default_prefix_lang_status') == 1) {
            if (!$code) {
                if ($this->prefix_full) {
                    $code = $this->session->data['language'];
                } else {
                    $code = substr($this->session->data['language'], 0, 2);
                }
            }
        } else {
            $code = false;
        }

        if ($this->config_store_id != $this->config->get('config_store_id') || $this->config_language_id != $this->config->get('config_language_id')) {
            $this->__construct($this->registry);
        }

        if (!$this->config->get('config_seo_url')) return $link;

        $seo_url = '';

        $component = parse_url(str_replace('&amp;', '&', $link));

        $data = array();
        parse_str($component['query'], $data);

        $route = $data['route'];
        unset($data['route']);

        switch ($route) {
            case 'product/product':
                if (isset($data['product_id'])) {
                    $explode = explode('/',$data['product_id']);
                    if (!empty($explode)) $data['product_id'] = $explode[0];
                    $tmp = $data;
                    $data = array();
                    if ($this->config->get('config_seo_url_include_path')) {
                        $data['path'] = $this->getPathByProduct($tmp['product_id']);
                        if (!$data['path']) return $link;
                    }
					//print_r($data);
                    $this->setOCFManufacturerByProduct($tmp['product_id'], $data);
					//echo '======';
					//print_r($data);
                    $data['product_id'] = $tmp['product_id'];
                    $allowed_parameters = array(
                        'product_id', 'tracking',
                        'uri', 'list_type',
                        'gclid', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
                        'type', 'source', 'block', 'position', 'keyword',
                        'yclid', 'ymclid', 'openstat', 'frommarket',
                        'openstat_service', 'openstat_campaign', 'openstat_ad', 'openstat_source'
                    );
                    foreach($allowed_parameters as $ap) {
                        if (isset($tmp[$ap])) {
                            $data[$ap] = $tmp[$ap];
                        }
                    }
                }
                break;

            case 'product/category':
                if (isset($data['path'])) {
                    $category = explode('_', $data['path']);
                    $category = end($category);
                    $data['path'] = $this->getPathByCategory($category);
                    if (!$data['path']) return $link;
                }
                break;

            case 'product/product/review':
            case 'information/information/info':
            case 'information/information/agree':
            case 'checkout/cart/remove':
            case 'common/cart/info':
                return $link;
                break;

            default:
                break;
        }

        if ($component['scheme'] == 'https') {
            $link = $this->config->get('config_ssl');
        } else {
            $link = $this->config->get('config_url');
        }
        if($this->config->get('theme_default_prefix_lang_status') == 1) {
            if ($code != $this->config_language) {
                $link .= $code . '/index.php?route=' . $route;
            } else {
                $link .= 'index.php?route=' . $route;
            }
        } else {
            $link .= 'index.php?route=' . $route;
        }

        if (count($data)) {
            $link .= '&amp;' . urldecode(http_build_query($data, '', '&amp;'));
        }

        $queries = array();
        if(!in_array($route, array('product/search'))) {
            foreach($data as $key => $value) {
                switch($key) {
                    case 'product_id':
                    case 'manufacturer_id':
                    case 'category_id':
                    case 'information_id':
                    case 'order_id':
                        $queries[] = $key . '=' . $value;
                        unset($data[$key]);
                        $postfix = 1;
                        break;

                    case 'path':
                        $categories = explode('_', $value);
                        foreach($categories as $category) {
                            $queries[] = 'category_id=' . $category;
                        }
                        unset($data[$key]);
                        break;

                    default:
                        break;
                }
            }
        }

        if(empty($queries)) {
            $queries[] = $route;
        }

        $rows = array();
        foreach($queries as $query) {
            if(isset($this->cache_data['queries'][$query])) {
                $rows[] = array('query' => $query, 'keyword' => $this->cache_data['queries'][$query]);
            }
        }

        if(count($rows) == count($queries)) {
            $aliases = array();
            foreach($rows as $row) {
                $aliases[$row['query']] = $row['keyword'];
            }
            foreach($queries as $query) {
                $seo_url .= '/' . rawurlencode($aliases[$query]);
            }
        }

        if ($seo_url == '') return $link;

        if($this->config->get('theme_default_prefix_lang_status') == 1) {
            if ($code != $this->config_language) {
                $seo_url = $code . '/' . trim($seo_url, '/');
            } else {
                $seo_url = trim($seo_url, '/');
            }
        } else {
            $seo_url = trim($seo_url, '/');
        }

        if ($component['scheme'] == 'https') {
            $seo_url = $this->config->get('config_ssl') . $seo_url;
        } else {
            $seo_url = $this->config->get('config_url') . $seo_url;
        }

        if (isset($postfix)) {
            $seo_url .= trim($this->config->get('config_seo_url_postfix'));
        } else {
            $seo_url .= '/';
        }

        if(substr($seo_url, -2) == '//') {
            $seo_url = substr($seo_url, 0, -1);
        }

        if (count($data)) {
            $seo_url .= '?' . urldecode(http_build_query($data, '', '&amp;'));
        }

        return $seo_url;
    }

    private function getPathByProduct($product_id) {
        $product_id = (int)$product_id;
        if ($product_id < 1) return false;

        static $path = null;
        if (!isset($path)) {
            $path = $this->cache->get('product.seopath');
            if (!isset($path)) $path = array();
        }

        if (!isset($path[$product_id])) {
            $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . $product_id . "' ORDER BY main_category DESC LIMIT 1");

            $path[$product_id] = $this->getPathByCategory($query->num_rows ? (int)$query->row['category_id'] : 0);

            $this->cache->set('product.seopath', $path);
        }

        return $path[$product_id];
    }

    private function setOCFManufacturerByProduct($product_id, &$data) {
      $query = $this->db->query("SELECT manufacturer_id FROM `" . DB_PREFIX . "product` WHERE product_id = '" . (int)$product_id . "'");

      if (!$query->num_rows) {
        return;
      }

      $data['ocf'] = 'F1S0V' . $query->row['manufacturer_id'];
      $data['ocf_product'] = $product_id;

      if (isset($data['path'])) {
        $categories = array_filter(explode('_', $data['path']), 'strlen');

        $data['ocf_product_category'] = array_pop($categories);
      }
/*
      if (isset($data['path'])) {
        $categories = array_filter(explode('_', $data['path']), 'strlen');

        $category_id = array_pop($categories);

        $page_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ocfilter_page` WHERE category_id = '" . (int)$category_id . "' AND `params` = '{\"1.0\":[\"" . (int)$query->row['manufacturer_id'] . "\"]}'");

        if ($page_query->num_rows) {
          $data['ocfilter_page_id'] = $page_query->row['page_id'];
        }
      }
      */
    }

    private function getPathByCategory($category_id) {
        $category_id = (int)$category_id;
        if ($category_id < 1) return false;

        static $path = null;
        if (!isset($path)) {
            $path = $this->cache->get('category.seopath');
            if (!isset($path)) $path = array();
        }

        if (!isset($path[$category_id])) {
            $max_level = 10;

            $sql = "SELECT CONCAT_WS('_'";
            for ($i = $max_level-1; $i >= 0; --$i) {
                $sql .= ",t$i.category_id";
            }
            $sql .= ") AS path FROM " . DB_PREFIX . "category t0";
            for ($i = 1; $i < $max_level; ++$i) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
            }
            $sql .= " WHERE t0.category_id = '" . $category_id . "'";

            $query = $this->db->query($sql);

            $path[$category_id] = $query->num_rows ? $query->row['path'] : false;

            $this->cache->set('category.seopath', $path);
        }

        return $path[$category_id];
    }

    private function validate() {
        if (isset($this->request->get['route']) && $this->request->get['route'] == 'error/not_found') {
            return;
        }
        if (ltrim($this->request->server['REQUEST_URI'], '/') =='sitemap.xml') {
            $this->request->get['route'] = 'extension/feed/google_sitemap';
            return;
        }

        if(empty($this->request->get['route'])) {
            $this->request->get['route'] = 'common/home';
        }

        if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return;
        }

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $config_ssl = substr($this->config->get('config_ssl'), 0, $this->strpos_offset('/', $this->config->get('config_ssl'), 3) + 1);
            $url = str_replace('&amp;', '&', $config_ssl . ltrim($this->request->server['REQUEST_URI'], '/'));
            $seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('route')), true));
        } else {
            $config_url = substr($this->config->get('config_url'), 0, $this->strpos_offset('/', $this->config->get('config_url'), 3) + 1);
            $url = str_replace('&amp;', '&', $config_url . ltrim($this->request->server['REQUEST_URI'], '/'));
            $seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('route')), false));
        }

        if (rawurldecode($url) != rawurldecode($seo)) {
            header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');

            $this->response->redirect($seo);
        }
    }

    private function strpos_offset($needle, $haystack, $occurrence) {
        // explode the haystack
        $arr = explode($needle, $haystack);
        // check the needle is not out of bounds
        switch($occurrence) {
            case $occurrence == 0:
                return false;
            case $occurrence > max(array_keys($arr)):
                return false;
            default:
                return strlen(implode($needle, array_slice($arr, 0, $occurrence)));
        }
    }

    private function getQueryString($exclude = array()) {
        if (!is_array($exclude)) {
            $exclude = array();
        }

        return urldecode(http_build_query(array_diff_key($this->request->get, array_flip($exclude))));
    }
}
?>