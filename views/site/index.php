<?php
/* @var $this yii\web\View */

$this->title = 'Home';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Simple Task Manager!</h1>
    </div>
    <div class="body-content">
        <div class="row">
            <?php
            //debugPrint($users);
            if (!empty($users)) {
                foreach ($users as $usr) {
                    ?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php
                                echo $usr['first_name'] . ' ' . $usr['last_name'] . '(' . $usr['task_count'] . '/' . $usr['task_point'] . ')';
                                ?>
                                <hr/>
                                <ul style="padding-left: 12px;">
                                    <?php
                                    if (!empty($usr['parent_task'])) {
                                        foreach ($usr['parent_task'] as $pt) {
                                            $points = \app\helpers\AppHelper::calculateTaskPoint($usr['id'],$pt['id']);
                                            ?>
                                            <li>
                                                <?= $pt['title']; ?>(<?= $points; ?>)
                                                <?php
                                                if(!empty($pt['sub_task'])){
                                                    echo \app\helpers\AppHelper::generateRecursiveTaskList($usr['id'],$pt['sub_task']);
                                                }
                                                ?>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
