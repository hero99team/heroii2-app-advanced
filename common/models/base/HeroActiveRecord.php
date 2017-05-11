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
    const NORMAL = 0;
    const DELETED = 1;

    /**
     * Changes the `deleted` field to `SoftDeletable::DELETED`.
     */
    public function softDelete();
}

class HeroActiveRecord extends ActiveRecord
{

}