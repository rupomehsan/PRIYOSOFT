<template>
  <header class="tx-topbar">

    <a href="/todo" class="tx-back">
      <i class="fas fa-arrow-left"></i> Todo Board
    </a>

    <div class="tx-brand">
      <div class="tx-brand-icon"><i class="fas fa-exchange-alt"></i></div>
      <div>
        <h1 class="tx-brand-title">All Transactions</h1>
        <p class="tx-brand-sub">{{ siteName || 'Company' }} · Finance Overview</p>
      </div>
    </div>

    <div class="tx-topbar-chips">
      <div
        v-for="t in chips"
        :key="t.key"
        class="tx-chip"
        :class="'tx-chip--' + t.color"
        :title="t.label"
        @click="$emit('select-tab', t.key)"
      >
        <i :class="t.icon"></i>
        <span class="tx-chip-val">{{ t.count !== null ? t.count : '—' }}</span>
        <span class="tx-chip-lbl">{{ t.label }}</span>
      </div>
    </div>

  </header>
</template>

<script>
import { site_settings_store } from '../../../GlobalStore/site_settings_store';
import { mapActions } from 'pinia';

export default {
  name: 'TransactionTopBar',
  props: {
    chips: { type: Array, default: () => [] },
  },
  emits: ['select-tab'],
  computed: {
    siteName() {
      return site_settings_store().get_setting_value('site_name');
    },
  },
  methods: {
    ...mapActions(site_settings_store, ['get_all_website_settings']),
  },
  mounted() {
    this.get_all_website_settings();
  },
};
</script>
