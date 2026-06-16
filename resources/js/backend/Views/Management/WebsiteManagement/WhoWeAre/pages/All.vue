<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="text-capitalize mb-0">Who We Are</h5>
          <span
            v-if="item && item.id"
            style="padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background-color: #d4edda; color: #155724;"
          >
            <i class="fa fa-check-circle" style="margin-right: 5px"></i> Record exists
          </span>
          <span
            v-else
            style="padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background-color: #fff3cd; color: #856404;"
          >
            <i class="fa fa-plus-circle" style="margin-right: 5px"></i> No record — will create
          </span>
        </div>

        <div class="card-body card_body_fixed_height">
          <div v-if="is_loading" class="d-flex justify-content-center align-items-center py-5">
            <i class="fa fa-spinner fa-spin fa-2x text-muted"></i>
          </div>
          <div v-else class="row">

            <!-- Standard fields -->
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

            <!-- ── Features (JSON) ───────────────────────────────── -->
            <div class="col-md-12 mt-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="font-weight-bold mb-0">Feature Cards</label>
                <button type="button" class="btn btn-outline-success btn-sm" @click="addFeature">
                  <i class="fa fa-plus"></i> Add Feature
                </button>
              </div>

              <div
                v-for="(feat, i) in featuresJson"
                :key="'f' + i"
                class="row align-items-center mb-2 mx-0 p-2 rounded"
                style="background: rgba(0,0,0,.03); border: 1px solid rgba(0,0,0,.08);"
              >
                <div class="col-md-3 px-1">
                  <input
                    :name="`features[${i}][icon]`"
                    v-model="feat.icon"
                    placeholder="fas fa-rocket"
                    class="form-control form-control-sm"
                  />
                  <small class="text-muted">Icon class</small>
                </div>
                <div class="col-md-3 px-1">
                  <input
                    :name="`features[${i}][title]`"
                    v-model="feat.title"
                    placeholder="Fast Delivery"
                    class="form-control form-control-sm"
                  />
                  <small class="text-muted">Title</small>
                </div>
                <div class="col-md-5 px-1">
                  <input
                    :name="`features[${i}][description]`"
                    v-model="feat.description"
                    placeholder="Short description"
                    class="form-control form-control-sm"
                  />
                  <small class="text-muted">Description</small>
                </div>
                <div class="col-md-1 px-1 text-right">
                  <button
                    type="button"
                    class="btn btn-outline-danger btn-sm"
                    @click="featuresJson.splice(i, 1)"
                    title="Remove"
                  >
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>

              <p v-if="!featuresJson.length" class="text-muted small mb-0">No feature cards yet.</p>
            </div>

            <!-- ── Stats (JSON) ──────────────────────────────────── -->
            <div class="col-md-12 mt-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="font-weight-bold mb-0">Stats / Badges</label>
                <button type="button" class="btn btn-outline-success btn-sm" @click="addStat">
                  <i class="fa fa-plus"></i> Add Stat
                </button>
              </div>

              <div
                v-for="(stat, i) in statsJson"
                :key="'s' + i"
                class="row align-items-center mb-2 mx-0 p-2 rounded"
                style="background: rgba(0,0,0,.03); border: 1px solid rgba(0,0,0,.08);"
              >
                <div class="col-md-4 px-1">
                  <input
                    :name="`stats[${i}][stat_value]`"
                    v-model="stat.stat_value"
                    placeholder="50+"
                    class="form-control form-control-sm"
                  />
                  <small class="text-muted">Value</small>
                </div>
                <div class="col-md-7 px-1">
                  <input
                    :name="`stats[${i}][stat_label]`"
                    v-model="stat.stat_label"
                    placeholder="Projects Delivered"
                    class="form-control form-control-sm"
                  />
                  <small class="text-muted">Label</small>
                </div>
                <div class="col-md-1 px-1 text-right">
                  <button
                    type="button"
                    class="btn btn-outline-danger btn-sm"
                    @click="statsJson.splice(i, 1)"
                    title="Remove"
                  >
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>

              <p v-if="!statsJson.length" class="text-muted small mb-0">No stats yet.</p>
            </div>

          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-light btn-square px-5">
            <i class="icon-lock"></i>
            {{ item && item.id ? 'Update' : 'Save' }}
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
import raw_form_fields from "../setup/form_fields";

export default {
  data() {
    return {
      setup,
      form_fields: raw_form_fields.map(f => ({ ...f, value: "" })),
      featuresJson: [],
      statsJson: [],
    };
  },

  async created() {
    await this.loadRecord();
  },

  methods: {
    ...mapActions(store, [
      "get_all",
      "create",
      "update",
      "details",
      "set_only_latest_data",
    ]),

    async loadRecord() {
      await this.get_all();
      const first = this.all?.data?.[0];
      if (first?.slug) {
        await this.details(first.slug);
        this.fillFields();
      }
    },

    fillFields() {
      if (!this.item) return;
      this.form_fields.forEach((field, i) => {
        if (field.name in this.item) {
          this.form_fields[i].value = this.item[field.name] ?? "";
        }
        if (field.name === "description" && this.item.description) {
          try { $("#description").summernote("code", this.item.description); } catch {}
        }
      });
      this.featuresJson = this.parseJson(this.item.features);
      this.statsJson    = this.parseJson(this.item.stats);
    },

    parseJson(val) {
      if (!val) return [];
      if (Array.isArray(val)) return val;
      try { return JSON.parse(val); } catch { return []; }
    },

    addFeature() {
      this.featuresJson.push({ icon: "", title: "", description: "" });
    },

    addStat() {
      this.statsJson.push({ stat_value: "", stat_label: "" });
    },

    setSummerEditor() {
      const el = document.getElementById("description");
      if (!el) return;
      try {
        const markup = $("#description").summernote("code");
        const input = document.createElement("input");
        input.setAttribute("name", "description");
        input.value = markup;
        el.appendChild(input);
      } catch {}
    },

    async submitHandler($event) {
      this.setSummerEditor();
      this.set_only_latest_data(true);

      let response;
      if (this.item?.id) {
        response = await this.update($event);
      } else {
        response = await this.create($event);
      }

      if ([200, 201].includes(response?.status)) {
        window.s_alert(this.item?.id ? "Data successfully updated" : "Data successfully created");
        await this.loadRecord();
      }
    },
  },

  computed: {
    ...mapState(store, ["item", "all", "is_loading"]),
  },
};
</script>
