<?php

use yii\helpers\Html;

/**
 * Order index page.
 */

 /* @var $packs array */
?>
<div class="order-pack-requirements">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
            <h1>
                Brucie’s Banana Bazaar <br />
            </h1>

            <hr />
            
            <p>Welcome to the pack calculation tool. This tool will calculate the optimum number of packs required to fulfill an order.</p>

            <p>The current available pack sizes can be found <?= Html::a('here', ['/pack/index']) ?>.</p>

            <p>Contact me <a href="mailto:tom.butts93@gmail.com">here</a> if you would like to test more pack sizes.</p>

            <br />

            <?= Html::a('Get Started', ['/order/create'], ['class'=>'btn btn-primary']) ?>

            </div>
        </div>
    </div>

    
    <br>
    
</div>
