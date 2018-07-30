<?php

namespace api\modules\lottery;

class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $id = 'lottery';

    /**
     * @var string
     */
    public $controllerNamespace = 'api\modules\lottery\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

}
