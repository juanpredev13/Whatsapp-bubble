<?php
/**
 * Plugin Name: WhatsApp Bubble
 * Description: Muestra una burbuja de WhatsApp que permite configurar el número desde el panel de administración.
 * Version: 1.0
 * Author: juanpredev
 */

// Evitar acceso directo
if (!defined('ABSPATH')) exit;

// Función para insertar la burbuja de WhatsApp
function whatsapp_bubble() {
    // Recuperar el número configurado
    $whatsapp_number = get_option('whatsapp_number', '');
    
    if ($whatsapp_number) {
        echo '
        <div id="whatsapp-bubble">
            <a href="https://wa.me/' . esc_attr($whatsapp_number) . '" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width:60px; height:60px; position:fixed; bottom:20px; right:20px; z-index:1000;">
            </a>
        </div>';
    }
}
add_action('wp_footer', 'whatsapp_bubble');

// Función para añadir opciones al panel de administración
function whatsapp_bubble_menu() {
    add_menu_page(
        'WhatsApp Bubble',
        'WhatsApp Bubble',
        'manage_options',
        'whatsapp-bubble-settings',
        'whatsapp_bubble_settings_page',
        'dashicons-whatsapp',
        100
    );
}
add_action('admin_menu', 'whatsapp_bubble_menu');

// Crear página de ajustes
function whatsapp_bubble_settings_page() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Bubble Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('whatsapp-bubble-settings-group');
            do_settings_sections('whatsapp-bubble-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Número de WhatsApp</th>
                    <td><input type="text" name="whatsapp_number" value="<?php echo esc_attr(get_option('whatsapp_number')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Registrar la opción del número de WhatsApp
function whatsapp_bubble_settings() {
    register_setting('whatsapp-bubble-settings-group', 'whatsapp_number');
}
add_action('admin_init', 'whatsapp_bubble_settings');
