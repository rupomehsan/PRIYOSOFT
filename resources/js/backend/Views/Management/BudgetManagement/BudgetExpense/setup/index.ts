/**
 * BudgetExpense Module Setup Configuration
 *
 * This file contains all configuration for the BudgetExpense module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "BudgetExpense";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "budget-expense",
    store_prefix: "budget-expense",
    route_prefix: "BudgetExpense",
    route_path: "budget-expense",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "budget-expense-view",
        details: "budget-expense-details",
        create: "budget-expense-create",
        edit: "budget-expense-edit",
        delete: "budget-expense-delete",
        import: "budget-expense-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "budget-expenses",

    // Field Selection for API requests
    select_fields: [
        "id",
        "budget_session_id",
            "transaction_category_id",
            "program_count_or_months",
            "cost_per_program_month",
            "total_expense_budget",
            "comment",
            "finance_dept_allocation",
            "finance_dept_comment",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "budget_session_id",
            "transaction_category_id",
            "program_count_or_months",
            "cost_per_program_month",
            "total_expense_budget",
            "comment",
            "finance_dept_allocation",
            "finance_dept_comment",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "budget_session_id",
            "transaction_category_id",
            "program_count_or_months",
            "cost_per_program_month",
            "total_expense_budget",
            "comment",
            "finance_dept_allocation",
            "finance_dept_comment",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "budget_session_id",
            "transaction_category_id",
            "program_count_or_months",
            "cost_per_program_month",
            "total_expense_budget",
            "comment",
            "finance_dept_allocation",
            "finance_dept_comment",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "budget_session_id",
            "transaction_category_id",
            "program_count_or_months",
            "cost_per_program_month",
            "total_expense_budget",
            "comment",
            "finance_dept_allocation",
            "finance_dept_comment",
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
