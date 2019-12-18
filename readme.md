# Woo Variation Grid

Woo Variation Grid is a simple wordpress plugin that allows you to display WooCommerce products on any page by using the shortcode.

### Getting Started:

1. Install and activate the wordpress plugin
2. Insert the shortcode `[woo_variation_grid]` into any page where you would like the products to appear.

### Options:

There are several parameters available with the shortcode, all are optional. If the display parameter is not provided, it will simply default to grid.

| Key | Possible Values |
| ------ | ------ |
| display | **grid, table** |
| heading | **title** [Display title above the Grid/Table] |
| parent | **10** [Parent product ID] |
| limit | *e.g.* **12** [Amount of variations per page] |
| thead | **Image, Name, Sku, Price, Add to cart** |
| order | **DESC, ASC** [Use with orderby] |
| orderby | **none, ID, name, type, rand, date, modified.** |
| cf_filter | **key:value** [Created in the Woo Variation Grid settings]  |

__Note:__ thead values must spell exactly the same as the values listed above. Changing the order of the thead will be reflected in the table view. 
To exclude a column from the table, simply exclude the column heading from the thead values.

### Shortcode Usage Examples:

###### Show products in a table view
`[woo_variation_grid display="table"]`

###### Show products in a grid view
`[woo_variation_grid display="grid"]`

###### Limit the amount of products displayed per page.
`[woo_variation_grid display="grid" limit="6"]`

###### Adding a title to the table
`[woo_variation_grid display="grid" limit="6" title="T-Shirts"]`

###### Showing only variations that belong to a single parent product
`[woo_variation_grid display="grid" parent="12"]`

###### Reorder table view headings
`[woo_variation_grid display="grid" limit="10" thead="Name, Price, Sku, Image, Add to cart"]`

###### Remove table column (Add to cart has been removed)
`[woo_variation_grid display="grid" limit="10" thead="Name, Price, Sku, Image"]`

###### Ordering products by some parameter
`[woo_variation_grid display="grid" limit="10" orderby="modified" order="desc"]`

###### Filtering variations with custom fields
`[woo_variation_grid display="grid" limit="10" orderby="modified" order="desc" cf_filter="key:value" ]`