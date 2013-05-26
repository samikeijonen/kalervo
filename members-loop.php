							<?php $users = get_users( apply_filters( 'kalervo_members_loop_args', array( 'who' => 'authors' ) ) ); ?>

							<?php foreach ( $users as $author ) : ?>

								<?php $id = $author->ID; ?>

								<div id="hcard-<?php echo str_replace( ' ', '-', get_the_author_meta( 'user_nicename', $id ) ); ?>" class="author-profile vcard clear">

									<h2 class="author-name fn n">
										<a href="<?php echo get_author_posts_url( $id ); ?>" title="<?php the_author_meta( 'display_name', $id ); ?>"><?php the_author_meta( 'display_name', $id ); ?></a>
									</h2>

									<a href="<?php echo get_author_posts_url( $id ); ?>" title="<?php the_author_meta( 'display_name', $id ); ?>">
										<?php echo get_avatar( get_the_author_meta( 'user_email', $id ), '100', '', get_the_author_meta( 'display_name', $id ) ); ?>
									</a>

									<?php echo wpautop( get_the_author_meta( 'description', $id ) ); ?>

									<p class="kalervo-social">
										<?php if ( $twitter = get_the_author_meta( 'twitter', $id ) ) { ?>
											<a class="twitter" href="<?php echo esc_url( "http://twitter.com/{$twitter}" ); ?>" title="<?php printf( esc_attr__( '%s on Twitter', 'kalervo' ), get_the_author_meta( 'display_name', $id ) ); ?>"><span class="kalervo-social-text"><?php _e( 'Twitter', 'kalervo' ); ?></span></a>
										<?php } ?>

										<?php if ( $facebook = get_the_author_meta( 'facebook', $id ) ) { ?>
											<a class="facebook" href="<?php echo esc_url( $facebook ); ?>" title="<?php printf( esc_attr__( '%s on Facebook', 'kalervo' ), get_the_author_meta( 'display_name', $id ) ); ?>"><span class="kalervo-social-text"><?php _e( 'Facebook', 'kalervo' ); ?></span></a>
										<?php } ?>

										<?php if ( $google_plus = get_the_author_meta( 'google_plus', $id ) ) { ?>
											<a class="google-plus" href="<?php echo esc_url( $google_plus ); ?>" title="<?php printf( esc_attr__( '%s on Google+', 'kalervo' ), get_the_author_meta( 'display_name', $id ) ); ?>" rel="me"><span class="kalervo-social-text"><?php _e( 'Google+', 'kalervo' ); ?></span></a>
										<?php } ?>

										<a class="feed" href="<?php echo esc_url( get_author_feed_link( $id ) ); ?>" title="<?php printf( esc_attr__( 'Subscribe to the feed for %s', 'kalervo' ), get_the_author_meta( 'display_name', $id ) ); ?>"><span class="kalervo-social-text"><?php _e( 'Subscribe', 'kalervo' ); ?></span></a>
									</p><!-- .kalervo-social -->

								</div><!-- .author-profile .vcard -->

							<?php endforeach; ?>