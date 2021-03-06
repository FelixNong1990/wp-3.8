		</div>
	</div>
	<?php global $data; ?>
	<?php if(!is_page_template('blank.php')): ?>
	<?php if( ($data['footer_widgets'] && get_post_meta($post->ID, 'pyre_display_footer', true) != 'no') ||
			  ( ! $data['footer_widgets'] && get_post_meta($post->ID, 'pyre_display_footer', true) == 'yes') ): ?>
	<footer class="footer-area">
		<div class="avada-row">
			<section class="columns columns-<?php echo $data['footer_widgets_columns']; ?>">
				<article class="col">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 1')):
				endif;
				?>
				</article>

				<article class="col">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 2')):
				endif;
				?>
				</article>

				<article class="col">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 3')):
				endif;
				?>
				</article>

				<article class="col last">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 4')):
				endif;
				?>
				</article>
			</section>
		</div>
	</footer>
	<?php endif; ?>
	<?php if( ($data['footer_copyright'] && get_post_meta($post->ID, 'pyre_display_copyright', true) != 'no') ||
			  ( ! $data['footer_copyright'] && get_post_meta($post->ID, 'pyre_display_copyright', true) == 'yes') ): ?>
	<footer id="footer">
		<div class="avada-row">
		<?php if($data['icons_footer']): ?>
		<?php
		if($data['icons_footer_new']) {
			$target = '_blank';
		} else {
			$target = '_self';
		}
		if(!$data['footer_icons_color']) {
			$footer_icons_color = 'Dark';
		} else {
			$footer_icons_color = $data['footer_icons_color'];
		}

		$nofollow = '';
		if($data['nofollow_social_links']) {
			$nofollow = ' rel="nofollow"';
		}
		?>
		<ul class="social-networks social-networks-<?php echo strtolower($footer_icons_color); ?>">
			<?php if($data['facebook_link']): ?>
			<li class="facebook"><a target="<?php echo $target; ?>" href="<?php echo $data['facebook_link']; ?>"<?php echo $nofollow; ?>>Facebook</a>
				<div class="popup">
					<div class="holder">
						<p>Facebook</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['twitter_link']): ?>
			<li class="twitter"><a target="<?php echo $target; ?>" href="<?php echo $data['twitter_link']; ?>"<?php echo $nofollow; ?>>Twitter</a>
				<div class="popup">
					<div class="holder">
						<p>Twitter</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['linkedin_link']): ?>
			<li class="linkedin"><a target="<?php echo $target; ?>" href="<?php echo $data['linkedin_link']; ?>"<?php echo $nofollow; ?>>LinkedIn</a>
				<div class="popup">
					<div class="holder">
						<p>LinkedIn</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['rss_link']): ?>
			<li class="rss"><a target="<?php echo $target; ?>" href="<?php echo $data['rss_link']; ?>"<?php echo $nofollow; ?>>RSS</a>
				<div class="popup">
					<div class="holder">
						<p>RSS</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['dribbble_link']): ?>
			<li class="dribbble"><a target="<?php echo $target; ?>" href="<?php echo $data['dribbble_link']; ?>"<?php echo $nofollow; ?>>Dribbble</a>
				<div class="popup">
					<div class="holder">
						<p>Dribbble</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['youtube_link']): ?>
			<li class="youtube"><a target="<?php echo $target; ?>" href="<?php echo $data['youtube_link']; ?>"<?php echo $nofollow; ?>>Youtube</a>
				<div class="popup">
					<div class="holder">
						<p>Youtube</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['pinterest_link']): ?>
			<li class="tf-pinterest"><a target="<?php echo $target; ?>" href="<?php echo $data['pinterest_link']; ?>" class="pinterest"<?php echo $nofollow; ?>>Pinterest</a>
				<div class="popup">
					<div class="holder">
						<p>Pinterest</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['flickr_link']): ?>
			<li class="flickr"><a target="<?php echo $target; ?>" href="<?php echo $data['flickr_link']; ?>" class="flickr"<?php echo $nofollow; ?>>Flickr</a>
				<div class="popup">
					<div class="holder">
						<p>Flickr</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['vimeo_link']): ?>
			<li class="vimeo"><a target="<?php echo $target; ?>" href="<?php echo $data['vimeo_link']; ?>" class="vimeo"<?php echo $nofollow; ?>>Vimeo</a>
				<div class="popup">
					<div class="holder">
						<p>Vimeo</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['tumblr_link']): ?>
			<li class="tumblr"><a target="<?php echo $target; ?>" href="<?php echo $data['tumblr_link']; ?>" class="tumblr"<?php echo $nofollow; ?>>Tumblr</a>
				<div class="popup">
					<div class="holder">
						<p>Tumblr</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['google_link']): ?>
			<li class="google"><a target="<?php echo $target; ?>" href="<?php echo $data['google_link']; ?>" class="google"<?php echo $nofollow; ?>>Google+</a>
				<div class="popup">
					<div class="holder">
						<p>Google</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['digg_link']): ?>
			<li class="digg"><a target="<?php echo $target; ?>" href="<?php echo $data['digg_link']; ?>" class="digg"<?php echo $nofollow; ?>>Digg</a>
				<div class="popup">
					<div class="holder">
						<p>Digg</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['blogger_link']): ?>
			<li class="blogger"><a target="<?php echo $target; ?>" href="<?php echo $data['blogger_link']; ?>" class="blogger"<?php echo $nofollow; ?>>Blogger</a>
				<div class="popup">
					<div class="holder">
						<p>Blogger</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['skype_link']): ?>
			<li class="skype"><a target="<?php echo $target; ?>" href="<?php echo $data['skype_link']; ?>" class="skype"<?php echo $nofollow; ?>>Skype</a>
				<div class="popup">
					<div class="holder">
						<p>Skype</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['myspace_link']): ?>
			<li class="myspace"><a target="<?php echo $target; ?>" href="<?php echo $data['myspace_link']; ?>" class="myspace"<?php echo $nofollow; ?>>Myspace</a>
				<div class="popup">
					<div class="holder">
						<p>Myspace</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['deviantart_link']): ?>
			<li class="deviantart"><a target="<?php echo $target; ?>" href="<?php echo $data['deviantart_link']; ?>" class="deviantart"<?php echo $nofollow; ?>>Deviantart</a>
				<div class="popup">
					<div class="holder">
						<p>Deviantart</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['yahoo_link']): ?>
			<li class="yahoo"><a target="<?php echo $target; ?>" href="<?php echo $data['yahoo_link']; ?>" class="yahoo"<?php echo $nofollow; ?>>Yahoo</a>
				<div class="popup">
					<div class="holder">
						<p>Yahoo</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['reddit_link']): ?>
			<li class="reddit"><a target="<?php echo $target; ?>" href="<?php echo $data['reddit_link']; ?>" class="reddit"<?php echo $nofollow; ?>>Reddit</a>
				<div class="popup">
					<div class="holder">
						<p>Reddit</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['forrst_link']): ?>
			<li class="forrst"><a target="<?php echo $target; ?>" href="<?php echo $data['forrst_link']; ?>" class="forrst"<?php echo $nofollow; ?>>Forrst</a>
				<div class="popup">
					<div class="holder">
						<p>Forrst</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($data['custom_icon_name'] && $data['custom_icon_link'] && $data['custom_icon_image']): ?>
			<li class="custom"><a target="<?php echo $target; ?>" href="<?php echo $data['custom_icon_link']; ?>"<?php echo $nofollow; ?>><img src="<?php echo $data['custom_icon_image']; ?>" alt="<?php echo $data['custom_icon_name']; ?>" /></a>
				<div class="popup">
					<div class="holder">
						<p><?php echo $data['custom_icon_name']; ?></p>
					</div>
				</div>
			</li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
			<ul class="copyright">
				<li><?php echo $data['footer_text'] ?></li>
			</ul>
		</div>
	</footer>
	<?php endif; ?>
	<?php endif; ?>
	</div><!-- wrapper -->
	<?php //include_once('style_selector.php'); ?>

	<?php if(!$data['status_gmap']): ?><script type="text/javascript" src="http<?php echo (is_ssl())? 's' : ''; ?>://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language=<?php echo substr(get_locale(), 0, 2); ?>"></script><?php endif; ?>

	<!-- W3TC-include-js-head -->

	<?php wp_footer(); ?>

	<?php echo $data['space_body']; ?>
</body>
</html>