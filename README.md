#Hide Answers Plugin

For TinyMCE in Wordpress

##Synopsis

This is a simple Wordpress plugin that allows authors of posts and pages to
quickly add a hidden element and a reveal element on a page.  The hidden
element is revealed to visitors when they click on the reveal element.  This is
handy for pages with learning or tutorial content where the author wants to
"quiz" their visitors.

The hidden and reveal elements are generated by a custom button added to the
visual editor on the Admin Edit Page of Wordpress.

##Installation

1) Download the code in this repository into the plugins directory of your
Wordpress Installation
2) Place the following code in the `functions.php` file of your active theme:

```
function hide_answers_script() {
  wp_enqueue_script('hide_answers', plugins_url('tinymce-hide-answers') . '/js/hide-answers.js', array('jquery'), '', true);
}
add_action( 'wp_enqueue_scripts', 'hide_answers_script' );
```

3) Activate the plugin

##License

MIT License