/**
 * WelfareFundExpense Module Setup Configuration
 *
 * This file contains all configuration for the WelfareFundExpense module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "WelfareFundExpense";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "welfare-fund-expense",
    store_prefix: "welfare-fund-expense",
    route_prefix: "WelfareFundExpense",
    route_path: "welfare-fund-expense",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "welfare-fund-expense-view",
        details: "welfare-fund-expense-details",
        create: "welfare-fund-expense-create",
        edit: "welfare-fund-expense-edit",
        delete: "welfare-fund-expense-delete",
        import: "welfare-fund-expense-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "welfare-fund-expenses",

    // Field Selection for API requests
    select_fields: [
        "id",
        "transaction_log_id",
            "expense_id",
            "amount",
            "amount_in_text",
            "date",
            "description",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "transaction_log_id",
            "expense_id",
            "amount",
            "amount_in_text",
            "date",
            "description",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "transaction_log_id",
            "expense_id",
            "amount",
            "amount_in_text",
            "date",
            "description",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "transaction_log_id",
            "expense_id",
            "amount",
            "amount_in_text",
            "date",
            "description",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "transaction_log_id",
            "expense_id",
            "amount",
            "amount_in_text",
            "date",
            "description",
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
