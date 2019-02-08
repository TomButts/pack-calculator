<?php

use yii\helpers\Html;

/**
 * Display the required number of packs for an order.
 */

/* @var $volume integer */
/* @var $requiredPacks array */
?>

<div class="order-pack-requirements">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
            <h1>
                Required Banana Packs<br>
                <small>The number of bananas ordered was: <?= $volume; ?></small>
            </h1>
            <hr />

            <br />
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Number of Packs</th>
                            <th>Pack Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($requiredPacks as $size => $number) {
                            echo '<tr>';
                            echo '<td>' . $number . '</td>';
                            echo '<td>' . $size . '</td>';
                            echo '</tr>';
                        } ?>
                    </tbody> 
                </table>
                
                <br />

                <h5>Total Bananas Required: <?= $totalRequired ?></h5>

                <br />
                
                <?= Html::a('Calculate Another Order', ['/order/create'], ['class'=>'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>