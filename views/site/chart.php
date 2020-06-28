<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="site-index">

    <h3 class="chartTitle"><?=$chart['title']?></h3><br>
    <table class='zebra'>
        <tr>
            <th>Number</th>
            <th>Date</th>
            <th>Total</th>
            <th>principle</th>
            <th>Interest</th>
            <th>residuePrincipalDebt</th>
            
        </tr>
        <?php foreach ($payments as $payment): ?>
        <tr>
            <td><?=$payment['number']?></td>
            <td><?=$payment['date']?></td>
            <td><?=$payment['total']?></td>
            <td><?=$payment['principle']?></td>
            <td><?=$payment['interest']?></td>
            <td><?=$payment['residuePrincipalDebt']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


