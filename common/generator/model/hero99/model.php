<?php
/**
 * This is the template for generating the model class of a specified table.
 */

// TODO: Improve `BlameableBehavior` integration by creating $created_by and $updated_by relations and getters
// TODO: Improve relationship (not int foreign key) creation by removing any prefix (such as 'fk')

/* @var $this yii\web\View */
/* @var $generator common\generator\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

// Unsetting columns
$columnsToUnset = $generator->getColumnsToUnset();

foreach($columnsToUnset as $toUnset) {
    if (array_key_exists($toUnset, $tableSchema->columns)) {
        unset($tableSchema->columns[$toUnset]);
    }
}


echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

<?php if ($generator->useSoftDelete): ?>
use common\models\base\SoftDeletable;
<?php endif; ?>
use common\models\base\HeroActiveRecord;

<?php if ($generator->generateTimestampBehavior): ?>
use yii\behaviors\TimestampBehavior;
<?php endif; ?>
<?php if ($generator->generateBlameableBehavior): ?>
use yii\behaviors\BlameableBehavior;
<?php endif; ?>
use yii\db\Expression;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
<?php if ($generator->generateTimestampBehavior): ?>
 * @property string $created_at
 * @property string $updated_at
<?php endif; ?>
<?php if ($generator->generateBlameableBehavior): ?>
 * @property int $created_by
 * @property int $updated_by
<?php endif; ?>
<?php if ($generator->useSoftDelete): ?>
 * @property int $deleted
<?php endif; ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . $generator->getInterfacesToImplement() . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }

    public function behaviors()
    {
        return [
<?php if ($generator->generateTimestampBehavior): ?>
            <?= "[\n\t\t\t\t'class' => TimestampBehavior::className(),\n\t\t\t\t'value' => new Expression('NOW()'),\n\t\t\t],\n" ?>
<?php endif; ?>
<?php if ($generator->generateBlameableBehavior): ?>
            <?= "[\n\t\t\t\t'class' => BlameableBehavior::className(),\n\t\t\t\t'createdByAttribute' => 'created_by',\n\t\t\t\t'updatedByAttribute' => 'updated_by',\n\t\t\t],\n"?>
<?php endif; ?>
        ];
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($generator->useSoftDelete): ?>
    /**
    * @inheritdoc
    */
    public function softDelete() {
        $this->deleted = SoftDeletable::DELETED;
        $this->save();
    }
<?php endif; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
