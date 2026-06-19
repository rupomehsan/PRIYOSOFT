<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="text-capitalize">
            {{ param_id ? setup.edit_page_title : setup.create_page_title }}
          </h5>
          <div>
            <router-link
              v-if="item.slug"
              class="btn btn-outline-info mr-2 btn-sm"
              :to="{ name: `Details${setup.route_prefix}`, params: { id: item.slug } }"
            >{{ setup.details_page_title }}</router-link>
            <router-link
              class="btn btn-outline-warning btn-sm"
              :to="{ name: `All${setup.route_prefix}` }"
            >{{ setup.all_page_title }}</router-link>
          </div>
        </div>

        <div class="card-body card_body_fixed_height">
          <div class="row">

            <!-- Standard fields via common-input -->
            <template v-for="(form_field, index) in form_fields" :key="index">
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

            <!-- ── Features add/remove list ── -->
            <div class="col-md-12">
              <!-- Hidden input carries the JSON value that FormData picks up -->
              <input type="hidden" name="features" :value="featuresJson" />

              <div class="form-group">
                <label class="form-label fw-semibold">Features</label>
                <div
                  v-for="(feat, i) in features_list"
                  :key="i"
                  class="d-flex align-items-center gap-2 mb-2"
                >
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    :placeholder="'Feature ' + (i + 1)"
                    :value="feat"
                    @input="features_list[i] = $event.target.value"
                  />
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-danger px-2 flex-shrink-0"
                    :disabled="features_list.length === 1"
                    @click="removeFeature(i)"
                    title="Remove"
                  >
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <button
                  type="button"
                  class="btn btn-sm btn-outline-success mt-1"
                  @click="addFeature"
                >
                  <i class="fas fa-plus me-1"></i> Add Feature
                </button>
              </div>
            </div>

          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-light btn-square px-5">
            <i class="icon-lock"></i> Submit
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
    features_list: [""],
  }),

  computed: {
    ...mapState(store, { item: "item" }),
    featuresJson() {
      const trimmed = this.features_list.map((f) => f.trim()).filter(Boolean);
      return JSON.stringify(trimmed);
    },
  },

  created: async function () {
    const id = (this.param_id = this.$route.params.id);
    this.reset_fields();
    await this.loadProductGroups();
    if (id) {
      await this.set_fields(id);
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

    async loadProductGroups() {
      try {
        const res = await window.axios.get(
          "product-groups?get_all=1&limit=100&sort_by_col=name&sort_type=asc"
        );
        // get_all=1 → response.data.data is the array directly (not paginated)
        const raw = res?.data?.data ?? [];
        const list = Array.isArray(raw) ? raw : [];
        const field = this.form_fields.find((f) => f.name === "product_group_id");
        if (field) {
          field.data_list = list.map((g) => ({ label: g.name, value: g.id }));
        }
      } catch (e) {
        console.warn("Could not load product groups:", e);
      }
    },

    reset_fields() {
      this.form_fields.forEach((item) => { item.value = ""; });
      this.features_list = [""];
    },

    async set_fields(id) {
      this.param_id = id;
      await this.details(id);
      if (this.item) {
        this.form_fields.forEach((field, index) => {
          Object.entries(this.item).forEach(([key, val]) => {
            if (field.name === key) {
              // Eloquent belongsTo relations share the FK key name — extract id
              const resolved = (val && typeof val === 'object' && !Array.isArray(val) && 'id' in val)
                ? val.id
                : val;
              this.form_fields[index].value = resolved;
            }
            if (field.name === "description" && key === "description") {
              $("#description").summernote("code", val);
            }
          });
        });

        // Parse features JSON into the list UI
        const raw = this.item.features;
        if (raw) {
          try {
            const arr = typeof raw === "string" ? JSON.parse(raw) : raw;
            this.features_list = Array.isArray(arr) && arr.length ? arr : [""];
          } catch {
            this.features_list = [""];
          }
        }
      }
    },

    addFeature() {
      this.features_list.push("");
    },

    removeFeature(i) {
      if (this.features_list.length > 1) {
        this.features_list.splice(i, 1);
      }
    },

    async submitHandler($event) {
      this.set_only_latest_data(true);
      this.setSummerEditor();
      if (this.param_id) {
        const response = await this.update($event);
        if ([200, 201].includes(response?.status)) {
          window.s_alert("Data successfully updated");
          this.$router.push({ name: `Details${this.setup.route_prefix}` });
        }
      } else {
        const response = await this.create($event);
        if ([200, 201].includes(response?.status)) {
          window.s_alert("Data Successfully Created");
          this.$router.push({ name: `All${this.setup.route_prefix}` });
        }
      }
    },

    setSummerEditor() {
      const el = document.getElementById("description");
      if (el) {
        try {
          const markupStr = $("#description").summernote("code");
          const input = document.createElement("input");
          input.setAttribute("name", "description");
          input.value = markupStr;
          el.appendChild(input);
        } catch (e) {
          console.warn("Description editor not available:", e);
        }
      }
    },
  },
};
</script>

<style scoped>
.gap-2 { gap: .5rem; }
</style>
