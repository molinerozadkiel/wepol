
    <div class="gliter_car">

      <?php
      $term = get_category_by_slug('aumentar-participacion');
      ?>
      <h3><?php echo $term->name; ?></h3>
      <?php
      $i=15;
      $args = array(
        'posts_per_page' => 3,
        'category_name' => 'aumentar-participacion'
      );
      $posts = get_posts( $args );
      foreach ( $posts as $post ){ setup_postdata( $post );

        $arg = array(
          'color' => 'var(--brand_color_2)',
          'image' => "https://picsum.photos/600/40$i",
        );
        shiny_card($arg);
        $i +=1;
      } wp_reset_postdata(); ?>

    </div>
