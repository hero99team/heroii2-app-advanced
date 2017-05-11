<?php
/**
 * Created by PhpStorm.
 * User: danfsd
 * Date: 11/05/17
 * Time: 09:52
 */

namespace common\models\base;


use yii\db\ActiveRecord;

interface SoftDeletable {
    public function softDelete();
}

class HeroActiveRecord extends ActiveRecord
{

}