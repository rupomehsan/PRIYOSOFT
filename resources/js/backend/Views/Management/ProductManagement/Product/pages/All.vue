<template>
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header p-0">
            <!-- Status Tab Bar -->
            <div class="prod-tabs">
              <button
                v-for="tab in statusTabs" :key="tab.key"
                class="prod-tab"
                :class="{ 'prod-tab--active': status === tab.key }"
                @click="change_status(tab.key)"
              >
                <i :class="tab.icon"></i>
                {{ tab.label }}
                <span class="prod-tab__count">{{ tab.count }}</span>
              </button>
            </div>

            <!-- Search + Actions Row -->
            <div class="prod-toolbar">
              <input
                class="prod-search"
                @keyup="(e) => set_search_key(e)"
                placeholder="Search products…"
              />
              <div class="prod-toolbar__actions">
                <button class="btn btn-sm btn-outline-secondary" @click="get_all" title="Reload">
                  <i class="fa fa-refresh"></i>
                </button>
                <button class="btn btn-sm btn-outline-primary" @click="set_show_filter_canvas">
                  <i class="fa fa-sliders"></i> Filter
                </button>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div
              class="table-responsive table_responsive card_body_fixed_height"
            >
              <table class="table table-hover text-center table-bordered">
                <thead>
                  <table-head />
                </thead>
                <tbody v-if="all?.data?.length">
                  <table-body :data="all?.data" />
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="100%">
                      <div
                        class="d-flex flex-column align-items-center justify-content-center py-5"
                      >
                        <div
                          style="
                            width: 180px;
                            height: 180px;
                            margin-bottom: 30px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background: linear-gradient(
                              135deg,
                              #667eea 0%,
                              #764ba2 100%
                            );
                            border-radius: 12px;
                            opacity: 0.6;
                          "
                        >
                          <i
                            class="fa fa-database"
                            style="font-size: 80px; color: white"
                          ></i>
                        </div>
                        <h4 class="text-muted mb-2">No Records Found</h4>
                        <p class="text-secondary">
                          There are currently no items to display. Try adjusting
                          your search or filters.
                        </p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="mx-3">
            <pagination
              :data="all"
              :set_page="set_page"
              :get_data="get_all"
              :set_paginate="set_paginate"
            />
          </div>
          <div class="card-footer py-2">
            <all-page-footer-actions />
          </div>
        </div>
      </div>
    </div>
    <!-- Canvas and Modal Components -->
    <export-loader />
    <quick-view />
    <filter-data />
    <import-modal />
  </div>
</template>

<script>
/** plugins */
import { mapActions, mapWritableState } from "pinia";
import setup from "../setup";
import { store as data_store } from "../store";
// Import from shared helpers instead of local (which don't exist)
import export_all_csv from "@/shared/helpers/export_all_csv";
import export_selected_csv from "@/shared/helpers/export_selected_csv";
import export_demo_csv from "@/shared/helpers/export_demo_csv";
import debounce from "@/shared/helpers/debounce";

// Import from shared components instead of local (which don't exist)
import TableHead from "@/shared/components/all_data_page/TableHead.vue";
import TableBody from "@/shared/components/all_data_page/TableBody.vue";
import Pagination from "@/GlobalComponents/Pagination.vue";
import AllPageFooterActions from "@/shared/components/all_data_page/AllPageFooterActions.vue";
// Import canvas components
import FilterData from "@/shared/components/canvas/FilterData.vue";
import ImportModal from "@/shared/components/canvas/ImportModal.vue";
import QuickView from "@/shared/components/canvas/QuickView.vue";
import ExportLoader from "@/shared/components/canvas/ExportLoader.vue";

