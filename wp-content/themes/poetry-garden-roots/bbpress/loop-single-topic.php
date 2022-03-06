<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
	<li class="bbp-topic-title">

		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>
        
        	<?php do_action( 'bbp_theme_before_topic_meta' ); ?>


		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>
        
        
		<?php do_action( 'bbp_theme_before_topic_title' ); ?>
        <div class="flex gap-2">
        <?php bbp_topic_author_link( array( 'sep' => '<br />', 'show_role' => false, 'type' => 'avatar' ) ); ?>
        <div>
        
		<p class="bbp-topic-meta mb-2">

			<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

			<span class="bbp-topic-started-by">Started by: <?php bbp_topic_author_link( array( 'sep' => '<br />', 'show_role' => false, 'type' => 'name' ) );  ?></span>

			<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

			<?php if ( ! bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

				<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>


				<span class="bbp-topic-started-in"><?php printf( esc_html__( 'in: %1$s', 'bbpress' ), '<a href="' . bbp_get_forum_permalink( bbp_get_topic_forum_id() ) . '">' . bbp_get_forum_title( bbp_get_topic_forum_id() ) . '</a>' ); ?></span>
				<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

			<?php endif; ?>

		</p>
		
		<a class="bbp-topic-permalink activity-title very-subtle" href="<?php bbp_topic_permalink(); ?>"><h4 class="mb-1"><?php bbp_topic_title(); ?></h4>
		<p>
		    <?php bbp_topic_excerpt(); ?>
		</p>
		</a>
			<p class="small"><a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>">
		    <?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); 
		    echo ' comment'; 
		    if (bbp_get_topic_reply_count() != '1') {echo 's';} ?>
		    </a> 
		    <?php 
		    if (bbp_get_topic_voice_count() > 0 and bbp_get_topic_reply_count() > 0) {
		        echo ' by '; ?>
		        <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>">
		        <?php
		        if (bbp_get_topic_voice_count() != 1) {
		            echo bbp_get_topic_voice_count().' people';
		        } else {
		            echo bbp_get_topic_voice_count().' person';
		        }
		        ?></a><?php
		    }
		    ?>
		</p>
		</div>
        </div>
		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<?php bbp_topic_pagination(); ?>


		<?php bbp_topic_row_actions(); ?>

	</li>

<!---	<li class="bbp-topic-voice-count"><?php bbp_topic_voice_count(); ?></li>

	<li class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></li>

	<li class="bbp-topic-freshness">

		<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

		<?php bbp_topic_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

			<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 14 ) ); ?></span>

			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

		</p>
	</li> --->
</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
