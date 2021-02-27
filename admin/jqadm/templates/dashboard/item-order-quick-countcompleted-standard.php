<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021
 */

$enc = $this->encoder();


?>
<div class="quick order-quick-countcompleted col-sm-6 col-xl-3"
	title="<?= $enc->attr( $this->translate( 'admin', 'Completed orders within the last seven days compared to the period before' ) ) ?>">
	<div class="box row">
		<div class="col quick-left">
			<div class="quick-number">0</div>
		</div>
		<div class="col quick-right">
			<div class="quick-percent"></div>
		</div>
		<div class="col-xs-12">
			<h2 class="quick-header"><?= $enc->html( $this->translate( 'admin', 'Completed orders' ) ) ?></h2>
			<div class="quick-progress"><div class="quick-length"></div></div>
		</div>
	</div>
</div>
<?= $this->get( 'quickCountcompletedBody' ); ?>
