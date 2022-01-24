/* Redirigir a pagina de tienda si el carrito está vacío */
add_action( 'template_redirect', 'redirigir_a_portada_si_carrito_vacio' );
function redirigir_a_portada_si_carrito_vacio() {
    if ( is_cart() && is_checkout() && 0 == WC()->cart->get_cart_contents_count() && ! is_wc_endpoint_url( 'order-pay' ) && ! is_wc_endpoint_url( 'order-received' ) ) {
        wp_safe_redirect( home_url() );
        exit;
    }
}

// Modificación para Carrito en Finalizar Compra
add_action( 'woocommerce_before_checkout_form', 'bps_cart_checkout_same_page', 5 );
function bps_cart_checkout_same_page() {
	if ( is_wc_endpoint_url( 'order-received' ) ) return;
	echo do_shortcode('[woocommerce_cart]');
}

// Cambio logo de PayPal
function oaf_change_paypal_icon_image() {
     
     return "/wp-content/uploads/2021/06/paypal-logo.png";
}

add_filter( 'woocommerce_paypal_icon', 'oaf_change_paypal_icon_image' );

/* Botón de añadir al carrito bajo productos de tienda */
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20 );


//Quitar botón "Añadir al Carrito" o "Leer Más" cuando el producto no tiene Stock
function remove_buy_button_when_out_of_stock($html, $product, $args){
if ( ! $product->is_in_stock() && ! $product->backorders_allowed() ) {
return '';
}
return $html;
}
add_action('woocommerce_loop_add_to_cart_link', 'remove_buy_button_when_out_of_stock', 10, 3 );

// Producto ya añadido
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );

function woo_custom_cart_button_text() {

	global $woocommerce;
	
	foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
	
		if( get_the_ID() == $_product->id ) {
			return __('Producto ya añadido', 'woocommerce');
		}
	}
	
	return __('Add to cart', 'woocommerce');
}

/*// Cambiar Titulo de Descripción
add_filter( 'woocommerce_product_tabs', 'woo_rename_tab', 98);
function woo_rename_tab($tabs) {

 $tabs['description']['title'] = 'Detalles';

 return $tabs;
}
*/
// Elimina ampliar imagen de productos
function wc_disable_img_enhancement() {
    remove_theme_support( 'wc-product-gallery-zoom' );
    remove_theme_support( 'wc-product-gallery-lightbox' );
}

add_action( 'wp', 'wc_disable_img_enhancement' );

// Elimina mensaje añadido a carrito
function ocultar_wc_add_to_cart_message( $message, $product_id ) {
    return '';
};

add_filter( 'wc_add_to_cart_message', 'ocultar_wc_add_to_cart_message', 10, 2 );


/*// Texto del botón "Añadir al carrito", según categoría
add_filter( 'woocommerce_product_add_to_cart_text', 'bhfreelance_texto_carrito_por_categoria' );
  
function bhfreelance_texto_carrito_por_categoria() {
global $product;
 
$terms = get_the_terms( $product->ID, 'product_cat' );
 foreach ($terms as $term) {
            $product_cat = $term->name;
            break;
}
 
switch($product_cat)
{
    case '46';  //Nombre de una categoría1
        return 'Pedir Regalo'; break;  //Texto específico para categoría1
    default;
        return '¡Lo Quiero!'; break; //Texto predeterminado
}
}
*/
/* Texto del botón "Añadir al carrito" en página de producto
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text_product' );    // 2.1 +
 
function woo_custom_cart_button_text_product() {
 
        return __( '¡Lo Quiero!', 'woocommerce' );
 
}*/

