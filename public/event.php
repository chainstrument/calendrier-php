<?php 

require_once '../src/bootstrap';
require_once '../src/Calendar/Events.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);

if(!isset($_GET['id']))
{
    header('location: /404.php');
}

try{
    $event = $events->find($_GET['id']);
}catch(\Exception() $e)
{
    e404();
}

require '../views/header.php';

?>

<h1><?php echo h($event->name); ?></h1>

<ul>
    <li>Date <?php echo $event->getStart()->format('d/m/y'); ?></li>
    <li>Heure de demarage <?php echo $event->getStart()->format('H:i'); ?></li>
    <li>Heure de fin <?php echo $event->getEnd()->format('H:i'); ?></li>
    <li>Description <?php echo $event->description(); ?></li>

</ul>