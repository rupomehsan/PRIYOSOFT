/**
 * Order Module Setup Configuration
 *
 * This file contains all configuration for the Order module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "Order";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "order",
    store_prefix: "order",
    route_prefix: "Order",
    route_path: "order",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "order-view",
        details: "order-details",
        create: "order-create",
        edit: "order-edit",
        delete: "order-delete",
        import: "order-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "orders",

    // Field Selection for API requests
    select_fields: [
        "id",
        "order_number",
        "ref_code",
        "product_id",
        "product_name",
        "plan_name",
        "billing_cycle",
        "customer_id",
        "customer_name",
        "customer_phone",
        "customer_email",
        "domain_name",
        "project_description",
        "preferred_delivery_date",
        "special_requirements",
        "subtotal",
        "discount_amount",
        "total_amount",
        "coupon_code",
        "pay_now",
        "payment_method",
        "order_status",
        "delivery_method",
        "admin_note",
        "ordered_at",
        "payment_verified_at",
        "work_started_at",
        "access_sent_at",
        "completed_at",
        "cancelled_at",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "order_number",
        "customer_name",
        "customer_phone",
        "total_amount",
        "order_status",
        "payment_method",
        "pay_now",
        "ordered_at",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "order_number",
        "customer_name",
        "customer_phone",
        "product_name",
        "plan_name",
        "total_amount",
        "payment_method",
        "order_status",
        "ordered_at",
        "status",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "order_number",
        "customer_name",
        "customer_phone",
        "product_name",
        "plan_name",
        "total_amount",
        "payment_method",
        "order_status",
        "ordered_at",
        "status",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "order_number",
        "ref_code",
        "customer_name",
        "customer_phone",
        "customer_email",
        "domain_name",
        "product_name",
        "plan_name",
        "billing_cycle",
        "total_amount",
        "coupon_code",
        "pay_now",
        "payment_method",
        "order_status",
        "delivery_method",
        "preferred_delivery_date",
        "ordered_at",
        "admin_note",
        "status",
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
