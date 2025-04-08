<?php if ( post_password_required() ) return; ?>

<section id="comments" class="comments-area">

  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php echo get_comments_number() . ' Comentarios'; ?>
    </h2>

    <ol class="comment-list">
      <?php
        wp_list_comments( array(
          'style'      => 'ol',
          'short_ping' => true,
          'avatar_size'=> 50,
          'callback'   => null, // Usa callback solo si quieres control total del HTML.
        ) );
      ?>
    </ol>

    <?php the_comments_navigation(); ?>
  <?php endif; ?>

  <?php if ( comments_open() ) : ?>
    <div id="respond" class="comment-respond">
      <?php
        comment_form(array(
          'title_reply'         => 'Deja tu comentario',
          'comment_notes_before'=> '',
          'class_submit'        => 'btn-comment',
          'label_submit'        => 'Enviar comentario',
          'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="%3$s ajax-submit">%4$s</button>',
        ));
      ?>
    </div>
  <?php endif; ?>

</section>
