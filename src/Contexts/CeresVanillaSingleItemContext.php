<?php
namespace CeresVanilla\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\SingleItemContext;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;

use IO\Services\ItemSearch\Services\ItemSearchService;
use IO\Services\ItemSearch\SearchPresets\CrossSellingItems;

class CeresVanillaSingleItemContext extends SingleItemContext implements ContextInterface
{
    public $themeItem;
    public $accessory;
    public $similar;
    public $collection;

    public function init($params)
    {
        parent::init($params);
        $itemRep =  pluginApp(ItemRepositoryContract::class);
        $this->themeItem= $itemRep->show($this->item['documents'][0]['data']['item']['id']);

        $options = array(
        			"itemId" => $this->item['documents'][0]['data']['item']['id'],
        			"relation" => "Accessory"      // Nutze die Liste Zubehoer
       		);
     		$searchfactory = CrossSellingItems::getSearchFactory( $options );
     		$searchfactory->setPage(1, 4); // Begrenze auf 4 Artikel
      		$result = pluginApp(ItemSearchService::class)->getResult($searchfactory);
      		$this->accessory = $result['documents'];

        $options = array(
              "itemId" => $this->item['documents'][0]['data']['item']['id'],
              "relation" => "Similar"      // Nutze die Liste Ähnlich
            );
            $searchfactory = CrossSellingItems::getSearchFactory( $options );
      	    $searchfactory->setPage(1, 4); // Begrenze auf 4 Artikel
        	$result = pluginApp(ItemSearchService::class)->getResult($searchfactory);
        	$this->similar= $result['documents'];
    }
}
?>
