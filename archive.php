<?php get_header(); ?>

<?php $term = get_queried_object(); ?>


<div class="front_head">
  <div class="container_al_pedo">
    <h1 class="front_head_title"><?php echo $term->name; ?></h1>
    <div class="front_head_deco"></div>
    <p class="front_head_subtitle">Descripción corta que sea coherente con el meta description de la web, consectetur adipiscing elit. Nulla luctus urna vel massa tristique commodo. Curabitur ut sagittis mi.</p>
  </div>
  <?php include 'assets/logo_squared_bg_white.svg' ?>
</div>



<div class="two_one">

  <div class="mateput"  data-cycle-container="blog">
    <input class="mateputInput Searcher" id="mateputNombre" type="text" name="nombre" autocomplete="off" required>
    <label for="mateputNombre" class="mateputLabel">
      <span class="mateputName">Buscar</span>
    </label>
  </div>
  <!-- para hacer un cyclo paginable filtrable y/o buscable -->
  <!-- el cyclo debe estar contenido en una etiqueta que SOLO contenga el cyclo -->
  <!-- colocar en esa etiqueta data-card y data-cycle -->
  <!-- en los argumentos del cyclo va 'cycle' => lo mismo que el cycle de la etiqueta -->
  <!-- agregar la variable a JS con localyze script con el mismo nombre -->
  <!-- colocar la tarjeta en multicards y llamarla con una funcion -->
  <div class="showcase2" data-card="simpla_card" data-cycle="blog">
    <?php

    $stickies = get_option( 'sticky_posts' );
    $args = array(
      'posts_per_page' => 1,
      'post__in'       => $stickies,
      'category__and'  => $term->term_id, //must use category id for this field
      'ignore_sticky_posts' => 1,
    );
    $blog=new WP_Query($args);
    while($blog->have_posts()){$blog->the_post();
      $arg = array(
        'image' => "https://picsum.photos/600/40$i",
        'classes' => 'featured post-'.get_the_ID(),
      );
      simpla_card($arg);
      $i+=1;
    } wp_reset_query();

    $args = array(
      'posts_per_page' => 10,
      'cycle' => 'blog',
      'post__not_in'   => $stickies,
      'category__and' => $term->term_id, //must use category id for this field
      'ignore_sticky_posts' => 1,
    );
    $blog=new WP_Query($args);
    wp_localize_script( 'main', 'blog', array('query'=>json_encode($blog->query_vars),) );
    while($blog->have_posts()){$blog->the_post();
      $arg = array(
        'image' => "https://picsum.photos/600/40$i",
        'classes' => "post-".get_the_ID(),
      );
      simpla_card($arg);
      $i+=1;
    } wp_reset_query();
    echo ajax_paginator_2($blog); ?>
  </div>




  <aside class="gliter"  data-cycle-container="blog">

    <?php include 'gliter_car.php'; ?>

    <!-- <h3>y mas cosas</h3> -->
  </aside>

</div>






<?php get_footer(); ?>
