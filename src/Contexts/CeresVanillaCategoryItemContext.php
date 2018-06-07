<?php
namespace CeresVanilla\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\CategoryItemContext;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;

class CeresVanillaCategoryItemContext extends CategoryItemContext implements ContextInterface
{
    public $themeItem;

    public function init($params)
    {
        parent::init($params);
        $itemRep =  pluginApp(ItemRepositoryContract::class);
        $this->themeItem= $itemRep->show($this->item['documents'][0]['data']['item']['id']);
    }
}
?>