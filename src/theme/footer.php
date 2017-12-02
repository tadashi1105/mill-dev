<footer class="footer">
	<section class="categories">
		<ul>
			<?php 
				$get_parent_cats = array(
					'parent' => '0' //get top level categories only
				); 

				$all_categories = get_categories( $get_parent_cats );//get parent categories 

				foreach( $all_categories as $single_category ){
					//for each category, get the ID
					$catID = $single_category->cat_ID;

					echo '<li data-aos="slow-categories" data-aos-offset="0"><h2>' . $single_category->name . '</h2>'; //category name & link
						echo '<ul class="post-title">';

					$query = new WP_Query( array( 'cat'=> $catID, 'posts_per_page'=>-1 ) );
					while( $query->have_posts() ):$query->the_post();
						echo '<li data-aos="slow-categories" data-aos-offset="0"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
					endwhile;
					wp_reset_postdata();

					echo '</ul>';
					$get_children_cats = array(
						'child_of' => $catID //get children of this parent using the catID variable from earlier
					);

					$child_cats = get_categories( $get_children_cats );//get children of parent category
					echo '<ul class="children">';
						foreach( $child_cats as $child_cat ){
							//for each child category, get the ID
							$childID = $child_cat->cat_ID;

							//for each child category, give us the link and name
							echo '<a href=" ' . get_category_link( $childID ) . ' ">' . $child_cat->name . '</a>';

								echo '<ul class="post-title">';

							$query = new WP_Query( array( 'cat'=> $childID, 'posts_per_page'=>-1 ) );
							while( $query->have_posts() ):$query->the_post();
								echo '<li data-aos="slow-categories" data-aos-offset="0"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
							endwhile;
							wp_reset_postdata();

							echo '</ul>';

						}
					echo '</ul></li>';
				} //end of categories logic 
			?>
		</ul>
	</section>

	<section class="riangle">
		<a href="https://www.riangle.com/" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/img/riangle.svg" alt="Riangle 🔺">
		</a>
		<p>
			<span>Powered by <strong><a href="https://www.riangle.com/" target="_blank">Riangle</a href=""></strong>. <?php bloginfo('name'); ?></span> - &copy; <?php echo date('Y');?></p>
		</p>
	</section>

</footer>
<?php wp_footer(); ?>
</body>
</html>