<?php
/*
 * Copyright (C) joomla-monster.com
 * Website: http://www.joomla-monster.com
 * Support: info@joomla-monster.com
 *
 * JM Testimonials is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * JM Testimonials is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JM Testimonials. If not, see <http://www.gnu.org/licenses/>.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$ind_class = ( $show_indicators == '1' && $elements > 1 ) ? 'indicators' : '';

$i = 0;
$row = 0;
$itemID = $id . '-' . $row;

?>
<div id="<?php echo $id; ?>" class="jmm-testimonials carousel slide carousel-fade <?php echo $theme_class . ' ' . $ind_class . ' ' . $mod_class_suffix; ?>"<?php echo $autoplay; ?>>
	<div class="jmm-testimonials-in">
		<?php if( $show_indicators == '1' && $elements > 1 ) : 
			$visible = ceil($elements/$columns);
		?>
		<ol class="carousel-indicators" role="tablist" aria-label="<?php echo JText::_('MOD_JM_TESTIMONIALS_TESTIMONIAL_TABLIST_LABEL'); ?>">
			<?php for($n = 0; $n < $visible; $n++ ) {
				$class = ( $n == 0 ) ? ' class="active" aria-selected="true" tabindex="0"' : ' aria-selected="false" tabindex="-1"';
				$panelID = $id . '-' . $n;
			?>
			<li data-target="#<?php echo $id; ?>"<?php echo $class; ?> aria-controls="<?php echo $panelID; ?>" data-slide-to="<?php echo $n; ?>" role="tab">
				<span class="sr-only">
					<span class="name"><?php echo JText::_('MOD_JM_TESTIMONIALS_TESTIMONIAL_DESC'); ?></span>
					<span class="number"><?php echo ($n + 1); ?></span>
				</span>
			</li>
			<?php } ?>
		</ol>
		<?php endif; ?>
		<div class="jmm-rows <?php echo 'rows-' . $columns; ?> carousel-inner">
			<div id="<?php echo $itemID; ?>" class="jmm-row row-<?php echo $row; ?> item active" role="tabpanel" tabindex="0">
				<?php
				foreach($output_data as $item) :

				if($i % $columns == 0 && $i > 0) {
					$row++;
					$itemID = $id . '-' . $row;
					echo '</div><div id="' . $itemID . '" class="jmm-row row-' . $row . ' item" role="tabpanel" tabindex="-1">';
				}

				$i++;
			
				?>
				<div class="jmm-item item-<?php echo $i; ?>">
					<?php if ( !empty($item->text) || !empty($item->image) || !empty($item->author) || !empty($item->profession) ) { ?>
						<div class="jmm-text">
							<?php if ( !empty($item->image) ) { ?>
								<div class="jmm-image"><img src="<?php echo $item->image; ?>" alt="<?php echo JText::_('MOD_JM_TESTIMONIALS_IMAGE_ALT'); ?>"></div>
							<?php } ?>
							<?php if ( !empty($item->text) ) { ?>
								<div class="jmm-comment"><?php echo $item->text; ?></div>
							<?php } ?>
							<?php if ( !empty($item->author) ) { ?>
								<div class="jmm-author"><?php echo $item->author; ?></div>
							<?php } ?>
							<?php if ( !empty($item->profession) ) { ?>
								<div class="jmm-profession"><?php echo $item->profession; ?></div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
