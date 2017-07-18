<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $count
 * @var $order
 * @var $order_by
 * @var $ids
 * @var $slidestoshow
 * @var $arrows
 * @var $dots
 * @var $centermode
 * @var $autoplay
 * @var $responsive
 * @var $singlespeaker
 * @var $showexcerpt
 * Shortcode class
 * @var $this WPBakeryShortCode_Cth_Speaker_Cpt
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$options = new stdClass;
if(!empty($slidestoshow)){
    $options->slidesToShow = (int)$slidestoshow;
}else{
    $options->slidesToShow = 6;
}
if($arrows == 'false'){
    $options->arrows = false;
}
if($dots == 'true'){
    $options->dots = true;
}
if($centermode == 'true'){
    $options->centerMode = true;
}
if($autoplay == 'true'){
    $options->autoplay = true;
}
if(!empty($responsive)){
    $options->responsive = array();
    $v_s = explode("|", $responsive);
    if(!empty($v_s)){
        foreach ($v_s as $vs_v) {
            $v_s_v = explode(":", $vs_v);
            $res = new stdClass;
            $res->breakpoint = (int)$v_s_v[0];
            $res->settings = new stdClass;
            if($arrows == 'false'){
                $res->settings->arrows = false;
            }
            if($dots == 'true'){
                $res->settings->dots = true;
            }
            if($centermode == 'true'){
                $res->settings->centerMode = true;
            }
            if($autoplay == 'true'){
                $res->settings->autoplay = true;
            }
            $res->settings->slidesToShow = (int)$v_s_v[1];
            $options->responsive[] = $res;
        }
    }
}


?>
<div class="speaker-slider <?php echo esc_attr($el_class );?>" data-slick='<?php echo json_encode($options);?>'>
    <?php 
    if(!empty($ids)){
        $ids = explode(",", $ids);
        $args = array(
            'post_type' => 'cth_speaker',
            'posts_per_page'=> $count,
            'post__in' => $ids,
            'order_by'=> $order_by,
            'order'=> $order,
        );
    }else{
        $args = array(
            'post_type' => 'cth_speaker',
            'posts_per_page'=> $count,
            'order_by'=> $order_by,
            'order'=> $order,
        );
    }

    $speakers = new WP_Query($args);

    if($speakers->have_posts()) : ?>

    <?php while($speakers->have_posts()) : $speakers->the_post(); ?>
        
        <div class="speaker-info">
        <?php if($singlespeaker == 'yes') :?>
        <a href="<?php the_permalink();?>" class="speaker_link">
        <?php endif;?>
            <?php 
            the_post_thumbnail( 'full', array('class'=>'img-responsive center-block') );

            the_title('<p class="speaker_name">','</p>' );

            $job = get_post_meta(get_the_ID(),'cth_speaker_job' , true );
            if(!empty($job)){
                echo '<span>'.esc_attr($job ).'</span>';
            }
            if($showexcerpt == 'yes'){
                the_excerpt();
            }
             ?>
        <?php if($singlespeaker == 'yes') :?>
        </a>
        <?php endif;?>
        </div>

    <?php endwhile;?>

    <?php endif;?>

    <?php wp_reset_postdata();?>

</div>