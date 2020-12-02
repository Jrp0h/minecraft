<?php 
require_once "./includes/notification.php";
?>

<?php if(Notification::isAvailable()): ?>
    <?php $n = Notification::use(); ?>

    <div class="notification notification-<?php echo $n["type"] ?>" id="notification">
        <p><?php echo $n["message"]; ?></p>
	    <i class="fa fa-times" id="notification-close"></i>
    </div>
<?php endif; ?>
