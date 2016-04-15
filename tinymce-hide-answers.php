<?php

/**
 * Plugin Name: TinyMCE Hide Answers
 * Plugin URI: https://github.com/lumenlearning/tinymce_hide_answers
 * Version: 1.0
 * Author: Lumen Learning
 * Author URI: http://lumenlearning.com
 * Description: TinyMCE Plugin that adds Hide/Show Answer CSS class within the Visual Editor
 * License: MIT
 */

class TinyMCE_Hide_Answers {

  /**
   * Constructor: Called when the plugin is initialized.
   */
  function __construct() {

    if ( is_admin() ) {
      add_action( 'init', array( &$this, 'setup_plugin' ) );
    }
    add_shortcode( 'reveal-answer', array( &$this, 'reveal_answer_shortcode' ) );
    add_shortcode( 'hidden-answer', array( &$this, 'hidden_answer_shortcode' ) );

  }

  /**
   * Called by Constructor: Check if the current user can edit Posts or Pages, and is
   * using the Visual Editor. If so, add filters so we can register plugin.
   */
  function setup_plugin() {

    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
      return;
    }

    if ( get_user_option( 'rich_editing' ) !== 'true' ) {
      return;
    }

    add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
    add_filter( 'mce_buttons', array( &$this, 'add_tinymce_toolbar_button' ) );

  }

  /**
   * Called by setup_plugin(): Adds the Plugin JS file to the Visual Editor instance.
   *
   * @param array $plugin_array Array of registered TinyMCE Plugins
   * @return array Modified array of registered TinyMCE Plugins
   */
  function add_tinymce_plugin( $plugin_array ) {

    $plugin_array['hide_answer'] = plugin_dir_url( __FILE__ ) . 'tinymce-hide-answers.js';
    return $plugin_array;

  }

  /**
   * Called by setup_plugin(): Adds a button to the Visual Editor which users can
   * click to add a hide-answer CSS class.
   */
  function add_tinymce_toolbar_button( $buttons ) {

    array_push( $buttons, 'hide_answer' );
    return $buttons;

  }

  /**
   * Shortcode that wraps around text that, when clicked, will reveal the hidden answer.
   * Ex: [reveal-answer q="1"]Show Answer[/reveal-answer].
   */
  function reveal_answer_shortcode( $atts, $content = null ) {

    $wrapper_style = 'display: block';
    $show_answer_style = 'cursor: pointer';

    $atts = shortcode_atts(array(
     "q" => 'default 1'
    ), $atts);

   return '<div class="qa-wrapper" style="' . $wrapper_style . '"><span class="show-answer collapsed" style="' . $show_answer_style . '" data-target="q' . $atts['q'] . '">' . do_shortcode($content) . '</span>';

  }

  /**
   * Shortcode that wraps around text that hides the answer.
   * Ex: [hidden-answer a="1"]Show Answer[/hidden-answer].
   */
  function hidden_answer_shortcode( $atts, $content = null ) {

    $hidden_answer_style = 'display: none';

    $atts = shortcode_atts(array(
      "a" => 'default 1'
    ), $atts);

    return '<div id="q' . $atts['a'] . '" class="hidden-answer" style="' . $hidden_answer_style . '">' . do_shortcode($content) . '</div></div>';

  }

}

$tinymce_hide_answers = new TinyMCE_Hide_Answers;
