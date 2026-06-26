<template>
  <div class="tx-app">

    <!-- ── Top bar ─────────────────────────────────────────────── -->
    <top-bar :chips="topBarChips" @select-tab="switchTab" />

    <!-- ── Tab navigation ─────────────────────────────────────── -->
    <nav class="tx-nav">
      <button
        v-for="t in tabs"
        :key="t.key"
        class="tx-tab"
        :class="{ 'tx-tab--active': activeTab === t.key }"
        @click="switchTab(t.key)"
      >
        <i :class="t.icon"></i>
        {{ t.label }}
        <span v-if="t.key !== 'dashboard' && tabLoaded(t.key)" class="tx-tab-count">
          {{ tabTotal(t.key) }}
        </span>
      </button>
    </nav>

    <!-- ── Content ─────────────────────────────────────────────── -->
    <main class="tx-main">

      <!-- Dashboard tab -->
      <dashboard-panel
        v-if="activeTab === 'dashboard'"
        @retry="fetchDashboard"
      />

      <!-- Transaction table tabs -->
      <template v-else>

        <!-- Loading -->
        <div v-if="loading" class="tx-loading">
          <div v-for="n in 8" :key="n" class="tx-skel"></div>
        </div>

        <!-- Error -->
        <div v-else-if="error" class="tx-state">
          <div class="tx-state-icon tx-state-icon--warn">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <p class="tx-state-msg">{{ error }}</p>
          <button class="tx-retry-btn" @click="fetchCurrentTab">
            <i class="fas fa-redo"></i> Retry
          </button>
        </div>

        <!-- Empty -->
        <div v-else-if="!currentRows.length" class="tx-state">
          <div class="tx-state-icon"><i class="fas fa-inbox"></i></div>
          <p class="tx-state-msg">No {{ currentTab.label }} records found.</p>
        </div>

        <!-- Table -->
        <div v-else class="tx-table-wrap">
          <div class="tx-table-scroll">
            <table class="tx-table">
              <thead>
                <tr>
                  <th v-for="col in currentTab.cols" :key="col.key">{{ col.label }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, idx) in currentRows" :key="row.id || idx">
                  <td v-for="col in currentTab.cols" :key="col.key">

                    <span
                      v-if="col.type === 'status'"
                      class="tx-badge"
                      :class="'tx-badge--' + (row[col.key] || 'unknown')"
                    >{{ row[col.key] || '—' }}</span>

                    <span
                      v-else-if="col.type === 'direction'"
                      class="tx-dir"
                      :class="'tx-dir--' + (row[col.key] || '')"
                    >
                      <i :class="row[col.key] === 'credit' ? 'fas fa-long-arrow-alt-down' : 'fas fa-long-arrow-alt-up'"></i>
                      {{ row[col.key] || '—' }}
                    </span>

                    <span v-else-if="col.type === 'amount'" class="tx-amt">
                      {{ fmtAmt(row[col.key]) }}
                    </span>

                    <span v-else>{{ disp(row, col) }}</span>

                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="tx-table-footer">
            <span class="tx-table-footer-info">
              Showing <strong>{{ currentRows.length }}</strong> of
              <strong>{{ tabTotal(activeTab) }}</strong> records
            </span>
            <button
              v-if="currentRows.length < tabTotal(activeTab)"
              class="tx-load-more"
              :disabled="loadingMore"
              @click="loadMoreCurrent"
            >
              <i class="fas fa-chevron-down"></i>
              {{ loadingMore ? 'Loading…' : 'Load More' }}
            </button>
          </div>
        </div>

      </template>
    </main>

  </div>
</template>

<script>
import { mapState, mapActions } from 'pinia';
import { store as txStore }    from './Store';

import TopBar         from './Components/TopBar.vue';
import DashboardPanel from './Components/Dashboard.vue';

import './Css/Style.css';

