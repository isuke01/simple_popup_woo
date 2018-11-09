<?php
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );


function isu_popup_add_submenu() {
    add_management_page(
        __('Simple popup', 'isu_pop'), 
        __('Simple popup', 'isu_pop'),
        'administrator', 
        'isu-popup', 
        'isu_popup_settings_views'
    );
}
function isu_register_mysettings_popup(){
    register_setting( 'isu_popup_options', 'isu_popup' );

}
add_action( 'admin_menu', 'isu_popup_add_submenu' );
add_action( 'admin_init', 'isu_register_mysettings_popup' );


function isu_popup_settings_views() {
    $opt = get_option('isu_popup');

    $auto_trigger = ( isset($opt['auto_trigger']) && $opt['auto_trigger'] === 'true' )? 'true' : 'false';
    $uniqid = ( isset($opt['uid']) && $opt['uid'] != '' )? $opt['uid'] : uniqid();
    $title = ( isset($opt['title']) && $opt['title'] != '' )? $opt['title'] : __('Hold deg oppdatert', 'isu_pop');
    $btn_title = ( isset($opt['button_title']) && $opt['button_title'] != '' )? $opt['button_title'] : __('Meld på nyhetsbrev', 'isu_pop');

    $content = ( isset($opt['html']) && $opt['html'] != '' )? $opt['html'] : '';
    ?>
    <div  class="wrap">
        <h1><?php _e('Simple popup', 'isu_pop') ?></h1>
        <div id="isu_pop">
            <p>The popup shortcode <code>simple_pop_single</code> <br/>
            ATTRS: <b>button - text</b>,<b>incons - bool</b>
            </p>
            <?php 
            if ( function_exists( 'pll_register_string' ) ): ?>
                <h4><?php _e('Polylang Translation', 'isu_pop') ?></h4>
                <p><?php _e('First set settings, then go to Polylang Language strings, and you can filter by <b>isu_pop</b> and then you can translate all strings that you enter below.', 'isu_pop') ?></p>
                <a style="background-color: #4CAF50; text-shadow: 1px 1px 1px green; border-color: green" class="button button-primary" href="<?php echo esc_url( get_admin_url(null, 'admin.php?page=mlang_strings&s&group=isu_co&paged=1&paged=1') ) ?>"><?php echo __('Polylang translations', 'isu_pop') ?></a>
                <hr/>
                
            <?php 
            endif;
            ?>
            <form action="options.php" method="post">
                <?php settings_fields( 'isu_popup_options' ); ?>
                <?php do_settings_sections( 'isu_popup_options' ); ?>
                <table class="form-table">
                    <tr valign="top">   
                        <th scope="row"><?php _e('Auto single trigger', 'isu_pop') ?></th>
                        <td><input  type="checkbox" name="isu_popup[auto_trigger]" value="true" <?php echo ( $auto_trigger === 'true' )? 'checked' : '' ?>/></td>
                    </tr>
                    <tr valign="top">   
                        <th scope="row">
                            <p><?php _e('Unique ID of form', 'isu_pop') ?></p>
                            <small><?php _e('Uid is used for auto trigger popup, you can change it if you want force popup again for all users', 'isu_pop') ?></small>
                        </th>
                        <td><input style="min-width: 80%" type="text" name="isu_popup[uid]" value="<?php echo esc_attr( $uniqid ); ?>" /></td>
                    </tr>
                    <tr valign="top">   
                        <th scope="row"><?php _e('Title', 'isu_pop') ?></th>
                        <td><input style="min-width: 80%" type="text" name="isu_popup[title]" value="<?php echo esc_attr( $title ); ?>" /></td>
                    </tr>
                    <tr valign="top">   
                        <th scope="row"><?php _e('Button title', 'isu_pop') ?></th>
                        <td><input style="min-width: 80%" type="text" name="isu_popup[button_title]" value="<?php echo esc_attr( $btn_title ); ?>" /></td>
                    </tr>  
                    <tr valign="top">
                        <th scope="row"><?php _e('Popup content', 'isu_pop') ?></th>
                        <td>
                        <?php
                            wp_editor( $content , 'pop_html', array(
                                'wpautop'       => true,
                                'textarea_name' => 'meta_pop_html',
                                'textarea_rows' => 6,
                                'teeny'         => true,
                                'media_buttons' => false,
                                'textarea_name' => 'isu_popup[html]',
                            ) );
                        ?>

                        </td>
                    </tr>



                   
                </table>
    
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
    <script type="script/text">

    </script>
    <?php

}