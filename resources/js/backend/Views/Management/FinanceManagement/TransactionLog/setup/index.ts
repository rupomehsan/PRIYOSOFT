/**
 * TransactionLog Module Setup Configuration
 *
 * This file contains all configuration for the TransactionLog module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "TransactionLog";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "transaction-log",
    store_prefix: "transaction-log",
    route_prefix: "TransactionLog",
    route_path: "transaction-log",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "transaction-log-view",
        details: "transaction-log-details",
        create: "transaction-log-create",
        edit: "transaction-log-edit",
        delete: "transaction-log-delete",
        import: "transaction-log-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "transaction-logs",

    // Field Selection for API requests
    select_fields: [
        "id",
        "account_id",
            "type",
            "direction",
            "amount",
            "balance_before",
            "balance_after",
            "reference_type",
            "reference_id",
            "description",
            "product_id",
            "investor_id",
            "transaction_date",
            "created_by",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "account_id",
            "type",
            "direction",
            "amount",
            "balance_before",
            "balance_after",
            "reference_type",
            "reference_id",
            "description",
            "product_id",
            "investor_id",
            "transaction_date",
            "created_by",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "account_id",
            "type",
            "direction",
            "amount",
            "balance_before",
            "balance_after",
            "reference_type",
            "reference_id",
            "description",
            "product_id",
            "investor_id",
            "transaction_date",
            "created_by",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "account_id",
            "type",
            "direction",
            "amount",
            "balance_before",
            "balance_after",
            "reference_type",
            "reference_id",
            "description",
            "product_id",
            "investor_id",
            "transaction_date",
            "created_by",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "account_id",
            "type",
            "direction",
            "amount",
            "balance_before",
            "balance_after",
            "reference_type",
            "reference_id",
            "description",
            "product_id",
            "investor_id",
            "transaction_date",
            "created_by",
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