export default {
  components: {
    TableHead,
    TableBody,
    Pagination,
    AllPageFooterActions,
    FilterData,
    ImportModal,
    QuickView,
    ExportLoader,
  },

  // Provide setup and store to child components via dependency injection
  provide() {
    return {
      moduleSetup: this.setup,
      dataStoreConstructor: data_store,
    };
  },

  data: () => ({
    setup,
    is_trashed_data: false,
    filePath:
      "resources/js/backend/Views/SuperAdmin/Management/TestModule/helpers/demo.csv",
  }),
  created: async function () {
    this.set_status('all');
    await this.get_all();
  },
  methods: {
    export_all_csv,
    export_selected_csv,
    export_demo_csv,
    ...mapActions(data_store, [
      "get_all",
      `restore`,
      `soft_delete`,
      `update_status`,
      "destroy",
      "bulk_action",
      "clear_selected",
      "import_data",
      "set_show_filter_canvas",
      `set_only_latest_data`,
      `set_item`,
      "set_filter_criteria",
      "set_page",
      "set_status",
      "set_paginate",
    ]),

    active_row(event) {
      const targetRow = event.target.closest(".table_rows");
      if (!targetRow) return;
      document.querySelectorAll(".table_rows.active").forEach((row) => {
        if (row !== targetRow) row.classList.remove("active");
      });
      targetRow.classList.toggle("active");
    },

    updateStatus: async function (item) {
      let action = item.status == "active" ? "deactive" : "active";
      let con = await window.s_confirm("Are you sure want to " + action + " ?");
      if (con) {
        this.set_item(item);
        this.set_only_latest_data(true);
        let response = await this.update_status();
        if (response.data.status === "success") {
          await this.get_all();
          window.s_alert(response.data?.message);
          this.set_only_latest_data(true);
        } else {
          window.s_warning(response.data?.message);
        }
      }
    },
    softDelete: async function (item) {
      let con = await window.s_confirm("Are you sure want to delete ?");
      if (con) {
        this.set_item(item);
        this.set_only_latest_data(true);

        let response = await this.soft_delete();
        if (response.data.status === "success") {
          await this.get_all();
          window.s_alert(response.data?.message);
          this.set_only_latest_data(true);
        } else {
          window.s_warning(response.data?.message);
        }
      }
    },
    restore_data: async function (item) {
      let con = await window.s_confirm("Restore");
      if (con) {
        this.set_item(item);
        this.set_only_latest_data(true);
        let response = await this.restore();
        if (response.data.status === "success") {
          await this.get_all();
          window.s_alert("Permanently deleted.");
          this.set_only_latest_data(true);
        } else {
          window.s_warning(response.data?.message);
        }
      }
    },

    destroy_data: async function (item) {
      let con = await window.s_confirm("Permanently delete");
      if (con) {
        this.set_item(item);
        this.set_only_latest_data(true);
        let response = await this.destroy();
        if (response.data.status === "success") {
          await this.get_all();
          window.s_alert("Permanently deleted.");
          this.set_only_latest_data(true);
        } else {
          window.s_warning(response.data?.message);
        }
      }
    },
    change_status: function (status = "active") {
      if (status == "trashed") {
        this.is_trashed_data = true;
      } else {
        this.is_trashed_data = false;
      }
      this.set_only_latest_data(true);
      this.set_status(status);
      this.set_page(1);
      this.get_all();
      this.set_only_latest_data(true);
    },
    set_page_data: function (link) {
      try {
        let url = new URL(link.url);
        let page = url.searchParams.get("page");
        link.url ? this.set_page(parseInt(page)) : "";
        this.get_all();
      } catch (error) {}
    },
    set_per_page_limit: function () {
      this.set_paginate(event.target.value);
      this.get_all();
    },

    set_all_item_selected(event) {
      this.selected = event.target.checked ? [...this.all.data] : [];
    },

    set_item_selected(item, event) {
      const isChecked = event.target.checked;
      const selectedItems = new Set(this.selected);
      if (isChecked) {
        selectedItems.add(item);
      } else {
        selectedItems.delete(item);
      }
      this.selected = [...selectedItems];
    },
    isSelected(item) {
      return this.selected.some((selectedItem) => selectedItem.id === item.id);
    },

    bulkActions: async function () {
      let action = event.target.value;
      let con = await window.s_confirm(
        "Are you sure want to " + action + " items ?",
      );
      if (con) {
        let selected_data = this.selected;
        selected_data = selected_data.map((item) => item.id);
        this.set_only_latest_data(true);
        let response = await this.bulk_action(action, selected_data);
        if (response.data.status === "success") {
          await this.get_all();
          document.querySelector(".select_all_checkbox").checked = false;
          this.clear_selected();
          this.set_only_latest_data(false);
          window.s_alert("You have " + action + " items ?");
        } else {
          window.s_warning(response.data?.message);
        }
      }
    },

    FileUploadHandler: async function ($event) {
      let formData = new FormData($event.target);
      let response = await this.import_data(formData);
      if (response.data.status === "success") {
        await this.get_all();
        window.s_alert(response.data.message);
        this.set_only_latest_data(true);
        this.import_csv_modal_show = false;
      } else {
        window.s_warning(response.data?.message);
      }
    },

    set_search_key: debounce(async function (event) {
      let value = event.target.value;
      this.search_key = value;
      this.page = 1;

      this.only_latest_data = true;
      await this.get_all();
      this.only_latest_data = false;
    }, 500),
  },
  computed: {
    ...mapWritableState(data_store, [
      "all",
      "show_filter_canvas",
      "active_data_count",
      "inactive_data_count",
      "planning_count",
      "development_count",
      "paused_count",
      "trashed_data_count",
      "status",
      "selected",
      "paginate",
      "sort_type",
      "sort_by_cols",
      "sort_by_col",
      "start_date",
      "end_date",
      "search_key",
      "page",
      "import_csv_modal_show",
    ]),
    isAllSelected() {
      return (
        this.all?.data?.length > 0 &&
        this.all.data?.every((item) =>
          this.selected.some((s) => s.id === item.id),
        )
      );
    },
    statusTabs() {
      const total = (this.active_data_count || 0) + (this.inactive_data_count || 0)
                  + (this.planning_count || 0) + (this.development_count || 0) + (this.paused_count || 0);
      return [
        { key: 'all',         label: 'All',     icon: 'fa fa-th-large',     count: total },
        { key: 'active',      label: 'Live',    icon: 'fa fa-check-circle', count: this.active_data_count },
        { key: 'planning',    label: 'Upcoming',icon: 'fa fa-clock-o',      count: this.planning_count },
        { key: 'development', label: 'In Dev',  icon: 'fa fa-code',         count: this.development_count },
        { key: 'paused',      label: 'Paused',  icon: 'fa fa-pause-circle', count: this.paused_count },
        { key: 'trashed',     label: 'Trash',   icon: 'fa fa-trash',        count: this.trashed_data_count },
      ];
    },
  },

  watch: {
    is_trashed_data: {
      handler: function (newValue, oldValue) {
        this.is_trashed_data = newValue;
      },
      immediate: true,
    },
  },
};
</script>

