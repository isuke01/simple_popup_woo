<?php
/*
Plugin Name: Isu simple popup
Plugin URI:
Description: Simple popup plugin, that allow you put html content in it.
Version:     1.0.1
Author:      Łukasz Biedroń
Author URI:  isuke.pl
Text Domain: isu_pop
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );


register_activation_hook( __FILE__,  'isu_popup_plugin_activate'); //activate hook
function isu_popup_plugin_activate(){

}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'isu_popup_action_links' );

function isu_popup_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'tools.php?page=isu-popup') ) .'">'.__('Settings', 'isu_pop').'</a>';
   return $links;
}

function isu_popup_init_plugin() {
    $plugin_data = get_plugin_data(  __FILE__ , true,  true );
    define( 'ISU_POPUP_ABSP', plugin_dir_path(  __FILE__ ) );
    define( 'ISU_POPUP_URL', plugin_dir_url(  __FILE__ ) );
    define( 'ISU_POPUP_VER', $plugin_data['Version'] );

    load_plugin_textdomain( 'isu_pop', false, ISU_POPUP_ABSP.'languages/' );

    if ( function_exists( 'pll_register_string' ) ) {
       pll_register_string( 'isu_popup_html', get_option('isu_popup')['html'], 'isu_pop', true );
    }

    if (is_admin() ){
        require_once( ISU_POPUP_ABSP . 'admin/options-views.php');
    }else{
            //add_action('wp_enqueue_scripts', 'isu_cookie_register_scripts_and_styles', 10);
            //add_action('wp_footer', 'isu_popup_add_this_script_footer', 99);

    }
}
add_action('init', 'isu_popup_init_plugin', 20);


function isu_popup_code( $atts ) {
    if(is_admin()) return;
    
    $opt = get_option('isu_popup');

    $content = ( isset($opt['html']) && $opt['html'] != '' )? $opt['html'] : '';
    $atr = shortcode_atts( array(
        //'id' => null,
        'button' => 'Subscribe to our newsletter',
        'title' => 'Subscribe to our newsletter',
        'incons' => true,
    ), $atts );
/*     if(!$atr['id'] && is_user_logged_in()) return '<code style="padding: 6px 9px; background-color: #FF8A65; border-radius: 3px; color: #fff; margin: 10px">Form ID is required</code>';
    if(!$atr['id'] && !is_user_logged_in()) return ''; */
    ob_start();
    ?>
    <style type="text/css">
    #mc4_popup_simple #mc4_popup_body .mc4_popup_inner{
            background-color: #5F9992;
            width: 600px;
            height: 781px;
            overflow-y: visible;
        }
        #mc4_popup_simple #mc4_popup_body .mc4_popup_inner iframe{
            width: 100%;
            height: 100%;
        }
        #mc4_popup_body{
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
           top: 0;
           bottom:0;
           left: 0;
           right: 0;
           z-index: 999;
           z-index: 9999;
           opacity: 0;
           visibility: hidden;
            transition: 0.15s ease-in-out;
        }
        #mc4_popup_body.showMe{
            opacity: 1;
            visibility: visible;
       }
       #mc4_popup_body .mc4_popup_inner{
           overflow-y: auto;
            z-index: 2;
            width: 480px;
            max-width: 95%;
            max-height: 95%;
            position: relative;
            background: #fff;
            padding: 15px;
            width: 600px;
            height: 781px;
            overflow-y: visible;
       }
       #mc4_popup_body .mc4_popup_inner .close_me{
            border: none;
            box-shadow: none;
            color: #fff;
            background-color: transparent;
            position: absolute;
            right: 0;
            top: -35px;
            cursor: pointer;
       }
       #mc4_popup_body .mc4_popup_inner .close_me span{
           margin-right: 0;
           margin-right: 11px;
            font-weight: 300;
       }
       #mc4_popup_body .mc4_popup_inner form{
           margin-bottom: 0;
       }
       #mc4_popup_body .mc4wp-form-fields{

       }
       #mc4_popup_body .popup_overlay{
           z-index: 1;
           position: absolute;
            top: 0;
            bottom:0;
            left: 0;
            right: 0;
            background-color: rgba(21,38,52, 0.6);
            cursor: pointer;
       }
       #mc4_popup_body .mc4_popup_inner form input{
           border-radius: 0;
       }
       #mc4_popup_simple button.showMe span{
           padding-right:  80px;
           padding-left:  15px;
       }

       #mc4_popup_simple button.showMe{
           display: flex;
           cursor: pointer;
           padding: 12px 20px;
           margin: 0 auto;
           align-items: center;
           font-weight: 300;
           border: 2px solid #657079;
           box-shadow: none;
           border-radius: 0;
            color: #fff;
            background-color: #364550;
       }
       #mc4_popup_body .mc4_title{
                font-size: 22x;
        }
        #mc4_popup_simple #mc4_popup_body .mc4_popup_inner iframe{
                width: 100%;
                height: 100%;
            }
       @media all and (max-width: 767px){
            #mc4_popup_body .mc4_popup_inner .close_me{
                position: sticky;
                right: 0;
                left: 0;
                width: 100%;
                width: calc(100% + 32px);
                top: 0px;
                display: block;
                margin-top: -15px;
                margin-left: -16px;
                margin-right: -16px;
                z-index: 20;
                background: #3F51B5;
                padding: 4px 10px;
                cursor: pointer;
            }
            #mc4_popup_body .mc4_title{
                font-size: 18px;
            }
            #mc4_popup_simple button.showMe{
                padding: 10px 15px;
            }
            #mc4_popup_simple button.showMe span{
                padding-right:  0px;
                padding-left:  8px;
                font-size: 14px;
            }
            #mc4_popup_simple button.showMe svg {
                transform: scale(0.8);
            }
            #mc4_popup_simple button.showMe svg.arrow {
                display: none;
            }
        }
        #mc4_popup_body{
            z-index: -1 !important;
        }

        #mc4_popup_body.showMe{
            z-index: 99999 !important;
            padding: 15px !important;
        }
        #mc4_popup_simple #mc4_popup_body .mc4_popup_inner{
        overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
        }
        @media (max-width: 767px){
        #mc4_popup_simple #mc4_popup_body .mc4_popup_inner{
            max-width: 100%;
            width: 100%;
            height: auto;
        }
            #mc4_popup_body .mc4_popup_inner{
                padding: 0 !important;
            }
            #mc4_popup_body .mc4_popup_inner .close_me{
                margin-left: 0 !important;
            }
        }
    </style>

    <div id="mc4_popup_simple" class="mc4_popup_simple">
        <button class="showMe">
            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="20"><g fill="#FFF" fill-rule="nonzero"><path d="M4.4 6.055c.316.223 1.269.886 2.86 1.988 1.59 1.102 2.808 1.95 3.655 2.546.093.065.29.207.592.426.303.218.554.395.754.53.2.135.441.286.725.453.284.167.551.293.802.376.252.084.484.126.698.126h.028c.214 0 .447-.042.698-.126.25-.083.518-.209.802-.376.283-.167.525-.318.725-.453.2-.135.451-.312.754-.53.302-.22.5-.36.593-.426l6.528-4.534a6.628 6.628 0 0 0 1.702-1.716c.456-.67.684-1.372.684-2.107 0-.614-.221-1.14-.663-1.576A2.156 2.156 0 0 0 24.767 0H4.233C3.516 0 2.965.242 2.58.725 2.193 1.21 2 1.814 2 2.54c0 .586.256 1.221.767 1.905.512.683 1.056 1.22 1.633 1.611z"/><path d="M26.715 6.337c-3.355 2.276-5.903 4.044-7.642 5.305a36.21 36.21 0 0 1-1.42 1.006c-.363.241-.846.487-1.45.738-.603.252-1.165.377-1.687.377h-.031c-.522 0-1.085-.125-1.688-.377-.604-.25-1.087-.497-1.45-.738-.364-.24-.837-.576-1.42-1.006C8.546 10.627 6.004 8.859 2.3 6.337A8.133 8.133 0 0 1 .75 5v12.207c0 .676.24 1.255.721 1.737.481.482 1.06.723 1.734.723h22.59c.675 0 1.253-.241 1.734-.723a2.37 2.37 0 0 0 .721-1.737V5c-.44.492-.951.938-1.535 1.337z"/></g></svg>
            <span><?php echo $atr['button'] ?></span>
            <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="26" height="20"><path fill="#FFF" fill-rule="nonzero" d="M25.223 10.195a.526.526 0 0 0-.115-.574L15.635.148a.526.526 0 0 0-.745.744l8.576 8.576H.526a.526.526 0 0 0 0 1.052h22.94l-8.574 8.575a.526.526 0 0 0 .73.757l9.487-9.486a.528.528 0 0 0 .114-.17z"/></svg>
        </button>

        <div id="mc4_popup_body">
            <div class="mc4_popup_inner">
                <button class="close_me">
                    <span>Lukk</span>
                    <svg width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <g id="Nye-sider" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Visning-av-påmeldingsskjema" transform="translate(-970.000000, -219.000000)" fill="#FFFFFF" fill-rule="nonzero"> <g id="Group-3" transform="translate(910.000000, 215.000000)"> <g id="cross" transform="translate(60.000000, 4.000000)"> <polygon id="Shape" points="20 1.17660131 18.8405556 0.0197058824 10 8.84339869 1.15941176 0.0197058824 0 1.17660131 8.84058824 10.0003595 0 18.8234314 1.15941176 19.9802941 10 11.1572222 18.8405556 19.9802941 20 18.8234314 11.1587908 10.0003595"></polygon> </g> </g> </g> </g> </svg>
                </button>
                <div id="mc4_popup_content" style="height: 100%; width: 100%;"></div>
                <script type="text/html" id="mc4_popup_iframe">
                    <?php echo $content ?>
                </script>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>

    <?
    $html = ob_get_clean();
    add_action('wp_footer', 'add_this_script_footer_is_pop');
    return $html;
}
add_shortcode( 'simple_pop_single', 'isu_popup_code' );

