<?php
 class ModelExtensionModuleAttributesToText extends Model{public function getText($a50590660299ce166669dd38b41301541,$ac7ca0645cfdc1bf5c0385ef187dbe38b){$a4b623871d0d5b79d578031bf6918803a="";$this->load->model('catalog/product');$adf30e42e3e4241ac343e4e12a3c0eb47=$this->model_catalog_product->getProductAttributes($a50590660299ce166669dd38b41301541);$a57717f93186ecb7b42a1a50458b824df=array();foreach($adf30e42e3e4241ac343e4e12a3c0eb47 as $a86e30f87de9239d54244397de8653f20){foreach($a86e30f87de9239d54244397de8653f20['attribute']as $ab3ce15cb8bd12b50ed7761c02dfda7b1){if(isset($ac7ca0645cfdc1bf5c0385ef187dbe38b[$ab3ce15cb8bd12b50ed7761c02dfda7b1['attribute_id']])){if($ac7ca0645cfdc1bf5c0385ef187dbe38b[$ab3ce15cb8bd12b50ed7761c02dfda7b1['attribute_id']]['show']==1){$a57717f93186ecb7b42a1a50458b824df[]=$ab3ce15cb8bd12b50ed7761c02dfda7b1['text'];}else if($ac7ca0645cfdc1bf5c0385ef187dbe38b[$ab3ce15cb8bd12b50ed7761c02dfda7b1['attribute_id']]['show']==2&&in_array($ab3ce15cb8bd12b50ed7761c02dfda7b1['text'],explode(',',$ac7ca0645cfdc1bf5c0385ef187dbe38b[$ab3ce15cb8bd12b50ed7761c02dfda7b1['attribute_id']]['replace']))){$a57717f93186ecb7b42a1a50458b824df[]=$ab3ce15cb8bd12b50ed7761c02dfda7b1['name'];}}}}if($a57717f93186ecb7b42a1a50458b824df){$a746cfbc783560fc17d1446adcaa66c72=isset($ac7ca0645cfdc1bf5c0385ef187dbe38b['separator'])?$ac7ca0645cfdc1bf5c0385ef187dbe38b['separator']:"/";$a4b623871d0d5b79d578031bf6918803a=implode($a57717f93186ecb7b42a1a50458b824df,$a746cfbc783560fc17d1446adcaa66c72);}if(isset($ac7ca0645cfdc1bf5c0385ef187dbe38b['cut'])){$a5bb9c33fc07fcf274bbc84481855800e=strlen($a4b623871d0d5b79d578031bf6918803a)>$ac7ca0645cfdc1bf5c0385ef187dbe38b['cut']?'..':'';$a4b623871d0d5b79d578031bf6918803a=utf8_substr($a4b623871d0d5b79d578031bf6918803a,0,$ac7ca0645cfdc1bf5c0385ef187dbe38b['cut']).$a5bb9c33fc07fcf274bbc84481855800e;}return $a4b623871d0d5b79d578031bf6918803a;}}
//author sv2109 (sv2109@gmail.com) license for 1 product copy granted for teragroup (teragroupstudio@gmail.com resserve.com.ua,www.resserve.com.ua,resserve.start-site.com.ua)