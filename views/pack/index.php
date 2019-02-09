<?php

use yii\helpers\Html;

/**
 * Order index page.
 */

/* @packs array */
?>

<div class="packs-index">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
            <h1>
                Available Banana Packs<br>
                <small>The following table displays existing banana pack records.</small>
            </h1>
            <hr />

            <p>Please do contact me with additional numbers or an entirely new set. I will add the new additions a soon as I can.</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Pack Name</th>
                        <th>Pack Size</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($packs as $pack) {
                        echo '<tr>';
                        echo '<td>' . $pack->id . '</td>';
                        echo '<td>' . $pack->name . '</td>';
                        echo '<td>' . $pack->volume . '</td>';
                        echo '</tr>';
                    } ?>
                </tbody> 
            </table>

            <br>

            <?= Html::a('Return To Orders', ['/order/create'], ['class'=>'btn btn-primary']) ?>
        </div>
    </div>
</div>
