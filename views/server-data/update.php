<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServerData */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Server Data',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="server-data-update">

    <h1><?= Html::encode($this->title) ?></h1>
<?php echo Html::a(Yii::t('app', '<< Back'), Yii::$app->request->getReferrer(), [
		            'onclick'=>"js:history.go(-1);return false;",'class'=>'btn btn-sm btn-primary',
		        ]) 
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
