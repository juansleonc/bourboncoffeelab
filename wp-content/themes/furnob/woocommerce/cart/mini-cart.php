<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="products list woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				
				<li class="product woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">

					<div class="product-content">
					
						<div class="thumbnail-wrapper">
							<?php if ( empty( $product_permalink ) ) : ?>
								<?php echo furnob_sanitize_data($thumbnail); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php else : ?>
								<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo furnob_sanitize_data($thumbnail); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<?php endif; ?>
						</div><!-- thumbnail-wrapper -->
						
						<div class="content-wrapper">
							<h3 class="product-title"><a href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($product_name); ?></a></h3>
							<div class="entry-price">
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div><!-- entry-price -->

							<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="klbth-icon-x"></i></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr__( 'Remove this item', 'furnob' ),
									esc_attr( $product_id ),
									esc_attr( $cart_item_key ),
									esc_attr( $_product->get_sku() )
								),
								$cart_item_key
							);
							?>

							<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						</div><!-- content-wrapper -->
					</div><!-- product-content -->
					
				</li><!-- product -->
				

				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<div class="empty-mini-cart">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 231.523 231.523" style="enable-background:new 0 0 231.523 231.523" xml:space="preserve"><path d="M107.415 145.798a7.502 7.502 0 0 0 8.231 6.69 7.5 7.5 0 0 0 6.689-8.231l-3.459-33.468a7.5 7.5 0 0 0-14.92 1.542l3.459 33.467zM154.351 152.488a7.501 7.501 0 0 0 8.231-6.69l3.458-33.468a7.499 7.499 0 0 0-6.689-8.231c-4.123-.421-7.806 2.57-8.232 6.689l-3.458 33.468a7.5 7.5 0 0 0 6.69 8.232zM96.278 185.088c-12.801 0-23.215 10.414-23.215 23.215 0 12.804 10.414 23.221 23.215 23.221s23.216-10.417 23.216-23.221c0-12.801-10.415-23.215-23.216-23.215zm0 31.435c-4.53 0-8.215-3.688-8.215-8.221 0-4.53 3.685-8.215 8.215-8.215 4.53 0 8.216 3.685 8.216 8.215 0 4.533-3.686 8.221-8.216 8.221zM173.719 185.088c-12.801 0-23.216 10.414-23.216 23.215 0 12.804 10.414 23.221 23.216 23.221 12.802 0 23.218-10.417 23.218-23.221 0-12.801-10.416-23.215-23.218-23.215zm0 31.435c-4.53 0-8.216-3.688-8.216-8.221 0-4.53 3.686-8.215 8.216-8.215 4.531 0 8.218 3.685 8.218 8.215 0 4.533-3.686 8.221-8.218 8.221z"/><path d="M218.58 79.08a7.5 7.5 0 0 0-5.933-2.913H63.152l-6.278-24.141a7.5 7.5 0 0 0-7.259-5.612H18.876a7.5 7.5 0 0 0 0 15h24.94l6.227 23.946c.031.134.066.267.104.398l23.157 89.046a7.5 7.5 0 0 0 7.259 5.612h108.874a7.5 7.5 0 0 0 7.259-5.612l23.21-89.25a7.502 7.502 0 0 0-1.326-6.474zm-34.942 86.338H86.362l-19.309-74.25h135.895l-19.31 74.25zM105.556 52.851a7.478 7.478 0 0 0 5.302 2.195 7.5 7.5 0 0 0 5.302-12.805L92.573 18.665a7.501 7.501 0 0 0-10.605 10.609l23.588 23.577zM159.174 55.045c1.92 0 3.841-.733 5.306-2.199l23.552-23.573a7.5 7.5 0 0 0-.005-10.606 7.5 7.5 0 0 0-10.606.005l-23.552 23.573a7.5 7.5 0 0 0 5.305 12.8zM135.006 48.311h.002a7.5 7.5 0 0 0 7.5-7.498l.008-33.311A7.5 7.5 0 0 0 135.018 0h-.001a7.5 7.5 0 0 0-7.501 7.498l-.008 33.311a7.5 7.5 0 0 0 7.498 7.502z"/></svg>
		<div class="entry-desc"><?php esc_html_e( 'No products in the cart.', 'furnob' ); ?></div>
		<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="btn btn-primary"><?php esc_html_e('Return To Shop', 'furnob'); ?></a>
	</div><!-- empty-mini-cart -->
		
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