<style scoped>
/* ── Status Tabs ── */
.prod-tabs {
  display: flex;
  flex-wrap: wrap;
  gap: 0;
  border-bottom: 1px solid rgba(255,255,255,.08);
  padding: 0 1rem;
}
.prod-tab {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  padding: .75rem 1.1rem;
  font-size: .82rem;
  font-weight: 600;
  color: rgba(255,255,255,.5);
  background: transparent;
  border: none;
  border-bottom: 2px solid transparent;
  cursor: pointer;
  transition: color .2s, border-color .2s;
  white-space: nowrap;
}
.prod-tab:hover { color: rgba(255,255,255,.8); }
.prod-tab--active {
  color: #fff;
  border-bottom-color: #6366f1;
}
.prod-tab__count {
  background: rgba(255,255,255,.12);
  color: inherit;
  font-size: .7rem;
  padding: .1rem .45rem;
  border-radius: 20px;
  min-width: 20px;
  text-align: center;
}
.prod-tab--active .prod-tab__count { background: #6366f1; color: #fff; }

/* ── Search + Actions Toolbar ── */
.prod-toolbar {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: .65rem 1rem;
}
.prod-search {
  flex: 1;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.12);
  border-radius: 8px;
  color: #fff;
  padding: .45rem .85rem;
  font-size: .875rem;
  outline: none;
  transition: border-color .2s;
}
.prod-search::placeholder { color: rgba(255,255,255,.35); }
.prod-search:focus { border-color: #6366f1; }
.prod-toolbar__actions { display: flex; gap: .5rem; flex-shrink: 0; }
</style>
