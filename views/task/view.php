<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tasks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'parent_id',
                'value' => $model->getParentTitle($model->parent_id)
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->user->first_name.' '.$model->user->last_name
            ],
            'title',
            'points',
            [
                'attribute' => 'is_done',
                'value' => ($model->is_done)?"Yes":"No"
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
