<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'parent_id',
                'value' => function($model) {
                    $parentTitle = $model->getParentTitle($model->parent_id);
                    return $parentTitle;
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->user->first_name . ' ' . $model->user->last_name;
                }
            ],
            'title',
            'points',
            [
                'attribute' => 'is_done',
                'value' => function($model) {
                    return ($model->is_done == 1) ? "Yes" : "No";
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]);
    ?>


</div>
