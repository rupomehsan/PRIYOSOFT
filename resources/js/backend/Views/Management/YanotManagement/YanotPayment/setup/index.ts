/**
 * YanotPayment Module Setup Configuration
 *
 * This file contains all configuration for the YanotPayment module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "YanotPayment";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "yanot-payment",
    store_prefix: "yanot-payment",
    route_prefix: "YanotPayment",
    route_path: "yanot-payment",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "yanot-payment-view",
        details: "yanot-payment-details",
        create: "yanot-payment-create",
        edit: "yanot-payment-edit",
        delete: "yanot-payment-delete",
        import: "yanot-payment-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "yanot-payments",

    // Field Selection for API requests
    select_fields: [
        "id",
        "yanot_member_id",
            "yanot_register_id",
            "month",
            "amount",
            "payment_date",
            "is_paid",
            "transaction_log_id",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "yanot_member_id",
            "yanot_register_id",
            "month",
            "amount",
            "payment_date",
            "is_paid",
            "transaction_log_id",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "yanot_member_id",
            "yanot_register_id",
            "month",
            "amount",
            "payment_date",
            "is_paid",
            "transaction_log_id",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "yanot_member_id",
            "yanot_register_id",
            "month",
            "amount",
            "payment_date",
            "is_paid",
            "transaction_log_id",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "yanot_member_id",
            "yanot_register_id",
            "month",
            "amount",
            "payment_date",
            "is_paid",
            "transaction_log_id",
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
