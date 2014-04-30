<?php
// Template Name: Full Width
get_header(); ?>
	<div id="content" class="full-width">
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<span class="vcard" style="display: none;"><span class="fn"><?php the_author_posts_link(); ?></span></span>
			<span class="updated" style="display: none;"><?php the_time('c'); ?></span>
			<?php global $data; if(!$data['featured_images_pages'] ): ?>
			<?php if($data['legacy_posts_slideshow']):
			$args = array(
			    'post_type' => 'attachment',
			    'numberposts' => $data['posts_slideshow_number']-1,
			    'post_status' => null,
			    'post_parent' => $post->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image',
				'exclude' => get_post_thumbnail_id()
			);
			$attachments = get_posts($args);
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(!$data['posts_slideshow']): ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php elseif(has_post_thumbnail() ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php else: ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment->ID, '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php else: ?>
			<?php
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(!$data['posts_slideshow']): ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php elseif(has_post_thumbnail() ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php else: ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php
					$i = 2;
					while($i <= $data['posts_slideshow_number']):
					$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'page');
					if($attachment_new_id):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment_new_id); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment_new_id); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; $i++; endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php endif; ?>
			<div class="post-content">
			<?php //echo do_shortcode('[rev_slider slider1] '); ?>
			<div class="tp-banner-container">
		<div class="tp-banner" >
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<ul>	<!-- SLIDE  -->
	<li data-transition="fade" data-slotamount="7" data-masterspeed="300" >
		<!-- MAIN IMAGE -->
		<img src="http://localhost/wp-3.8/wp-content/uploads/slide1.jpg"  alt="slide1"  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
		<!-- LAYERS -->

		<!-- LAYER NR. 1 -->
		<div class="tp-caption lfr"
			data-x="473"
			data-y="157" 
			data-speed="500"
			data-start="1300"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 2;"><img src="http://localhost/wp-3.8/wp-content/uploads/title1.png" alt="">
		</div>

		<!-- LAYER NR. 2 -->
		<div class="tp-caption lfr"
			data-x="477"
			data-y="230" 
			data-speed="500"
			data-start="1600"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 3;"><img src="http://localhost/wp-3.8/wp-content/uploads/subtitle1.png" alt="">
		</div>

		<!-- LAYER NR. 3 -->
		<div class="tp-caption tp-fade"
			data-x="0"
			data-y="69" 
			data-speed="600"
			data-start="2600"
			data-easing="easeInExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 4;"><img src="http://localhost/wp-3.8/wp-content/uploads/ice1.png" alt="">
		</div>

		<!-- LAYER NR. 4 -->
		<div class="tp-caption lfb"
			data-x="28"
			data-y="111" 
			data-speed="700"
			data-start="500"
			data-easing="easeInOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 5;"><img src="http://localhost/wp-3.8/wp-content/uploads/penguins.png" alt="">
		</div>

		<!-- LAYER NR. 5 -->
		<div class="tp-caption lft"
			data-x="32"
			data-y="27" 
			data-speed="400"
			data-start="1900"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;"><p style="color: #ffffff;">Lorem ipsum dolor sit amet, consectetur<br />
adipisicing elit, sed do eiusmod tempor incididunt <br />
ut labore et dolore magna aliqua. </p>
		</div>

		<!-- LAYER NR. 6 -->
		<div class="tp-caption lfr"
			data-x="642"
			data-y="177" 
			data-speed="500"
			data-start="3500"
			data-easing="easeOutBounce"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 7;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen1.png" alt="">
		</div>
	</li>
	<!-- SLIDE  -->
	<li data-transition="fade" data-slotamount="7" data-masterspeed="300" data-delay="8000" >
		<!-- MAIN IMAGE -->
		<img src="http://localhost/wp-3.8/wp-content/uploads/slide2.jpg"  alt="slide2"  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
		<!-- LAYERS -->

		<!-- LAYER NR. 1 -->
		<div class="tp-caption lfl"
			data-x="56"
			data-y="92" 
			data-speed="400"
			data-start="800"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 2;"><img src="http://localhost/wp-3.8/wp-content/uploads/monitor2.png" alt="">
		</div>

		<!-- LAYER NR. 2 -->
		<div class="tp-caption lfb"
			data-x="387"
			data-y="148" 
			data-speed="300"
			data-start="3900"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 3;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen2-3.png" alt="">
		</div>

		<!-- LAYER NR. 3 -->
		<div class="tp-caption lfb"
			data-x="539"
			data-y="100" 
			data-speed="300"
			data-start="3600"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 4;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen2-2.png" alt="">
		</div>

		<!-- LAYER NR. 4 -->
		<div class="tp-caption lfb"
			data-x="473"
			data-y="100" 
			data-speed="300"
			data-start="3300"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 5;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen2-1.png" alt="">
		</div>

		<!-- LAYER NR. 5 -->
		<div class="tp-caption tp-fade"
			data-x="0"
			data-y="61" 
			data-speed="500"
			data-start="500"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 6;"><img src="http://localhost/wp-3.8/wp-content/uploads/iceberg2.png" alt="">
		</div>

		<!-- LAYER NR. 6 -->
		<div class="tp-caption lfr"
			data-x="758"
			data-y="157" 
			data-speed="400"
			data-start="1200"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 7;"><img src="http://localhost/wp-3.8/wp-content/uploads/ipad.png" alt="">
		</div>

		<!-- LAYER NR. 7 -->
		<div class="tp-caption lfr"
			data-x="736"
			data-y="242" 
			data-speed="400"
			data-start="1600"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 8;"><img src="http://localhost/wp-3.8/wp-content/uploads/iphone.png" alt="">
		</div>

		<!-- LAYER NR. 8 -->
		<div class="tp-caption lfl"
			data-x="335"
			data-y="259" 
			data-speed="500"
			data-start="2000"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 9;"><img src="http://localhost/wp-3.8/wp-content/uploads/title2.png" alt="">
		</div>

		<!-- LAYER NR. 9 -->
		<div class="tp-caption lfl"
			data-x="493"
			data-y="337" 
			data-speed="500"
			data-start="2300"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 10;"><img src="http://localhost/wp-3.8/wp-content/uploads/subtitle2.png" alt="">
		</div>

		<!-- LAYER NR. 10 -->
		<div class="tp-caption tp-fade"
			data-x="351"
			data-y="255" 
			data-speed="600"
			data-start="4200"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 11;"><img src="http://localhost/wp-3.8/wp-content/uploads/ice2.png" alt="">
		</div>

		<!-- LAYER NR. 11 -->
		<div class="tp-caption lfl"
			data-x="70"
			data-y="221" 
			data-speed="600"
			data-start="5000"
			data-easing="easeOutBounce"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 12;"><img src="http://localhost/wp-3.8/wp-content/uploads/batman.png" alt="">
		</div>

		<!-- LAYER NR. 12 -->
		<div class="tp-caption lft"
			data-x="594"
			data-y="22" 
			data-speed="400"
			data-start="2600"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 13; max-width: auto; max-height: auto; white-space: nowrap;"><p style="color: #ffffff; text-align: right">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />
