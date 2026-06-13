/**
 * BranchTargetMoukufApplication Module Setup Configuration
 *
 * This file contains all configuration for the BranchTargetMoukufApplication module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "BranchTargetMoukufApplication";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "branch-target-moukuf-application",
    store_prefix: "branch-target-moukuf-application",
    route_prefix: "BranchTargetMoukufApplication",
    route_path: "branch-target-moukuf-application",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "branch-target-moukuf-application-view",
        details: "branch-target-moukuf-application-details",
        create: "branch-target-moukuf-application-create",
        edit: "branch-target-moukuf-application-edit",
        delete: "branch-target-moukuf-application-delete",
        import: "branch-target-moukuf-application-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "branch-target-moukuf-applications",

    // Field Selection for API requests
    select_fields: [
        "id",
        "branch_id",
            "branch_target_id",
            "transaction_category_id",
            "target_amount",
            "fulfilled_amount",
            "remaining_amount",
            "requested_waiver_amount",
            "reason",
            "application_status",
            "approved_waiver_amount",
            "reviewed_by",
            "reviewed_at",
            "review_comment",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "branch_id",
            "branch_target_id",
            "transaction_category_id",
            "target_amount",
            "fulfilled_amount",
            "remaining_amount",
            "requested_waiver_amount",
            "reason",
            "application_status",
            "approved_waiver_amount",
            "reviewed_by",
            "reviewed_at",
            "review_comment",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "branch_id",
            "branch_target_id",
            "transaction_category_id",
            "target_amount",
            "fulfilled_amount",
            "remaining_amount",
            "requested_waiver_amount",
            "reason",
            "application_status",
            "approved_waiver_amount",
            "reviewed_by",
            "reviewed_at",
            "review_comment",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "branch_id",
            "branch_target_id",
            "transaction_category_id",
            "target_amount",
            "fulfilled_amount",
            "remaining_amount",
            "requested_waiver_amount",
            "reason",
            "application_status",
            "approved_waiver_amount",
            "reviewed_by",
            "reviewed_at",
            "review_comment",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "branch_id",
            "branch_target_id",
            "transaction_category_id",
            "target_amount",
            "fulfilled_amount",
            "remaining_amount",
            "requested_waiver_amount",
            "reason",
            "application_status",
            "approved_waiver_amount",
            "reviewed_by",
            "reviewed_at",
            "review_comment",
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
