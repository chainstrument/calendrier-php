<?php
ini_set("display_errors", true);

include_once '../vendor/autoload.php';
require_once '../src/bootstrap.php';

$pdo = get_pdo();
$events = new App\Calendar\Events($pdo);
$month = new App\Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start :  $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();

$end = (clone $start)->modify( '+' . (6 + 7 * ($weeks - 1)) . 'days');
$events = $events->getEventsBetweenByDay($start, $end);


require_once '../views/header.php';
?>

    <nav class="navbar navbar-dark bg-primary mb3">

        <a href="index.php" class="navbar-brand">Mon calendrier</a>

    </nav>
    <div class="d-flex flex-row align-items-center justify-content-between">

        <h1><?=$month?></h1>
        <div>
            <a href="index.php?month=<?php echo $month->previousMonth()->month; ?>&year=<?php echo $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="index.php?month=<?php echo $month->nextMonth()->month; ?>&year=<?php echo $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>


    <?=$month->getWeeks();?>

    <table class="calendar__table calendar__table--<?= $month->getWeeks() ?>weeks" >

        <?php for ($i = 0; $i < $month->getWeeks() + 1; $i++): ?>
            <tr>
                <?php 
                    
                foreach ($month->days as $k => $day): 
                    $date = (clone $start)->modify("+" . ($k + $i * 7) . " days");
                    $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                    var_dump($eventsForDay);

                    ?>
                   <td class="<?= $month->widthInMonth($date) ? '' : 'calendar__othermonth' ?>">
                       <?php if ($i === 0): ?>
                        <div class="calendar__weekday"><?=$day?></div>
                       <?php endif;?>
                        <div class="calendar__day"><?= $date->format('d'); ?></div>
                        <?php  
                        foreach($eventsForDay as $event) : 
                            
                            ?>
                            
                            <div class="calendar__event">
                                <?php echo $event->getStart()->format('H:i'); ?> - 
                                <?php echo $event->getName(); ?>  
                            </div>    
                        <?php endforeach; ?>
                   </td>
                <?php endforeach;?>

            </td>

            </tr>
       <?php endfor;?>

    </table>
 
    <?php require_once '../views/footer.php'; ?>