tempor incididunt ut labore et dolore magna aliqua</p>
		</div>
	</li>
	<!-- SLIDE  -->
	<li data-transition="fade" data-slotamount="7" data-masterspeed="300" data-delay="8000" >
		<!-- MAIN IMAGE -->
		<img src="http://localhost/wp-3.8/wp-content/uploads/slide3.jpg"  alt="slide3"  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
		<!-- LAYERS -->

		<!-- LAYER NR. 1 -->
		<div class="tp-caption tp-fade"
			data-x="-1"
			data-y="90" 
			data-speed="600"
			data-start="5000"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 2;"><img src="http://localhost/wp-3.8/wp-content/uploads/ice3-2.png" alt="">
		</div>

		<!-- LAYER NR. 2 -->
		<div class="tp-caption lfr"
			data-x="433"
			data-y="69" 
			data-speed="600"
			data-start="900"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 3;"><img src="http://localhost/wp-3.8/wp-content/uploads/monitor3.png" alt="">
		</div>

		<!-- LAYER NR. 3 -->
		<div class="tp-caption lfr"
			data-x="342"
			data-y="346" 
			data-speed="1000"
			data-start="600"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 4;"><img src="http://localhost/wp-3.8/wp-content/uploads/iceberg3.png" alt="">
		</div>

		<!-- LAYER NR. 4 -->
		<div class="tp-caption tp-fade"
			data-x="0"
			data-y="349" 
			data-speed="300"
			data-start="300"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 5;"><img src="http://localhost/wp-3.8/wp-content/uploads/icebergs.png" alt="">
		</div>

		<!-- LAYER NR. 5 -->
		<div class="tp-caption lfl"
			data-x="175"
			data-y="83" 
			data-speed="500"
			data-start="1600"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 6;"><img src="http://localhost/wp-3.8/wp-content/uploads/title3.png" alt="">
		</div>

		<!-- LAYER NR. 6 -->
		<div class="tp-caption lfl"
			data-x="84"
			data-y="156" 
			data-speed="500"
			data-start="1900"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 7;"><img src="http://localhost/wp-3.8/wp-content/uploads/subtitle3.png" alt="">
		</div>

		<!-- LAYER NR. 7 -->
		<div class="tp-caption tp-fade"
			data-x="500"
			data-y="86" 
			data-speed="500"
			data-start="2500"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
						data-autoplay="false"
			data-autoplayonlyfirsttime="false"
			style="z-index: 8;"><iframe src='http://player.vimeo.com/video/9884272?title=0&amp;byline=0&amp;portrait=0;api=1' width='448' height='252' style='width:448px;height:252px;'></iframe>
		</div>

		<!-- LAYER NR. 8 -->
		<div class="tp-caption lfl"
			data-x="332"
			data-y="282" 
			data-speed="400"
			data-start="3300"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 9;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen3-2.png" alt="">
		</div>

		<!-- LAYER NR. 9 -->
		<div class="tp-caption lfl"
			data-x="164"
			data-y="282" 
			data-speed="400"
			data-start="3700"
			data-easing="easeOutBack"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 10;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen3-2.png" alt="">
		</div>

		<!-- LAYER NR. 10 -->
		<div class="tp-caption lfl"
			data-x="232"
			data-y="262" 
			data-speed="600"
			data-start="4000"
			data-easing="easeOutBounce"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 11;"><img src="http://localhost/wp-3.8/wp-content/uploads/pen3-1.png" alt="">
		</div>

		<!-- LAYER NR. 11 -->
		<div class="tp-caption tp-fade"
			data-x="176"
			data-y="58" 
			data-speed="600"
			data-start="5000"
			data-easing="easeOutExpo"
			data-splitin="none"
			data-splitout="none"
			data-elementdelay="0"
			data-endelementdelay="0"
			style="z-index: 12;"><img src="http://localhost/wp-3.8/wp-content/uploads/ice3-1.png" alt="">
		</div>
	</li>
</ul>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		</div>
	</div>
				<?php //the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php if($data['comments_pages']): ?>
				<?php wp_reset_query(); ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>