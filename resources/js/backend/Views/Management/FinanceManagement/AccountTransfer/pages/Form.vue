<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="text-capitalize">
            {{
              param_id
                ? `${setup.edit_page_title}`
                : `${setup.create_page_title}`
            }}
          </h5>
          <div>
            <router-link
              v-if="item.slug"
              class="btn btn-outline-info mr-2 btn-sm"
              :to="{
                name: `Details${setup.route_prefix}`,
                params: { id: item.slug },
              }"
            >
              {{ setup.details_page_title }}
            </router-link>
            <router-link
              class="btn btn-outline-warning btn-sm"
              :to="{ name: `All${setup.route_prefix}` }"
            >
              {{ setup.all_page_title }}
            </router-link>
          </div>
        </div>
        <div class="card-body card_body_fixed_height">
          <div class="row" v-if="form_ready">
            <template
              v-for="form_field in form_fields"
              :key="form_field.name"
            >
              <common-input
                :label="form_field.label"
                :type="form_field.type"
                :name="form_field.name"
                :placeholder="form_field.placeholder"
                :multiple="form_field.multiple"
                :value="form_field.value"
                :data_list="form_field.data_list"
                :is_visible="form_field.is_visible"
                :class="form_field.class"
              />
            </template>
          </div>
          <div v-else class="d-flex align-items-center justify-content-center py-5">
            <span class="text-muted">Loading...</span>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-light btn-square px-5" :disabled="!form_ready">
            <i class="icon-lock"></i>
            Submit
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { store } from "../store";
import setup from "../setup";
import form_fields from "../setup/form_fields";

export default {
  data: () => ({
    setup,
    form_fields,
    param_id: null,
    form_ready: false,
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    this.reset_fields();
    await this.load_accounts();
    if (id) {
      await this.set_fields(id);
    }
    this.form_ready = true;
    if (id) {
      this.$nextTick(() => {
        setTimeout(() => this.set_editor_content(), 1200);
      });
    }
  },
  methods: {
    ...mapActions(store, {
      create: "create",
      update: "update",
      details: "details",
      get_all: "get_all",
      set_only_latest_data: "set_only_latest_data",
    }),
    reset_fields: function () {
      this.form_fields.forEach((item) => {
        item.value = "";
      });
    },
    load_accounts: async function () {
      try {
        const res = await window.axios.get(
          "accounts?get_all=1&limit=1000&sort_by_col=name&sort_type=asc"
        );
        const raw = res?.data?.data ?? [];
        const list = Array.isArray(raw) ? raw : [];
        const accountList = list.map((r) => ({ label: r.name, value: r.id }));
        const fromField = this.form_fields.find((f) => f.name === "from_account_id");
        const toField   = this.form_fields.find((f) => f.name === "to_account_id");
        if (fromField) fromField.data_list = accountList;
        if (toField)   toField.data_list   = accountList;
      } catch (e) {
        console.warn("Could not load accounts:", e);
      }
    },
    set_fields: async function (id) {
      this.param_id = id;
      await this.details(id);
      if (this.item) {
        this.form_fields.forEach((field, index) => {
          Object.entries(this.item).forEach(([key, val]) => {
            if (field.name === key) {
              const resolved =
                val && typeof val === "object" && !Array.isArray(val) && "id" in val
                  ? val.id
                  : val;
              this.form_fields[index].value = resolved;
            }
          });
        });
      }
    },
    set_editor_content: function () {
      const field = this.form_fields.find((f) => f.name === "note");
      if (field?.value) {
        try {
          $("#note").summernote("code", field.value);
        } catch (e) {
          console.warn("Could not set note editor content:", e);
        }
      }
    },
    submitHandler: async function ($event) {
      this.set_only_latest_data(true);
      if (this.param_id) {
        this.setSummerEditor();
        let response = await this.update($event);
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data successfully updated");
          this.$router.push({ name: `Details${this.setup.route_prefix}` });
        }
      } else {
        this.setSummerEditor();
        let response = await this.create($event);
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data Successfully Created");
          this.$router.push({ name: `All${this.setup.route_prefix}` });
        }
      }
    },
    setSummerEditor() {
      const el = document.getElementById("note");
      if (el) {
        try {
          var markupStr = $("#note").summernote("code");
          var target = document.createElement("input");
          target.setAttribute("name", "note");
          target.value = markupStr;
          el.appendChild(target);
        } catch (e) {
          console.warn("Note editor not available:", e);
        }
      }
    },
  },

  computed: {
    ...mapState(store, {
      item: "item",
    }),
  },
};
</script>

<style scoped></style>
