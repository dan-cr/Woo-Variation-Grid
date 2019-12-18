<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @package    Woo_Variation_Grid
 * @subpackage Woo_Variation_Grid/public/partials
 */

/**
 * Grid template view
 */
function wvg_grid_output($variations, $data) {

    ob_start(); ?>

    <!-- Main Plugin Container div -->
    <div id='wvg-container'>

        <!-- Grid Heading -->
        <?php if ( !empty($data['heading']) && $data['heading'] !== '' ): ?>
            <h1 class='wvg-heading'><?php echo $data['heading'] ?></h1>
        <?php endif; ?>

        <!-- Product Grid -->
        <div class='grid'>

        <?php foreach ( $variations->products as $product_variation ): ?>

            <?php 
                $product_id = $product_variation->get_id(); // Get current product variation id
                $variation = new WC_Product_Variation($product_id); // Grab product variation object
            ?>

            <div class='wvg-column'>

                <div class='wvg-img'><?php echo $variation->get_image() ?></div>

                <div class='wvg-description'>
                    <div class='wvg-title'><?php echo $variation->get_name() ?></div>
                    <div class='wvg-price'><?php echo $variation->get_price_html() ?></div>
                    <div class='wvg-cart-btn'>
                        <a href='<?php echo $variation->get_permalink() ?>'>View Product</a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

        </div>

        <!-- Pagination Section -->
        <div class='wvg-pagination'>
            <?php
                echo paginate_links( array(
                    'format'        => 'page/%#%',
                    'current'       => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
                    'total'         => $variations->max_num_pages,
                    'mid_size'      => 2,
                    'prev_text'     => __('&laquo; Prev'),
                    'next_text'     => __('Next &raquo;')
                ) );
            ?>
        </div> <!-- Closing of pagination section -->

    <!-- Closing of wvg-container -->
    </div>

    <?php 
        $grid = ob_get_clean();
        return $grid;
}

/**
 * Table template view
 */
function wvg_table_output($variations, $data) {

    ob_start();

    // Check for presence of thead or assign a default for the table
    if ( !empty($data['thead']) ) {
        $thead = $data['thead'];
    } else {
        $thead = array('image', 'name', 'sku', 'price', 'add to cart');
    } ?>

    <div id='wvg-container'>

        <!-- Table Heading -->
        <?php if ( $data['heading'] !== '' ): ?>
            <h1 class='wvg-heading'><?php echo $data['heading'] ?></h1>
        <?php endif; ?>
    
        <!-- Start of variation table -->
        <table id='wvg-table-main' class='wvg_table'>
            <thead>
                <tr>
                    <?php foreach ( $thead as $heading ): ?>
                        <th><?php echo ucfirst($heading) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            
            <tbody>

            <?php foreach ( $variations->products as $product_variation ): ?>
                
                <?php 
                    $product_id = $product_variation->get_id();             // Get current variation ID
                    $variation = new WC_Product_Variation($product_id);     // Get variation meta information
                    $tbody = array();                                       // Array holding tbody content

                    foreach ( $thead as $heading ) {
                        // Append matching content to relavent table section
                        switch ($heading) {
                            case 'image':
                                $tbody['image'] = "<div class='wvg-img'>" . $variation->get_image() . "</div>";
                                break;
                            case 'name':
                                $tbody['name'] = $variation->get_name();
                                break;
                            case 'price':
                                $tbody['price'] = $variation->get_price_html();
                                break;
                            case 'sku':
                                $tbody['sku'] = $variation->get_sku();
                                break;
                            case 'add to cart':
                                $tbody['add to cart'] = "<div class='wvg-cart-btn'><a href='" . $variation->add_to_cart_url()  . "'>" . $variation->add_to_cart_text() ."</a></div>";
                                break;
                        }
                    }
                ?>

                    <tr>

                        <?php foreach ( $tbody as $tcontent ): ?>
                            <td><?php echo $tcontent ?></td>
                        <?php endforeach; ?>
                    </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

        <!-- Pagination Section -->
        <div class='wvg-pagination'>
            <?php 
                echo paginate_links( array(
                    'format'        => 'page/%#%',
                    'current'       => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
                    'total'         => $variations->max_num_pages,
                    'mid_size'      => 2,
                    'prev_text'     => __('&laquo; Prev'),
                    'next_text'     => __('Next &raquo;')
                ) ); 
            ?>
        </div> <!-- Closing wvg-pagination div -->

    <!-- Closing wvg-container div -->
    </div>
    

    <?php
        $table = ob_get_clean();
        return $table;
}


}
