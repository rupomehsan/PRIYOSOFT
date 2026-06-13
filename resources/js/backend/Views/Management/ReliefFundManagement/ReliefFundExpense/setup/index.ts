/**
 * ReliefFundExpense Module Setup Configuration
 *
 * This file contains all configuration for the ReliefFundExpense module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "ReliefFundExpense";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "relief-fund-expense",
    store_prefix: "relief-fund-expense",
    route_prefix: "ReliefFundExpense",
    route_path: "relief-fund-expense",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "relief-fund-expense-view",
        details: "relief-fund-expense-details",
        create: "relief-fund-expense-create",
        edit: "relief-fund-expense-edit",
        delete: "relief-fund-expense-delete",
        import: "relief-fund-expense-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "relief-fund-expenses",

    // Field Selection for API requests
    select_fields: [
        "id",
        "expense_id",
            "transaction_log_id",
            "beneficiary",
            "amount",
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
        "expense_id",
            "transaction_log_id",
            "beneficiary",
            "amount",
            "date",
            "description",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "expense_id",
            "transaction_log_id",
            "beneficiary",
            "amount",
            "date",
            "description",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "expense_id",
            "transaction_log_id",
            "beneficiary",
            "amount",
            "date",
            "description",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "expense_id",
            "transaction_log_id",
            "beneficiary",
            "amount",
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
