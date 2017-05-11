<?php

use common\models\base\HeroActiveRecord;
use common\models\query\base\HeroActiveQuery;

use yii\gii\generators\model\Generator;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator common\generator\model\Generator */

// TODO: make this assignment go to Generator class instead of here.
$generator->baseClass = HeroActiveRecord::className();
$generator->queryBaseClass = HeroActiveQuery::className()

?>

<?= $form->field($generator, 'tableName')->textInput(['table_prefix' => $generator->getTablePrefix()]) ?>
<?= $form->field($generator, 'modelClass') ?>
<?= $form->field($generator, 'ns') ?>
<?= $form->field($generator, 'baseClass') ?>

<h3>Class Behaviors</h3>
<?= $form->field($generator, 'useSoftDelete')->checkbox() ?>
<?= $form->field($generator, 'generateTimestampBehavior')->checkbox() ?>
<?= $form->field($generator, 'generateBlameableBehavior')->checkbox() ?>

<h3>Database</h3>
<?= $form->field($generator, 'db') ?>
<?= $form->field($generator, 'generateLabelsFromComments')->checkbox() ?>
<?= $form->field($generator, 'useSchemaName')->checkbox() ?>
<?= $form->field($generator, 'useTablePrefix')->checkbox() ?>
<?= $form->field($generator, 'generateRelations')->dropDownList([
    Generator::RELATIONS_NONE => 'No relations',
    Generator::RELATIONS_ALL => 'All relations',
    Generator::RELATIONS_ALL_INVERSE => 'All relations with inverse',
]) ?>

<h3>Query</h3>
<?= $form->field($generator, 'generateQuery')->checkbox() ?>
<?= $form->field($generator, 'queryNs') ?>
<?= $form->field($generator, 'queryClass') ?>
<?= $form->field($generator, 'queryBaseClass') ?>

<h3>Internationalization</h3>
<?= $form->field($generator, 'enableI18N')->checkbox() ?>
<?= $form->field($generator, 'messageCategory') ?>

