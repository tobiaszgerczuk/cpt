{{--
  Template Name: Custom Template
--}}

@extends('layouts.app')

@section('content')
  <?php 
   $args = array(
	    	'post_type' => 'samochody',
	    );
	    $the_query = new WP_Query( $args ); 
      if ( $the_query->have_posts() ) {
    ?>
    <div class="cars">
    <?php
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
     ?>
      <div class="cars-car">
        <?php  if(get_field('plik_graficzny')) : ?>
          <img src="{{ get_field('plik_graficzny') }}" alt="">
        <?php endif; ?>
        <?php  if(get_field('marka')) : ?>
        <p><?php echo get_field('marka'); ?></p>
        <?php endif; ?>
        <?php  if(get_field('model')) : ?>
        <p><?php echo get_field('model'); ?></p>
        <?php endif; ?>
        <?php  if(get_field('rocznik')) : ?>
        <p><?php echo get_field('rocznik'); ?></p>

        <?php 
          $mechanicy = get_field('mechanicy');
   
          ?>
          <ul>
          <?php
          foreach ($mechanicy as $mechanik) {
            ?>
              <li><?php echo $mechanik['display_name']; ?></li>
            <?php
          }
          ?>
          </ul>
          <?php
        ?>
      <?php endif; ?>
      </div>
     <?php
    }
    ?>
    </div>
    <?php
    } else {

    }

  ?>

@endsection