const TAB_DEFS = [
  {
    key: 'dashboard', label: 'Dashboard', icon: 'fas fa-gauge-high', color: 'indigo',
    endpoint: null, cols: [],
  },
  {
    key: 'incomes', label: 'Income', shortLabel: 'Income', icon: 'fas fa-arrow-circle-down', color: 'green',
    endpoint: 'incomes',
    cols: [
      { key: 'id',                 label: '#'        },
      { key: 'title',              label: 'Title'    },
      { key: 'income_category_id', label: 'Category' },
      { key: 'account_id',         label: 'Account'  },
      { key: 'amount',             label: 'Amount',   type: 'amount' },
      { key: 'received_at',        label: 'Received', type: 'date'   },
      { key: 'status',             label: 'Status',   type: 'status' },
    ],
  },
  {
    key: 'expenses', label: 'Expense', shortLabel: 'Expense', icon: 'fas fa-arrow-circle-up', color: 'red',
    endpoint: 'expenses',
    cols: [
      { key: 'id',                  label: '#'        },
      { key: 'title',               label: 'Title'    },
      { key: 'expense_category_id', label: 'Category' },
      { key: 'account_id',          label: 'Account'  },
      { key: 'amount',              label: 'Amount',  type: 'amount' },
      { key: 'paid_at',             label: 'Paid At', type: 'date'   },
      { key: 'status',              label: 'Status',  type: 'status' },
    ],
  },
  {
    key: 'investors', label: 'Investor History', shortLabel: 'Investors', icon: 'fas fa-user-tie', color: 'purple',
    endpoint: 'investors',
    cols: [
      { key: 'id',                label: '#'        },
      { key: 'name',              label: 'Name'     },
      { key: 'email',             label: 'Email'    },
      { key: 'phone',             label: 'Phone'    },
      { key: 'type',              label: 'Type'     },
      { key: 'equity_percentage', label: 'Equity %' },
      { key: 'joined_at',         label: 'Joined',  type: 'date'   },
      { key: 'status',            label: 'Status',  type: 'status' },
    ],
  },
  {
    key: 'investments', label: 'Investment History', shortLabel: 'Investments', icon: 'fas fa-chart-line', color: 'indigo',
    endpoint: 'investments',
    cols: [
      { key: 'id',          label: '#'         },
      { key: 'investor_id', label: 'Investor'  },
      { key: 'account_id',  label: 'Account'   },
      { key: 'round',       label: 'Round'     },
      { key: 'amount',      label: 'Amount',   type: 'amount' },
      { key: 'type',        label: 'Type'      },
      { key: 'received_at', label: 'Received', type: 'date'   },
      { key: 'status',      label: 'Status',   type: 'status' },
    ],
  },
  {
    key: 'account-transfers', label: 'Account Transfer', shortLabel: 'Transfers', icon: 'fas fa-random', color: 'amber',
    endpoint: 'account-transfers',
    cols: [
      { key: 'id',              label: '#'            },
      { key: 'from_account_id', label: 'From'         },
      { key: 'to_account_id',   label: 'To'           },
      { key: 'amount',          label: 'Amount',      type: 'amount' },
      { key: 'fee',             label: 'Fee',         type: 'amount' },
      { key: 'transferred_at',  label: 'Transferred', type: 'date'   },
      { key: 'status',          label: 'Status',      type: 'status' },
    ],
  },
  {
    key: 'transaction-logs', label: 'Transaction Log', shortLabel: 'Log', icon: 'fas fa-list-alt', color: 'slate',
    endpoint: 'transaction-logs',
    cols: [
      { key: 'id',               label: '#'            },
      { key: 'account_id',       label: 'Account'      },
      { key: 'type',             label: 'Type'         },
      { key: 'direction',        label: 'Direction',   type: 'direction' },
      { key: 'amount',           label: 'Amount',      type: 'amount'    },
      { key: 'balance_before',   label: 'Bal. Before', type: 'amount'    },
      { key: 'balance_after',    label: 'Bal. After',  type: 'amount'    },
      { key: 'transaction_date', label: 'Date',        type: 'date'      },
    ],
  },
];

export default {
  name: 'TransactionPage',
  layout: false,

  components: { TopBar, DashboardPanel },

  data() {
    return { tabs: TAB_DEFS };
  },

  computed: {
    ...mapState(txStore, ['activeTab', 'loading', 'loadingMore', 'error', 'tabRows', 'tabTotal', 'tabLoaded']),

    currentTab() {
      return this.tabs.find(t => t.key === this.activeTab) || this.tabs[0];
    },
    currentRows() {
      return this.tabRows(this.activeTab);
    },
    topBarChips() {
      return this.tabs
        .filter(t => t.key !== 'dashboard')
        .map(t => ({
          key:   t.key,
          label: t.shortLabel || t.label,
          icon:  t.icon,
          color: t.color,
          count: this.tabLoaded(t.key) ? this.tabTotal(t.key) : null,
        }));
    },
  },

  methods: {
    ...mapActions(txStore, ['fetchDashboard', 'fetchTab', 'loadMoreTab', 'selectTab']),

    switchTab(key) {
      this.selectTab(key);
      if (key === 'dashboard') return;
      const tab = this.tabs.find(t => t.key === key);
      if (tab && !this.tabLoaded(key)) {
        this.fetchTab(key, tab.endpoint);
      }
    },

    fetchCurrentTab() {
      const tab = this.currentTab;
      if (tab.endpoint) this.fetchTab(tab.key, tab.endpoint);
    },

    loadMoreCurrent() {
      const tab = this.currentTab;
      if (tab.endpoint) this.loadMoreTab(tab.key, tab.endpoint);
    },

    disp(row, col) {
      const val = row[col.key];
      if (val === null || val === undefined) return '—';
      if (col.type === 'date') return this.fmtDate(val);
      if (typeof val === 'object') return val.name || val.title || val.email || String(val.id ?? '—');
      return String(val);
    },
    fmtAmt(n) {
      if (n === null || n === undefined) return '—';
      return '৳' + Number(n).toLocaleString('en-US');
    },
    fmtDate(d) {
      if (!d) return '—';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); }
      catch { return d; }
    },
  },

  mounted() {
    this.fetchDashboard();
  },
};
</script>
