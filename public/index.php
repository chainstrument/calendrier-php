<?php

include_once '../vendor/autoload.php';
$month = new \App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay()->modify('last monday')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


    <nav class="navbar navbar-dark bg-primary mb3">

        <a href="index.php" class="navbar-brand">Mon calendrier</a>

    </nav>

    <h1><?=$month?></h1>

    <?=$month->getWeeks();?>

    <table class="calendar__table calendar__table--<?= $month->getWeeks() ?>weeks" >

        <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>
            <tr>
                <?php foreach ($month->days as $k => $day): 
                    $date = (clone $start)->modify("+" . ($k + $i * 7) . " days");
                    ?>
                   <td class="<?= $month->widthInMonth($date) ? '' : 'calendar__othermonth' ?>">
                       <?php if ($i === 0): ?>
                        <div class="calendar__weekday"><?=$day?></div>
                       <?php endif;?>
                        <div class="calendar__day"><?= $date->format('d'); ?></div>
                   </td>
                <?php endforeach;?>

            </td>

            </tr>
       <?php endfor;?>

    </table>
</body>
</html>