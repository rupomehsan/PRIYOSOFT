/**
 * TodoMilestone Module Setup Configuration
 *
 * This file contains all configuration for the TodoMilestone module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "TodoMilestone";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "todo-milestone",
    store_prefix: "todo-milestone",
    route_prefix: "TodoMilestone",
    route_path: "todo-milestone",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "todo-milestone-view",
        details: "todo-milestone-details",
        create: "todo-milestone-create",
        edit: "todo-milestone-edit",
        delete: "todo-milestone-delete",
        import: "todo-milestone-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "todo-milestones",

    // Field Selection for API requests
    select_fields: [
        "id",
        "title",
            "phase",
            "target_date",
            "achieved_date",
            "status",
            "note",
            "sort_order",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "title",
            "phase",
            "target_date",
            "achieved_date",
            "status",
            "note",
            "sort_order",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "title",
            "phase",
            "target_date",
            "achieved_date",
            "status",
            "note",
            "sort_order",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "title",
            "phase",
            "target_date",
            "achieved_date",
            "status",
            "note",
            "sort_order",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "title",
            "phase",
            "target_date",
            "achieved_date",
            "status",
            "note",
            "sort_order",
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
