<?php if($transaction->activity_title == 'Payment Sent'): ?>

	<?php echo e($transaction->activity_title); ?> <br><span class="text-primary"><?php echo e(__('To')); ?> <?php echo e($transaction->entity_name); ?></span>

<?php elseif($transaction->activity_title == 'Payment Received'): ?>

	<?php echo e($transaction->activity_title); ?> <br><span class="text-primary"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></span>

<?php elseif($transaction->activity_title == 'Voucher Load'): ?>

	<?php echo e($transaction->entity_name); ?> <br><span class="text-primary"> <?php echo e(__('Voucher Load')); ?></span>

<?php elseif($transaction->activity_title == 'Voucher Generation'): ?>

	<?php echo e($transaction->entity_name); ?> <br><span class="text-primary"> <?php echo e(__('Voucher Generation')); ?></span>

<?php elseif($transaction->activity_title == 'Added Voucher to system'): ?>

	<?php echo e($transaction->entity_name); ?> <br><span class="text-primary"> <?php echo e(__('Added Voucher to system')); ?></span>

<?php elseif($transaction->activity_title == 'Purchase'): ?>

	<?php echo e($transaction->activity_title); ?> <br><span class="text-primary"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></span>

<?php elseif($transaction->activity_title == 'Sale'): ?>

	<?php echo e($transaction->activity_title); ?> <br><span class="text-primary"><?php echo e(__('In')); ?> <?php echo e($transaction->entity_name); ?> </span>

<?php elseif($transaction->activity_title == 'Withdrawal'): ?>

	<?php echo e($transaction->activity_title); ?> <?php echo e(__('From')); ?> <?php echo e(setting('site.title')); ?> <?php echo e(__('to')); ?><br><span class="text-primary"><?php echo e(Auth::user()->name); ?> <?php echo e($transaction->entity_name); ?> <?php echo e(__('Account')); ?></span>

<?php elseif($transaction->activity_title == 'Deposit'): ?>

	<?php echo e($transaction->activity_title); ?> <?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?> <?php echo e(__('Account')); ?>  <?php echo e(__('to')); ?><br><span class="text-primary"><?php echo e(Auth::user()->name); ?> <?php echo e(setting('site.title')); ?></span>

<?php elseif($transaction->activity_title == 'Currency Exchange'): ?>

	<?php echo e($transaction->activity_title); ?> <br><span class="text-primary"> <?php if($transaction->money_flow == '+'): ?> <?php echo e(__('Exchanged To')); ?> 	
<?php else: ?> <?php echo e(__('Exchanged From')); ?> <?php endif; ?> <?php echo e($transaction->entity_name); ?></span>

<?php endif; ?>
