/**
 * Product Module Setup Configuration
 *
 * This file contains all configuration for the Product module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "Product";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "product",
    store_prefix: "product",
    route_prefix: "Product",
    route_path: "product",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "product-view",
        details: "product-details",
        create: "product-create",
        edit: "product-edit",
        delete: "product-delete",
        import: "product-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "products",

    // Field Selection for API requests
    select_fields: [
        "id",
        "product_group_id",
        "name",
        "slug",
        "description",
        "status",
        "launch_date",
        "monthly_target_revenue",
        "regular_price",
        "sales_price",
        "features",
        "screenshots",
        "thumbnail",
        "promo_link",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "product_group_id",
        "name",
        "slug",
        "status",
        "launch_date",
        "monthly_target_revenue",
        "regular_price",
        "sales_price",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "product_group_id",
        "name",
        "slug",
        "status",
        "launch_date",
        "monthly_target_revenue",
        "regular_price",
        "sales_price",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "product_group_id",
        "name",
        "slug",
        "status",
        "launch_date",
        "monthly_target_revenue",
        "regular_price",
        "sales_price",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "product_group_id",
        "name",
        "slug",
        "description",
        "status",
        "launch_date",
        "monthly_target_revenue",
        "regular_price",
        "sales_price",
        "features",
        "screenshots",
        "thumbnail",
        "promo_link",
        "created_at",
    ],

    // UI Labels and Titles
    layout_title: prefix + " Management",
    page_title: `${prefix} Management`,
    all_page_title: "All " + prefix,
    details_page_title: "Details " + prefix,
    create_page_title: "Create " + prefix,
    edit_page_title: "Edit " + prefix,
};

export default setup;
