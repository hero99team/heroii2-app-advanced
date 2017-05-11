<?php
/**
 * Created by PhpStorm.
 * User: danfsd
 * Date: 10/05/17
 * Time: 15:37
 */

namespace common\generator\model;


use common\models\base\HeroActiveRecord;
use common\models\query\base\HeroActiveQuery;

class Generator extends \yii\gii\generators\model\Generator
{
    public $ns = 'common\models';
    public $baseClass = 'common\models\base\HeroActiveRecord';
    public $queryBaseClass = 'common\models\query\base\HeroActiveQuery';

    // Behaviors
    public $useSoftDelete = true;
    public $generateTimestampBehavior = true;
    public $generateBlameableBehavior = true;

    private $columnsToUnset = [];
    private $interfacesToImplement = [];

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['baseClass'], 'validateClass', 'params' => ['extends' => HeroActiveRecord::className()]],
            [['queryBaseClass'], 'validateClass', 'params' => ['extends' => HeroActiveQuery::className()]],
            [['useSoftDelete', 'generateTimestampBehavior', 'generateBlameableBehavior'], 'boolean']
        ]);
    }

    public function hints()
    {
        return array_merge(parent::hints(), [
            'useSoftDelete' => 'Enabling this will add the ability to make soft deletions instead of hard deletions. The property <code>deleted</code> will be created.',
            'generateTimestampBehavior' => 'Enabling this will add the <code>TimestampBehavior</code> to your model class. The <code>created_at</code> and <code>updated_at</code> properties will be configured to use the database expression <code>NOW()</code> to get the current timestamp.',
            'generateBlameableBehavior' => 'Enabling this will add the <code>BlameableBehavior</code> to your model class. The <code>created_by</code> and <code>updated_by</code> properties will be configured.'
        ]);
    }

    /**
     * @return array
     */
    public function getColumnsToUnset(): array
    {
        if ($this->useSoftDelete) {
            $this->columnsToUnset = array_merge($this->columnsToUnset, [
                'deleted'
            ]);
        }

        if ($this->generateTimestampBehavior) {
            $this->columnsToUnset = array_merge($this->columnsToUnset, [
                'created_at',
                'updated_at',
            ]);
        }

        if ($this->generateBlameableBehavior) {
            $this->columnsToUnset = array_merge($this->columnsToUnset, [
                'created_by',
                'updated_by',
            ]);
        }

        return $this->columnsToUnset;
    }

    /**
     * @return string
     */
    public function getInterfacesToImplement()
    {
        if ($this->useSoftDelete) {
            $this->interfacesToImplement = array_merge($this->interfacesToImplement, [
                'SoftDeletable'
            ]);
        }

        $implements = " implements ";
        foreach($this->interfacesToImplement as $index => $interface) {
            $implements .= $interface . ",";
        }

        $implements = rtrim($implements, ",");
        $implements .= " ";

        return count($this->interfacesToImplement) > 0 ? $implements : "";
    }


    
    


}