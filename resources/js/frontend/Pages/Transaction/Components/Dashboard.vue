<template>
  <div class="dash">

    <!-- ── Loading ─────────────────────────────────────────────── -->
    <div v-if="dashLoading" class="dash-loading">
      <div v-for="n in 8" :key="n" class="dash-skel" :style="{ width: n % 2 ? '100%' : '60%' }"></div>
    </div>

    <!-- ── Error ───────────────────────────────────────────────── -->
    <div v-else-if="dashError" class="dash-err">
      <i class="fas fa-exclamation-triangle"></i>
      <p>{{ dashError }}</p>
      <button @click="$emit('retry')">
        <i class="fas fa-redo"></i> Retry
      </button>
    </div>

    <template v-else>

      <!-- ── Company Health Banner ────────────────────────────── -->
      <div class="dash-health" :class="healthClass">
        <div class="dash-health__left">
          <div class="dash-health__badge">
            <i :class="healthIcon"></i>
            <span>{{ healthLabel }}</span>
          </div>
          <h2 class="dash-health__title">Company Financial Status</h2>
          <p class="dash-health__sub">
            Net Balance:
            <strong :class="netBalance >= 0 ? 'text-green' : 'text-red'">
              {{ fmtAmt(Math.abs(netBalance)) }} {{ netBalance >= 0 ? 'surplus' : 'deficit' }}
            </strong>
            &mdash; This month net:
            <strong :class="monthNet >= 0 ? 'text-green' : 'text-red'">
              {{ fmtAmt(Math.abs(monthNet)) }} {{ monthNet >= 0 ? '▲' : '▼' }}
            </strong>
          </p>
        </div>
        <div class="dash-health__right">
          <div class="dash-health__score">
            <svg class="dash-ring" viewBox="0 0 36 36">
              <circle class="dash-ring__bg" cx="18" cy="18" r="15.9"/>
              <circle
                class="dash-ring__fill"
                cx="18" cy="18" r="15.9"
                :stroke="healthColor"
                :stroke-dasharray="healthScore + ' 100'"
              />
            </svg>
            <div class="dash-ring__label">
              <span class="dash-ring__pct">{{ healthScore }}%</span>
              <span class="dash-ring__hint">Income</span>
            </div>
          </div>
          <div class="dash-health__bar-wrap">
            <div class="dash-health__bar-row">
              <span>Income</span>
              <span>{{ fmtAmt(dashData.total_income) }}</span>
            </div>
            <div class="dash-health__bar-track">
              <div class="dash-health__bar-fill dash-health__bar-fill--green"
                :style="{ width: healthScore + '%' }"></div>
            </div>
            <div class="dash-health__bar-row">
              <span>Expense</span>
              <span>{{ fmtAmt(dashData.total_expense) }}</span>
            </div>
            <div class="dash-health__bar-track">
              <div class="dash-health__bar-fill dash-health__bar-fill--red"
                :style="{ width: (100 - healthScore) + '%' }"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── KPI Row 1 ─────────────────────────────────────────── -->
      <div class="dash-kpi-grid">

        <div class="dash-kpi dash-kpi--green">
          <div class="dash-kpi__icon"><i class="fas fa-arrow-trend-up"></i></div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Total Income</p>
            <h3 class="dash-kpi__val">{{ fmtAmt(dashData.total_income) }}</h3>
            <span class="dash-kpi__sub">All time</span>
          </div>
          <div class="dash-kpi__bar" style="--kc:#6ee7b7"></div>
        </div>

        <div class="dash-kpi dash-kpi--red">
          <div class="dash-kpi__icon"><i class="fas fa-arrow-trend-down"></i></div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Total Expense</p>
            <h3 class="dash-kpi__val">{{ fmtAmt(dashData.total_expense) }}</h3>
            <span class="dash-kpi__sub">All time</span>
          </div>
          <div class="dash-kpi__bar" style="--kc:#f87171"></div>
        </div>

        <div class="dash-kpi" :class="netBalance >= 0 ? 'dash-kpi--indigo' : 'dash-kpi--red'">
          <div class="dash-kpi__icon">
            <i :class="netBalance >= 0 ? 'fas fa-sack-dollar' : 'fas fa-triangle-exclamation'"></i>
          </div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Net Balance</p>
            <h3 class="dash-kpi__val" :class="netBalance >= 0 ? 'text-indigo' : 'text-red'">
              {{ netBalance >= 0 ? '' : '-' }}{{ fmtAmt(Math.abs(netBalance)) }}
            </h3>
            <span class="dash-kpi__sub">{{ netBalance >= 0 ? 'Surplus' : 'Deficit' }}</span>
          </div>
          <div class="dash-kpi__bar" :style="{ '--kc': netBalance >= 0 ? '#a5b4fc' : '#f87171' }"></div>
        </div>

        <div class="dash-kpi dash-kpi--amber">
          <div class="dash-kpi__icon"><i class="fas fa-clock-rotate-left"></i></div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Monthly Due</p>
            <h3 class="dash-kpi__val">{{ fmtAmt(dashData.monthly_due) }}</h3>
            <span class="dash-kpi__sub">Pending this month</span>
          </div>
          <div class="dash-kpi__bar" style="--kc:#fbbf24"></div>
        </div>

        <div class="dash-kpi dash-kpi--cyan">
          <div class="dash-kpi__icon"><i class="fas fa-wallet"></i></div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Month Income</p>
            <h3 class="dash-kpi__val">{{ fmtAmt(dashData.current_month_income) }}</h3>
            <span class="dash-kpi__sub">Current month</span>
          </div>
          <div class="dash-kpi__bar" style="--kc:#67e8f9"></div>
        </div>

        <div class="dash-kpi dash-kpi--purple">
          <div class="dash-kpi__icon"><i class="fas fa-receipt"></i></div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Month Expense</p>
            <h3 class="dash-kpi__val">{{ fmtAmt(dashData.current_month_expense) }}</h3>
            <span class="dash-kpi__sub">Current month</span>
          </div>
          <div class="dash-kpi__bar" style="--kc:#c084fc"></div>
        </div>

        <div class="dash-kpi" :class="monthNet >= 0 ? 'dash-kpi--green' : 'dash-kpi--red'">
          <div class="dash-kpi__icon">
            <i :class="monthNet >= 0 ? 'fas fa-chart-line' : 'fas fa-chart-line-down'"></i>
          </div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Month Net</p>
            <h3 class="dash-kpi__val" :class="monthNet >= 0 ? 'text-green' : 'text-red'">
              {{ monthNet >= 0 ? '+' : '-' }}{{ fmtAmt(Math.abs(monthNet)) }}
            </h3>
            <span class="dash-kpi__sub">{{ monthNet >= 0 ? 'Profit' : 'Loss' }} this month</span>
          </div>
          <div class="dash-kpi__bar" :style="{ '--kc': monthNet >= 0 ? '#6ee7b7' : '#f87171' }"></div>
        </div>

        <div class="dash-kpi dash-kpi--blue">
          <div class="dash-kpi__icon"><i class="fas fa-users"></i></div>
          <div class="dash-kpi__body">
            <p class="dash-kpi__lbl">Total Users</p>
            <h3 class="dash-kpi__val">{{ fmt(dashData.total_users) }}</h3>
            <span class="dash-kpi__sub">Registered</span>
          </div>
          <div class="dash-kpi__bar" style="--kc:#60a5fa"></div>
        </div>

      </div>

      <!-- ── Charts Row ─────────────────────────────────────────── -->
      <div class="dash-charts">

        <!-- Line chart: monthly income vs expense -->
        <div class="dash-card dash-card--wide">
          <div class="dash-card__head">
            <div>
              <h5 class="dash-card__title">Monthly Income vs Expense</h5>
              <p class="dash-card__sub">{{ currentYear }} — 12-month trend</p>
            </div>
            <div class="dash-legend">
              <span class="dash-leg"><span class="dash-leg__dot" style="background:#6ee7b7"></span>Income</span>
              <span class="dash-leg"><span class="dash-leg__dot" style="background:#f87171"></span>Expense</span>
            </div>
          </div>
          <div class="dash-card__body">
            <canvas ref="trendChart"></canvas>
          </div>
        </div>

        <!-- Doughnut: income / expense ratio -->
        <div class="dash-card dash-card--narrow">
          <div class="dash-card__head">
            <div>
              <h5 class="dash-card__title">Income / Expense Ratio</h5>
              <p class="dash-card__sub">All time distribution</p>
            </div>
          </div>
          <div class="dash-card__body dash-card__body--center">
            <canvas ref="ratioChart" class="dash-doughnut"></canvas>
            <div class="dash-ratio-legend">
              <div class="dash-ratio-row">
                <span class="dash-ratio-dot" style="background:#6ee7b7"></span>
                <span class="dash-ratio-lbl">Income</span>
                <strong class="dash-ratio-val text-green">{{ fmtAmt(dashData.total_income) }}</strong>
              </div>
              <div class="dash-ratio-row">
                <span class="dash-ratio-dot" style="background:#f87171"></span>
                <span class="dash-ratio-lbl">Expense</span>
                <strong class="dash-ratio-val text-red">{{ fmtAmt(dashData.total_expense) }}</strong>
              </div>
              <div class="dash-ratio-row">
                <span class="dash-ratio-dot" style="background:#fbbf24"></span>
                <span class="dash-ratio-lbl">Monthly Due</span>
                <strong class="dash-ratio-val text-amber">{{ fmtAmt(dashData.monthly_due) }}</strong>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- ── Monthly bar chart ──────────────────────────────────── -->
      <div class="dash-card">
        <div class="dash-card__head">
          <div>
            <h5 class="dash-card__title">Monthly Transaction Summary</h5>
            <p class="dash-card__sub">Bar view — Income vs Expense per month</p>
          </div>
          <div class="dash-legend">
            <span class="dash-leg"><span class="dash-leg__dot" style="background:#60a5fa"></span>Income</span>
            <span class="dash-leg"><span class="dash-leg__dot" style="background:#f87171"></span>Expense</span>
          </div>
        </div>
        <div class="dash-card__body">
          <canvas ref="barChart"></canvas>
        </div>
      </div>

      <!-- ── Financial Summary Table ────────────────────────────── -->
      <div class="dash-card">
        <div class="dash-card__head">
          <h5 class="dash-card__title">Financial Summary</h5>
          <p class="dash-card__sub">Key metrics at a glance</p>
        </div>
        <div class="dash-sum-table-wrap">
          <table class="dash-sum-table">
            <thead>
              <tr>
                <th>Description</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Indicator</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in summaryRows" :key="row.label">
                <td>
                  <div class="dash-sum-info">
                    <span class="dash-sum-dot" :style="{ background: row.color }"></span>
                    {{ row.label }}
                  </div>
                </td>
                <td :class="'dash-sum-amt dash-sum-amt--' + row.amtClass">{{ row.value }}</td>
                <td>
                  <span class="dash-sum-badge" :class="'dash-sum-badge--' + row.badgeClass">
                    {{ row.status }}
                  </span>
                </td>
                <td>
                  <span class="dash-sum-ind" :class="'dash-sum-ind--' + row.indClass">
                    <i :class="row.indIcon"></i> {{ row.indLabel }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </template>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';
import { store as txStore } from '../Store';
import { mapState } from 'pinia';

const MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

export default {
  name: 'TransactionDashboard',
  emits: ['retry'],

  computed: {
    ...mapState(txStore, [
      'dashLoading', 'dashError', 'dashData',
      'netBalance', 'monthNet', 'healthScore',
    ]),

    currentYear() { return new Date().getFullYear(); },

    healthLabel() {
      if (this.netBalance > 0)  return 'Profitable';
      if (this.netBalance === 0) return 'Break Even';
      return 'Operating at a Loss';
    },
    healthClass() {
      if (this.netBalance > 0)  return 'dash-health--profit';
      if (this.netBalance === 0) return 'dash-health--even';
      return 'dash-health--loss';
    },
    healthIcon() {
      if (this.netBalance > 0)  return 'fas fa-circle-check';
      if (this.netBalance === 0) return 'fas fa-circle-minus';
      return 'fas fa-circle-xmark';
    },
    healthColor() {
      if (this.netBalance > 0)  return '#6ee7b7';
      if (this.netBalance === 0) return '#fbbf24';
      return '#f87171';
    },

    summaryRows() {
      const d = this.dashData;
      return [
        {
          label: 'Total Income',       color: '#6ee7b7',
          value: this.fmtAmt(d.total_income),
          amtClass: 'green', badgeClass: 'good',  status: 'Active',
          indClass: 'pos', indIcon: 'fas fa-arrow-up',   indLabel: 'All time',
        },
        {
          label: 'Total Expense',      color: '#f87171',
          value: this.fmtAmt(d.total_expense),
          amtClass: 'red', badgeClass: 'warn',  status: 'Monitor',
          indClass: 'neg', indIcon: 'fas fa-arrow-down', indLabel: 'All time',
        },
        {
          label: 'Net Balance',        color: this.netBalance >= 0 ? '#a5b4fc' : '#f87171',
          value: (this.netBalance >= 0 ? '' : '-') + this.fmtAmt(Math.abs(this.netBalance)),
          amtClass: this.netBalance >= 0 ? 'indigo' : 'red',
          badgeClass: this.netBalance >= 0 ? 'good' : 'danger',
          status: this.netBalance >= 0 ? 'Surplus' : 'Deficit',
          indClass: this.netBalance >= 0 ? 'pos' : 'neg',
          indIcon: this.netBalance >= 0 ? 'fas fa-check' : 'fas fa-exclamation',
          indLabel: this.netBalance >= 0 ? 'Profitable' : 'Loss',
        },
        {
          label: 'This Month Income',  color: '#67e8f9',
          value: this.fmtAmt(d.current_month_income),
          amtClass: 'cyan', badgeClass: 'good', status: 'Active',
          indClass: 'pos', indIcon: 'fas fa-calendar-check', indLabel: 'Current',
        },
        {
          label: 'This Month Expense', color: '#c084fc',
          value: this.fmtAmt(d.current_month_expense),
          amtClass: 'purple', badgeClass: 'warn', status: 'Running',
          indClass: 'neg', indIcon: 'fas fa-calendar', indLabel: 'Current',
        },
        {
          label: 'Month Net',          color: this.monthNet >= 0 ? '#6ee7b7' : '#f87171',
          value: (this.monthNet >= 0 ? '+' : '-') + this.fmtAmt(Math.abs(this.monthNet)),
          amtClass: this.monthNet >= 0 ? 'green' : 'red',
          badgeClass: this.monthNet >= 0 ? 'good' : 'danger',
          status: this.monthNet >= 0 ? 'Profit' : 'Loss',
          indClass: this.monthNet >= 0 ? 'pos' : 'neg',
          indIcon: this.monthNet >= 0 ? 'fas fa-arrow-trend-up' : 'fas fa-arrow-trend-down',
          indLabel: 'This month',
        },
        {
          label: 'Monthly Due',        color: '#fbbf24',
          value: this.fmtAmt(d.monthly_due),
          amtClass: 'amber', badgeClass: 'danger', status: 'Due',
          indClass: 'neu', indIcon: 'fas fa-hourglass-half', indLabel: 'Unsettled',
        },
        {
          label: 'Pending Vouchers',   color: '#fb923c',
          value: String(d.pending_vouchers) + ' items',
          amtClass: 'amber', badgeClass: 'danger', status: 'Pending',
          indClass: 'neu', indIcon: 'fas fa-clock', indLabel: 'Awaiting',
        },
      ];
    },
  },

  watch: {
    dashData: {
      handler() { this.$nextTick(() => this.buildCharts()); },
      deep: true,
    },
  },

  mounted() {
    this.$nextTick(() => this.buildCharts());
  },

  beforeUnmount() {
    Object.values(this._charts || {}).forEach(c => c?.destroy());
  },

  methods: {
    fmtAmt(n) {
      if (n === null || n === undefined) return '—';
      return '৳' + Number(n).toLocaleString('en-US');
    },
    fmt(n) {
      return Number(n || 0).toLocaleString('en-US');
    },

    buildCharts() {
      if (!this._charts) this._charts = {};
      Object.values(this._charts).forEach(c => c?.destroy());
      this._charts = {};
      this.buildTrendChart();
      this.buildRatioChart();
      this.buildBarChart();
    },

    chartDefaults() {
      return {
        tc:  '#475569',
        gc:  'rgba(255,255,255,.06)',
        tt:  {
          backgroundColor: 'rgba(2,6,23,.95)',
          titleColor:  '#e2e8f0',
          bodyColor:   '#94a3b8',
          borderColor: 'rgba(255,255,255,.1)',
          borderWidth: 1,
          padding: 10,
        },
      };
    },

    buildTrendChart() {
      const el = this.$refs.trendChart;
      if (!el) return;
      const { tc, gc, tt } = this.chartDefaults();
      this._charts.trend = new Chart(el, {
        type: 'line',
        data: {
          labels: MONTHS,
          datasets: [
            {
              label: 'Income',
              data: this.dashData.monthly_income,
              borderColor: '#6ee7b7', backgroundColor: 'rgba(110,231,183,.1)',
              borderWidth: 2.5, fill: true, tension: 0.4,
              pointRadius: 4, pointBackgroundColor: '#6ee7b7',
              pointBorderColor: 'rgba(2,6,23,.9)', pointBorderWidth: 2,
            },
            {
              label: 'Expense',
              data: this.dashData.monthly_expense,
              borderColor: '#f87171', backgroundColor: 'rgba(248,113,113,.07)',
              borderWidth: 2.5, fill: true, tension: 0.4,
              pointRadius: 4, pointBackgroundColor: '#f87171',
              pointBorderColor: 'rgba(2,6,23,.9)', pointBorderWidth: 2,
            },
          ],
        },
        options: {
          responsive: true, maintainAspectRatio: true,
          plugins: { legend: { display: false }, tooltip: tt },
          scales: {
            y: { beginAtZero: true, ticks: { color: tc }, grid: { color: gc } },
            x: { ticks: { color: tc }, grid: { display: false } },
          },
        },
      });
    },

    buildRatioChart() {
      const el = this.$refs.ratioChart;
      if (!el) return;
      const { tt } = this.chartDefaults();
      const inc = Number(this.dashData.total_income)  || 0;
      const exp = Number(this.dashData.total_expense) || 0;
      const due = Number(this.dashData.monthly_due)   || 0;
      this._charts.ratio = new Chart(el, {
        type: 'doughnut',
        data: {
          labels: ['Income', 'Expense', 'Due'],
          datasets: [{
            data: [inc || 1, exp || 1, due || 0],
            backgroundColor: ['rgba(110,231,183,.8)', 'rgba(248,113,113,.8)', 'rgba(251,191,36,.8)'],
            borderColor: 'rgba(2,6,23,.9)',
            borderWidth: 3, hoverOffset: 6,
          }],
        },
        options: {
          responsive: true, maintainAspectRatio: true, cutout: '70%',
          plugins: { legend: { display: false }, tooltip: tt },
        },
      });
    },

    buildBarChart() {
      const el = this.$refs.barChart;
      if (!el) return;
      const { tc, gc, tt } = this.chartDefaults();
      this._charts.bar = new Chart(el, {
        type: 'bar',
        data: {
          labels: MONTHS,
          datasets: [
            {
              label: 'Income',
              data: this.dashData.monthly_income,
              backgroundColor: 'rgba(96,165,250,.7)',
              borderRadius: 5, borderSkipped: false,
            },
            {
              label: 'Expense',
              data: this.dashData.monthly_expense,
              backgroundColor: 'rgba(248,113,113,.7)',
              borderRadius: 5, borderSkipped: false,
            },
          ],
        },
        options: {
          responsive: true, maintainAspectRatio: true,
          plugins: { legend: { display: false }, tooltip: tt },
          scales: {
            y: { beginAtZero: true, ticks: { color: tc }, grid: { color: gc } },
            x: { ticks: { color: tc }, grid: { display: false } },
          },
        },
      });
    },
  },
};
</script>

<style scoped>
.dash { display: flex; flex-direction: column; gap: 1.25rem; }

/* ── Skeleton ── */
.dash-loading { display: flex; flex-direction: column; gap: .75rem; }
.dash-skel {
  height: 48px; background: rgba(255,255,255,.04); border-radius: 12px;
  animation: dash-pulse 1.6s ease-in-out infinite;
}
@keyframes dash-pulse { 0%,100%{opacity:.2} 50%{opacity:.5} }

/* ── Error ── */
.dash-err {
  display: flex; flex-direction: column; align-items: center;
  gap: .75rem; padding: 3rem; text-align: center; color: #f87171;
}
.dash-err i   { font-size: 2rem; }
.dash-err p   { margin: 0; font-size: .9rem; color: #94a3b8; }
.dash-err button {
  background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25);
  color: #f87171; font-size: .78rem; font-weight: 700;
  padding: .45rem 1rem; border-radius: 10px; cursor: pointer;
}

/* ── Health banner ── */
.dash-health {
  border-radius: 18px; padding: 1.5rem 1.75rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
  border: 1px solid rgba(255,255,255,.08);
  background: rgba(255,255,255,.03);
}
.dash-health--profit {
  border-color: rgba(110,231,183,.2);
  background: linear-gradient(135deg, rgba(110,231,183,.06) 0%, rgba(6,182,212,.04) 100%);
}
.dash-health--loss {
  border-color: rgba(248,113,113,.2);
  background: linear-gradient(135deg, rgba(248,113,113,.06) 0%, rgba(239,68,68,.04) 100%);
}
.dash-health--even {
  border-color: rgba(251,191,36,.2);
  background: linear-gradient(135deg, rgba(251,191,36,.06) 0%, rgba(245,158,11,.04) 100%);
}
.dash-health__badge {
  display: inline-flex; align-items: center; gap: .4rem;
  font-size: .65rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase;
  margin-bottom: .5rem;
}
.dash-health--profit .dash-health__badge { color: #6ee7b7; }
.dash-health--loss   .dash-health__badge { color: #f87171; }
.dash-health--even   .dash-health__badge { color: #fbbf24; }
.dash-health__title {
  font-size: 1.2rem; font-weight: 900; color: #f1f5f9; margin: 0 0 .4rem;
}
.dash-health__sub { font-size: .82rem; color: #64748b; margin: 0; }
.text-green  { color: #6ee7b7; }
.text-red    { color: #f87171; }
.text-indigo { color: #a5b4fc; }
.text-amber  { color: #fbbf24; }
.text-cyan   { color: #67e8f9; }

/* Ring gauge */
.dash-health__right {
  display: flex; align-items: center; gap: 1.5rem; flex-shrink: 0; flex-wrap: wrap;
}
.dash-health__score { position: relative; width: 96px; height: 96px; flex-shrink: 0; }
.dash-ring {
  width: 96px; height: 96px;
  transform: rotate(-90deg);
  position: absolute; inset: 0;
}
.dash-ring__bg   { fill: none; stroke: rgba(255,255,255,.07); stroke-width: 3.5; }
.dash-ring__fill { fill: none; stroke-width: 3.5; stroke-linecap: round; stroke-dashoffset: 0; transition: stroke-dasharray .8s ease; }
.dash-ring__label {
  position: absolute; inset: 0;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
}
.dash-ring__pct  { font-size: 1.25rem; font-weight: 900; color: #e2e8f0; line-height: 1; }
.dash-ring__hint { font-size: .58rem; color: #475569; text-transform: uppercase; letter-spacing: .5px; }

/* Health bars */
.dash-health__bar-wrap { display: flex; flex-direction: column; gap: .35rem; min-width: 160px; }
.dash-health__bar-row {
  display: flex; justify-content: space-between;
  font-size: .68rem; color: #64748b; font-weight: 600;
}
.dash-health__bar-track {
  height: 6px; background: rgba(255,255,255,.07); border-radius: 20px; overflow: hidden;
}
.dash-health__bar-fill {
  height: 100%; border-radius: 20px; transition: width .8s ease;
}
.dash-health__bar-fill--green { background: linear-gradient(90deg, #6ee7b7, #34d399); }
.dash-health__bar-fill--red   { background: linear-gradient(90deg, #f87171, #ef4444); }

/* ── KPI Grid ── */
.dash-kpi-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1px;
  background: rgba(255,255,255,.06);
  border-radius: 14px;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,.06);
}
.dash-kpi {
  position: relative;
  background: rgba(5,5,18,.97);
  padding: 1.1rem 1.25rem 1.35rem;
  display: flex; align-items: flex-start; gap: 1rem;
  overflow: hidden;
  transition: background .2s;
}
.dash-kpi:hover { background: rgba(255,255,255,.03); }

.dash-kpi__icon {
  width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: .95rem; color: #fff;
}
.dash-kpi--green  .dash-kpi__icon { background: linear-gradient(135deg,#10b981,#059669); }
.dash-kpi--red    .dash-kpi__icon { background: linear-gradient(135deg,#ef4444,#dc2626); }
.dash-kpi--indigo .dash-kpi__icon { background: linear-gradient(135deg,#6366f1,#4f46e5); }
.dash-kpi--amber  .dash-kpi__icon { background: linear-gradient(135deg,#f59e0b,#d97706); }
.dash-kpi--cyan   .dash-kpi__icon { background: linear-gradient(135deg,#06b6d4,#0891b2); }
.dash-kpi--purple .dash-kpi__icon { background: linear-gradient(135deg,#a855f7,#9333ea); }
.dash-kpi--blue   .dash-kpi__icon { background: linear-gradient(135deg,#3b82f6,#2563eb); }

.dash-kpi__body { flex: 1; min-width: 0; }
.dash-kpi__lbl { font-size: .68rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .5px; margin: 0 0 .3rem; }
.dash-kpi__val { font-size: 1.15rem; font-weight: 900; color: #e2e8f0; margin: 0 0 .2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dash-kpi__sub { font-size: .62rem; color: #334155; }

.dash-kpi__bar {
  position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
  background: var(--kc, #6366f1); opacity: .6;
}

/* ── Charts ── */
.dash-charts {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1rem;
}
.dash-card {
  background: rgba(255,255,255,.03);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 14px;
  overflow: hidden;
}
.dash-card--wide  { /* default */ }
.dash-card--narrow { /* auto size */ }

.dash-card__head {
  padding: 1rem 1.25rem .75rem;
  border-bottom: 1px solid rgba(255,255,255,.05);
  display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
}
.dash-card__title { font-size: .9rem; font-weight: 800; color: #e2e8f0; margin: 0 0 .15rem; }
.dash-card__sub   { font-size: .68rem; color: #475569; margin: 0; }
.dash-card__body  { padding: 1rem 1.25rem 1.25rem; }
.dash-card__body--center {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
}

.dash-legend { display: flex; align-items: center; gap: .75rem; }
.dash-leg {
  display: flex; align-items: center; gap: .35rem;
  font-size: .68rem; font-weight: 600; color: #475569;
}
.dash-leg__dot { width: 8px; height: 8px; border-radius: 2px; flex-shrink: 0; }

.dash-doughnut { max-width: 160px; max-height: 160px; margin-bottom: .75rem; }

.dash-ratio-legend { display: flex; flex-direction: column; gap: .6rem; width: 100%; }
.dash-ratio-row    { display: flex; align-items: center; gap: .6rem; font-size: .78rem; }
.dash-ratio-dot    { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.dash-ratio-lbl    { flex: 1; color: #64748b; }
.dash-ratio-val    { font-weight: 800; font-size: .82rem; }
.text-green  { color: #6ee7b7; }
.text-red    { color: #f87171; }
.text-amber  { color: #fbbf24; }

/* ── Summary table ── */
.dash-sum-table-wrap { overflow-x: auto; }
.dash-sum-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
.dash-sum-table thead tr {
  background: rgba(255,255,255,.03);
  border-bottom: 1px solid rgba(255,255,255,.06);
}
.dash-sum-table th {
  padding: .65rem 1rem; text-align: left;
  font-size: .62rem; font-weight: 800; letter-spacing: 1px;
  text-transform: uppercase; color: #334155;
}
.dash-sum-table td {
  padding: .75rem 1rem; color: #94a3b8;
  border-bottom: 1px solid rgba(255,255,255,.04);
}
.dash-sum-table tbody tr:last-child td { border-bottom: none; }
.dash-sum-table tbody tr:hover td { background: rgba(255,255,255,.02); }

.dash-sum-info { display: flex; align-items: center; gap: .6rem; }
.dash-sum-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

.dash-sum-amt          { font-weight: 800; font-variant-numeric: tabular-nums; }
.dash-sum-amt--green   { color: #6ee7b7; }
.dash-sum-amt--red     { color: #f87171; }
.dash-sum-amt--indigo  { color: #a5b4fc; }
.dash-sum-amt--amber   { color: #fbbf24; }
.dash-sum-amt--cyan    { color: #67e8f9; }
.dash-sum-amt--purple  { color: #c084fc; }

.dash-sum-badge { display: inline-block; padding: .15rem .55rem; border-radius: 20px; font-size: .62rem; font-weight: 700; }
.dash-sum-badge--good   { background: rgba(110,231,183,.12); color: #6ee7b7; }
.dash-sum-badge--warn   { background: rgba(251,191,36,.1);   color: #fbbf24; }
.dash-sum-badge--danger { background: rgba(248,113,113,.1);  color: #f87171; }

.dash-sum-ind { display: inline-flex; align-items: center; gap: .3rem; font-size: .72rem; font-weight: 700; }
.dash-sum-ind--pos { color: #6ee7b7; }
.dash-sum-ind--neg { color: #f87171; }
.dash-sum-ind--neu { color: #64748b; }

/* ── Responsive ── */
@media (max-width: 900px) {
  .dash-kpi-grid  { grid-template-columns: repeat(2, 1fr); }
  .dash-charts    { grid-template-columns: 1fr; }
}
@media (max-width: 500px) {
  .dash-kpi-grid  { grid-template-columns: 1fr 1fr; }
  .dash-health    { flex-direction: column; }
  .dash-health__right { align-self: flex-start; }
}
</style>