function add_this_script_footer_is_pop(){
    ob_start();
    ?>
    <script type="text/javascript" >
            document.addEventListener("DOMContentLoaded", function(event){
            function getCookie_POP(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for(var i = 0; i <ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
            function setCookie_POP(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                var expires = "expires="+ d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
            jQuery('#mc4_popup_simple button.showMe').on('click', function(e){
                jQuery('#mc4_popup_body').toggleClass('showMe');
                if(!jQuery('#mc4_popup_body #mc4_popup_content').hasClass('inserted')){
                    var iframeHtml = jQuery('#mc4_popup_body #mc4_popup_iframe').html() ;
                    jQuery('#mc4_popup_body #mc4_popup_content').html(iframeHtml).addClass('inserted');
                }
                jQuery('body').toggleClass('showMC4Popup');
            })

            jQuery('#mc4_popup_body .close_me').on('click', function(e){
                if( jQuery('#mc4_popup_body').hasClass('showMe') ){
                    jQuery('#mc4_popup_simple button.showMe').click();
                }
            });

            jQuery('#mc4_popup_body .popup_overlay').on('click', function(e){
                if( jQuery('#mc4_popup_body').hasClass('showMe') ){
                    jQuery('#mc4_popup_simple button.showMe').click();
                }
            });
            <?php
            $opt = get_option('isu_popup');
            $uniqid = ( isset($opt['uid']) && $opt['uid'] != '' )? $opt['uid'] : uniqid();
            $auto_trigger = ( isset($opt['auto_trigger']) && $opt['auto_trigger'] === 'true' )? 'true' : 'false';
            if( $auto_trigger  === 'true' ){
                ?>
                    var cookieVal = getCookie_POP('popup-isu');
                    var cookieOptionVal = '<?php echo $uniqid ?>';
                    
                    if(cookieVal && cookieVal == cookieOptionVal){
                        //console.log('No popup');
                    }else{
                        //console.log('set Cookie: ', cookieOptionVal);

                        setCookie_POP('popup-isu', cookieOptionVal, 30)
                        jQuery('#mc4_popup_simple button.showMe').trigger('click');
                    }
                <?php
            }
            ?>
            /*mc4wp.forms.on('success', function(form) {
                // your code goes here
                console.log("Form successfully submitted. Name: " + form.name + "ID: " + form.id);
            }); */
        });
    </script>
    <?php
    $html = ob_get_clean();
    echo $html;
}