<div class="wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>HBI Countdown Clock Options</h2>
 
    <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
    <?php settings_errors(); ?>
 
    <!-- Create the form that will be used to render our options -->
    <form method="post" action="options.php">
        <?php settings_fields( 'hbi_countdown_clock_settings' ); ?>
        <?php do_settings_sections( 'hbi_countdown_clock' ); ?>           
        <?php submit_button(); ?>
    </form>
</div>