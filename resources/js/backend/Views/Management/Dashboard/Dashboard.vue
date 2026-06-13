<template>
  <div class="db-root" :class="{ 'dark-theme': isDarkMode }">

    <!-- ── Row 1: KPI Cards ──────────────────────────────────────────── -->
    <div class="row g-0 mb-4 kpi-grid">

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-income">
          <div class="kpi-icon"><i class="fas fa-arrow-trend-up"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">মোট আয় <span class="kpi-en">Total Income</span></p>
            <h3 class="kpi-value">৳ {{ fmt(data.total_income) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#10b981"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-expense">
          <div class="kpi-icon"><i class="fas fa-arrow-trend-down"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">মোট ব্যয় <span class="kpi-en">Total Expense</span></p>
            <h3 class="kpi-value">৳ {{ fmt(data.total_expense) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#ef4444"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-due">
          <div class="kpi-icon"><i class="fas fa-clock-rotate-left"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">মাসিক বাকি <span class="kpi-en">Monthly Due</span></p>
            <h3 class="kpi-value">৳ {{ fmt(data.monthly_due) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#f59e0b"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-month-income">
          <div class="kpi-icon"><i class="fas fa-wallet"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">চলতি মাসের আয় <span class="kpi-en">Month Income</span></p>
            <h3 class="kpi-value">৳ {{ fmt(data.current_month_income) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#06b6d4"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-month-expense">
          <div class="kpi-icon"><i class="fas fa-receipt"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">চলতি মাসের ব্যয় <span class="kpi-en">Month Expense</span></p>
            <h3 class="kpi-value">৳ {{ fmt(data.current_month_expense) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#a855f7"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-users">
          <div class="kpi-icon"><i class="fas fa-users"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">ব্যবহারকারী <span class="kpi-en">Users</span></p>
            <h3 class="kpi-value">{{ fmt(data.total_users, false) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#3b82f6"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-app">
          <div class="kpi-icon"><i class="fas fa-file-lines"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">আবেদন <span class="kpi-en">Application</span></p>
            <h3 class="kpi-value">{{ fmt(data.total_applications, false) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#8b5cf6"></div>
        </div>
      </div>

      <div class="col-6 col-sm-4 col-lg-3">
        <div class="kpi-card kpi-voucher">
          <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
          <div class="kpi-body">
            <p class="kpi-label">পেন্ডিং ভাউচার <span class="kpi-en">Pending Vouchers</span></p>
            <h3 class="kpi-value">{{ fmt(data.pending_vouchers, false) }}</h3>
          </div>
          <div class="kpi-bar" style="--c:#f97316"></div>
        </div>
      </div>

    </div>

    <!-- ── Row 2: Income vs Expense + Ratio ─────────────────────────── -->
    <div class="row g-3 mb-4">

      <!-- Income vs Expense Trend -->
      <div class="col-12 col-lg-8">
        <div class="db-card">
          <div class="db-card-head">
            <div>
              <h5 class="db-card-title">আয় ও ব্যয়ের প্রবণতা</h5>
              <p class="db-card-sub">Income vs Expense — Monthly Trend</p>
            </div>
            <div class="chart-legend">
              <span class="leg-item"><span class="leg-dot" style="background:#10b981"></span>আয়</span>
              <span class="leg-item"><span class="leg-dot" style="background:#ef4444"></span>ব্যয়</span>
            </div>
          </div>
          <div class="db-card-body">
            <canvas ref="trendChart" style="max-height:280px"></canvas>
          </div>
        </div>
      </div>

      <!-- Income / Expense Ratio -->
      <div class="col-12 col-lg-4">
        <div class="db-card h-100">
          <div class="db-card-head">
            <div>
              <h5 class="db-card-title">আয়-ব্যয় অনুপাত</h5>
              <p class="db-card-sub">Income / Expense Ratio</p>
            </div>
          </div>
          <div class="db-card-body d-flex flex-column align-items-center justify-content-center">
            <canvas ref="ratioChart" style="max-width:200px;max-height:200px"></canvas>
            <div class="ratio-legend mt-3">
              <div class="ratio-item">
                <span class="ratio-dot" style="background:#10b981"></span>
                <span class="ratio-label">আয় (Income)</span>
                <strong class="ratio-val">৳ {{ fmt(data.total_income) }}</strong>
              </div>
              <div class="ratio-item">
                <span class="ratio-dot" style="background:#ef4444"></span>
                <span class="ratio-label">ব্যয় (Expense)</span>
                <strong class="ratio-val">৳ {{ fmt(data.total_expense) }}</strong>
              </div>
              <div class="ratio-item">
                <span class="ratio-dot" style="background:#f59e0b"></span>
                <span class="ratio-label">বাকি (Due)</span>
                <strong class="ratio-val">৳ {{ fmt(data.monthly_due) }}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Row 3: Monthly Bar + Application Status ───────────────────── -->
    <div class="row g-3 mb-4">

      <!-- Monthly Transactions Bar -->
      <div class="col-12 col-lg-8">
        <div class="db-card">
          <div class="db-card-head">
            <div>
              <h5 class="db-card-title">মাসিক লেনদেন</h5>
              <p class="db-card-sub">Monthly Transaction Summary</p>
            </div>
            <div class="chart-legend">
              <span class="leg-item"><span class="leg-dot" style="background:#3b82f6"></span>আয়</span>
              <span class="leg-item"><span class="leg-dot" style="background:#f87171"></span>ব্যয়</span>
            </div>
          </div>
          <div class="db-card-body">
            <canvas ref="barChart" style="max-height:260px"></canvas>
          </div>
        </div>
      </div>

      <!-- Application & Voucher Status -->
      <div class="col-12 col-lg-4">
        <div class="db-card h-100">
          <div class="db-card-head">
            <div>
              <h5 class="db-card-title">আবেদন অবস্থা</h5>
              <p class="db-card-sub">Application & Voucher Status</p>
            </div>
          </div>
          <div class="db-card-body d-flex flex-column align-items-center justify-content-center">
            <canvas ref="appChart" style="max-width:180px;max-height:180px"></canvas>
            <div class="ratio-legend mt-3 w-100">
              <div class="ratio-item">
                <span class="ratio-dot" style="background:#8b5cf6"></span>
                <span class="ratio-label">মোট আবেদন</span>
                <strong class="ratio-val">{{ fmt(data.total_applications, false) }}</strong>
              </div>
              <div class="ratio-item">
                <span class="ratio-dot" style="background:#f97316"></span>
                <span class="ratio-label">পেন্ডিং ভাউচার</span>
                <strong class="ratio-val">{{ fmt(data.pending_vouchers, false) }}</strong>
              </div>
              <div class="ratio-item">
                <span class="ratio-dot" style="background:#3b82f6"></span>
                <span class="ratio-label">মোট ব্যবহারকারী</span>
                <strong class="ratio-val">{{ fmt(data.total_users, false) }}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Row 4: Financial Summary Table ───────────────────────────── -->
    <div class="row g-3">
      <div class="col-12">
        <div class="db-card">
          <div class="db-card-head">
            <div>
              <h5 class="db-card-title">আর্থিক সারসংক্ষেপ</h5>
              <p class="db-card-sub">Financial Summary Overview</p>
            </div>
          </div>
          <div class="table-responsive">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>বিবরণ / Description</th>
                  <th>পরিমাণ / Amount</th>
                  <th>স্থিতি / Status</th>
                  <th>পরিবর্তন / Change</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="tbl-info">
                      <span class="tbl-dot" style="background:#10b981"></span>
                      <span>মোট আয় (Total Income)</span>
                    </div>
                  </td>
                  <td class="tbl-amount income">৳ {{ fmt(data.total_income) }}</td>
                  <td><span class="badge-status status-good">ভালো</span></td>
                  <td><span class="chng positive"><i class="fas fa-arrow-up"></i> সক্রিয়</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="tbl-info">
                      <span class="tbl-dot" style="background:#ef4444"></span>
                      <span>মোট ব্যয় (Total Expense)</span>
                    </div>
                  </td>
                  <td class="tbl-amount expense">৳ {{ fmt(data.total_expense) }}</td>
                  <td><span class="badge-status status-warn">নজরদারি</span></td>
                  <td><span class="chng negative"><i class="fas fa-arrow-down"></i> ব্যয়িত</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="tbl-info">
                      <span class="tbl-dot" style="background:#06b6d4"></span>
                      <span>চলতি মাসের আয় (Month Income)</span>
                    </div>
                  </td>
                  <td class="tbl-amount income">৳ {{ fmt(data.current_month_income) }}</td>
                  <td><span class="badge-status status-good">সক্রিয়</span></td>
                  <td><span class="chng positive"><i class="fas fa-arrow-up"></i> চলতি মাস</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="tbl-info">
                      <span class="tbl-dot" style="background:#a855f7"></span>
                      <span>চলতি মাসের ব্যয় (Month Expense)</span>
                    </div>
                  </td>
                  <td class="tbl-amount expense">৳ {{ fmt(data.current_month_expense) }}</td>
                  <td><span class="badge-status status-warn">চলমান</span></td>
                  <td><span class="chng negative"><i class="fas fa-arrow-down"></i> চলতি মাস</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="tbl-info">
                      <span class="tbl-dot" style="background:#f59e0b"></span>
                      <span>মাসিক বাকি (Monthly Due)</span>
                    </div>
                  </td>
                  <td class="tbl-amount due">৳ {{ fmt(data.monthly_due) }}</td>
                  <td><span class="badge-status status-danger">বাকি</span></td>
                  <td><span class="chng neutral"><i class="fas fa-minus"></i> অমীমাংসিত</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="tbl-info">
                      <span class="tbl-dot" style="background:#f97316"></span>
                      <span>পেন্ডিং ভাউচার (Pending Vouchers)</span>
                    </div>
                  </td>
                  <td class="tbl-amount due">{{ fmt(data.pending_vouchers, false) }} টি</td>
                  <td><span class="badge-status status-danger">পেন্ডিং</span></td>
                  <td><span class="chng neutral"><i class="fas fa-hourglass"></i> অনুমোদন বাকি</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import Chart from "chart.js/auto";

const MONTHS_BN = ["জানু", "ফেব্রু", "মার্চ", "এপ্রিল", "মে", "জুন",
                   "জুলাই", "আগস্ট", "সেপ্টে", "অক্টো", "নভে", "ডিসে"];

export default {
  name: "Dashboard",

  data() {
    return {
      data: {
        total_income: 0, total_expense: 0, monthly_due: 0,
        current_month_income: 0, current_month_expense: 0,
        total_users: 0, total_applications: 0, pending_vouchers: 0,
        monthly_income:  [0,0,0,0,0,0,0,0,0,0,0,0],
        monthly_expense: [0,0,0,0,0,0,0,0,0,0,0,0],
      },
      isDarkMode: false,
      _charts: {},
    };
  },

  mounted() {
    this.initDarkMode();
    this.fetchData();
  },

  beforeUnmount() {
    Object.values(this._charts).forEach(c => c?.destroy());
  },

  methods: {
    fmt(val, currency = true) {
      const n = Number(val) || 0;
      if (!currency) return n.toLocaleString("bn-BD");
      return n.toLocaleString("bn-BD");
    },

    initDarkMode() {
      if (window.themeManager) {
        this.isDarkMode = window.themeManager.isDarkTheme();
        window.addEventListener("themechange", (e) => {
          this.isDarkMode = e.detail.theme === "dark-theme";
          this.buildCharts();
        });
      }
    },

    async fetchData() {
      try {
        const res = await axios.get("get-all-dashboard-data");
        if (res.status === 200) {
          this.data = { ...this.data, ...res.data.data };
        }
      } catch (e) {
        console.error("Dashboard data fetch failed:", e);
      } finally {
        this.$nextTick(() => this.buildCharts());
      }
    },

    buildCharts() {
      Object.values(this._charts).forEach(c => c?.destroy());
      this._charts = {};
      this.buildTrendChart();
      this.buildRatioChart();
      this.buildBarChart();
      this.buildAppChart();
    },

    // helpers
    textColor()   { return this.isDarkMode ? "#d1d5db" : "#6b7280"; },
    gridColor()   { return this.isDarkMode ? "rgba(75,85,99,.2)" : "rgba(0,0,0,.06)"; },
    tooltipTheme(){ return { backgroundColor: this.isDarkMode ? "#1e293b" : "#fff",
                              titleColor: this.isDarkMode ? "#f3f4f6" : "#111827",
                              bodyColor:  this.isDarkMode ? "#d1d5db" : "#374151",
                              borderColor: this.isDarkMode ? "#334155" : "#e5e7eb",
                              borderWidth: 1 }; },

    buildTrendChart() {
      const el = this.$refs.trendChart;
      if (!el) return;
      const tc = this.textColor(), gc = this.gridColor(), tt = this.tooltipTheme();
      this._charts.trend = new Chart(el, {
        type: "line",
        data: {
          labels: MONTHS_BN,
          datasets: [
            {
              label: "আয়",
              data: this.data.monthly_income,
              borderColor: "#10b981",
              backgroundColor: "rgba(16,185,129,.1)",
              borderWidth: 2.5, fill: true, tension: 0.4,
              pointRadius: 4, pointBackgroundColor: "#10b981",
              pointBorderColor: this.isDarkMode ? "#1e293b" : "#fff",
              pointBorderWidth: 2,
            },
            {
              label: "ব্যয়",
              data: this.data.monthly_expense,
              borderColor: "#ef4444",
              backgroundColor: "rgba(239,68,68,.08)",
              borderWidth: 2.5, fill: true, tension: 0.4,
              pointRadius: 4, pointBackgroundColor: "#ef4444",
              pointBorderColor: this.isDarkMode ? "#1e293b" : "#fff",
              pointBorderWidth: 2,
            },
          ],
        },
        options: {
          responsive: true, maintainAspectRatio: true,
          plugins: { legend: { display: false }, tooltip: { ...tt } },
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
      const tt = this.tooltipTheme();
      const income  = Number(this.data.total_income)  || 1;
      const expense = Number(this.data.total_expense) || 1;
      const due     = Number(this.data.monthly_due)   || 0;
      this._charts.ratio = new Chart(el, {
        type: "doughnut",
        data: {
          labels: ["আয়", "ব্যয়", "বাকি"],
          datasets: [{
            data: [income, expense, due],
            backgroundColor: ["#10b981", "#ef4444", "#f59e0b"],
            borderColor: this.isDarkMode ? "#1e293b" : "#fff",
            borderWidth: 3, hoverOffset: 6,
          }],
        },
        options: {
          responsive: true, maintainAspectRatio: true, cutout: "68%",
          plugins: { legend: { display: false }, tooltip: { ...tt } },
        },
      });
    },

    buildBarChart() {
      const el = this.$refs.barChart;
      if (!el) return;
      const tc = this.textColor(), gc = this.gridColor(), tt = this.tooltipTheme();
      this._charts.bar = new Chart(el, {
        type: "bar",
        data: {
          labels: MONTHS_BN,
          datasets: [
            {
              label: "আয়",
              data: this.data.monthly_income,
              backgroundColor: "rgba(59,130,246,.75)",
              borderRadius: 5, borderSkipped: false,
            },
            {
              label: "ব্যয়",
              data: this.data.monthly_expense,
              backgroundColor: "rgba(248,113,113,.75)",
              borderRadius: 5, borderSkipped: false,
            },
          ],
        },
        options: {
          responsive: true, maintainAspectRatio: true,
          plugins: { legend: { display: false }, tooltip: { ...tt } },
          scales: {
            y: { beginAtZero: true, ticks: { color: tc }, grid: { color: gc } },
            x: { ticks: { color: tc }, grid: { display: false } },
          },
        },
      });
    },

    buildAppChart() {
      const el = this.$refs.appChart;
      if (!el) return;
      const tt = this.tooltipTheme();
      const apps     = Number(this.data.total_applications) || 1;
      const vouchers = Number(this.data.pending_vouchers)   || 1;
      const users    = Number(this.data.total_users)        || 1;
      this._charts.app = new Chart(el, {
        type: "doughnut",
        data: {
          labels: ["আবেদন", "পেন্ডিং ভাউচার", "ব্যবহারকারী"],
          datasets: [{
            data: [apps, vouchers, users],
            backgroundColor: ["#8b5cf6", "#f97316", "#3b82f6"],
            borderColor: this.isDarkMode ? "#1e293b" : "#fff",
            borderWidth: 3, hoverOffset: 6,
          }],
        },
        options: {
          responsive: true, maintainAspectRatio: true, cutout: "65%",
          plugins: { legend: { display: false }, tooltip: { ...tt } },
        },
      });
    },
  },
};
</script>

<style scoped>
.db-root {
  background: #f1f5f9;
  min-height: 100%;
  transition: background .3s;
}
.dark-theme { background: #0f172a; }

/* ── KPI Grid — gapless flush grid ── */
.kpi-grid .col-6,
.kpi-grid .col-sm-4,
.kpi-grid [class*="col-"] {
  padding: 0;
}

/* ── KPI Cards ── */
.kpi-card {
  position: relative;
  background: #fff;
  border-radius: 0;
  padding: 18px 16px 14px;
  display: flex;
  align-items: flex-start;
  gap: 14px;
  box-shadow: none;
  border: 1px solid #e2e8f0;
  border-right: none;
  border-bottom: none;
  overflow: hidden;
  transition: background .2s;
}
/* restore right border on every 4th card (last in row) */
.kpi-grid > div:nth-child(4n) .kpi-card,
.kpi-grid > div:last-child .kpi-card { border-right: 1px solid #e2e8f0; }
/* restore bottom border on last row (cards 5-8) */
.kpi-grid > div:nth-child(n+5) .kpi-card { border-bottom: 1px solid #e2e8f0; }

/* outer corner rounding */
.kpi-grid > div:nth-child(1) .kpi-card  { border-radius: 12px 0 0 0; }
.kpi-grid > div:nth-child(4) .kpi-card  { border-radius: 0 12px 0 0; }
.kpi-grid > div:nth-child(5) .kpi-card  { border-radius: 0 0 0 12px; }
.kpi-grid > div:nth-child(8) .kpi-card  { border-radius: 0 0 12px 0; }

.kpi-card:hover { background: #f8fafc; }

.dark-theme .kpi-card {
  background: #1e293b;
  border-color: #334155;
}
.dark-theme .kpi-card:hover { background: #273449; }
.dark-theme .kpi-grid > div:nth-child(4n) .kpi-card,
.dark-theme .kpi-grid > div:last-child .kpi-card { border-right-color: #334155; }
.dark-theme .kpi-grid > div:nth-child(n+5) .kpi-card { border-bottom-color: #334155; }

.kpi-bar {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: var(--c);
}

.kpi-icon {
  width: 44px; height: 44px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
  color: #fff;
}

.kpi-income .kpi-icon    { background: linear-gradient(135deg,#10b981,#059669); }
.kpi-expense .kpi-icon   { background: linear-gradient(135deg,#ef4444,#dc2626); }
.kpi-due .kpi-icon       { background: linear-gradient(135deg,#f59e0b,#d97706); }
.kpi-month-income .kpi-icon  { background: linear-gradient(135deg,#06b6d4,#0891b2); }
.kpi-month-expense .kpi-icon { background: linear-gradient(135deg,#a855f7,#9333ea); }
.kpi-users .kpi-icon     { background: linear-gradient(135deg,#3b82f6,#2563eb); }
.kpi-app .kpi-icon       { background: linear-gradient(135deg,#8b5cf6,#7c3aed); }
.kpi-voucher .kpi-icon   { background: linear-gradient(135deg,#f97316,#ea580c); }

.kpi-body { flex: 1; min-width: 0; }

.kpi-label {
  font-size: 12px; font-weight: 600;
  color: #64748b; margin: 0 0 4px;
  line-height: 1.3;
  transition: color .3s;
}
.dark-theme .kpi-label { color: #94a3b8; }

.kpi-en {
  display: block;
  font-size: 10.5px; font-weight: 400;
  color: #94a3b8; margin-top: 1px;
}
.dark-theme .kpi-en { color: #64748b; }

.kpi-value {
  font-size: 20px; font-weight: 700;
  color: #0f172a; margin: 0;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  transition: color .3s;
}
.dark-theme .kpi-value { color: #f1f5f9; }

/* ── Dashboard Cards ── */
.db-card {
  background: #fff;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 1px 4px rgba(0,0,0,.07);
  display: flex; flex-direction: column;
  overflow: hidden;
  transition: all .3s;
}
.dark-theme .db-card {
  background: #1e293b;
  border-color: #334155;
  box-shadow: 0 1px 4px rgba(0,0,0,.3);
}

.db-card-head {
  padding: 18px 20px 14px;
  border-bottom: 1px solid #f1f5f9;
  display: flex; justify-content: space-between; align-items: flex-start;
  transition: border-color .3s;
}
.dark-theme .db-card-head { border-bottom-color: #334155; }

.db-card-title {
  font-size: 15px; font-weight: 700;
  color: #0f172a; margin: 0 0 2px;
  transition: color .3s;
}
.dark-theme .db-card-title { color: #f1f5f9; }

.db-card-sub {
  font-size: 11.5px; color: #94a3b8; margin: 0;
}

.db-card-body {
  padding: 16px 20px 20px;
  flex: 1;
}

/* Chart Legend */
.chart-legend { display: flex; gap: 14px; align-items: center; }
.leg-item {
  display: flex; align-items: center; gap: 6px;
  font-size: 12px; font-weight: 500;
  color: #64748b;
}
.dark-theme .leg-item { color: #94a3b8; }
.leg-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }

/* Ratio / App Legend */
.ratio-legend { display: flex; flex-direction: column; gap: 10px; width: 100%; }
.ratio-item {
  display: flex; align-items: center; gap: 8px;
  font-size: 12.5px;
}
.ratio-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.ratio-label { flex: 1; color: #64748b; }
.dark-theme .ratio-label { color: #94a3b8; }
.ratio-val { font-weight: 700; color: #0f172a; font-size: 13px; }
.dark-theme .ratio-val { color: #f1f5f9; }

/* Summary Table */
.table-responsive { overflow-x: auto; }
.summary-table { width: 100%; border-collapse: collapse; }

.summary-table thead {
  background: #f8fafc;
  transition: background .3s;
}
.dark-theme .summary-table thead { background: #334155; }

.summary-table th {
  padding: 14px 16px;
  font-size: 11.5px; font-weight: 700; text-transform: uppercase;
  letter-spacing: .5px; color: #64748b;
  border-bottom: 1px solid #e2e8f0;
  transition: all .3s;
}
.dark-theme .summary-table th { color: #94a3b8; border-bottom-color: #475569; }

.summary-table td {
  padding: 14px 16px;
  font-size: 13.5px; color: #334155;
  border-bottom: 1px solid #f1f5f9;
  transition: all .3s;
}
.dark-theme .summary-table td { color: #cbd5e1; border-bottom-color: #334155; }

.summary-table tbody tr:hover { background: #f8fafc; }
.dark-theme .summary-table tbody tr:hover { background: #273449; }

.tbl-info {
  display: flex; align-items: center; gap: 10px;
  font-weight: 500;
}
.tbl-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

.tbl-amount { font-weight: 700; font-size: 14px; }
.tbl-amount.income { color: #059669; }
.tbl-amount.expense { color: #dc2626; }
.tbl-amount.due { color: #d97706; }
.dark-theme .tbl-amount.income  { color: #34d399; }
.dark-theme .tbl-amount.expense { color: #f87171; }
.dark-theme .tbl-amount.due     { color: #fbbf24; }

.badge-status {
  display: inline-block;
  padding: 3px 10px; border-radius: 20px;
  font-size: 11.5px; font-weight: 600;
}
.status-good   { background: #d1fae5; color: #065f46; }
.status-warn   { background: #fef3c7; color: #92400e; }
.status-danger { background: #fee2e2; color: #991b1b; }
.dark-theme .status-good   { background: rgba(16,185,129,.15); color: #6ee7b7; }
.dark-theme .status-warn   { background: rgba(245,158,11,.15);  color: #fcd34d; }
.dark-theme .status-danger { background: rgba(239,68,68,.15);   color: #fca5a5; }

.chng {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 12px; font-weight: 600;
}
.chng.positive { color: #10b981; }
.chng.negative { color: #ef4444; }
.chng.neutral  { color: #94a3b8; }

/* Responsive */
@media (max-width: 576px) {
  .kpi-value { font-size: 17px; }
  .kpi-card  { padding: 14px 12px 12px; }
  .kpi-icon  { width: 38px; height: 38px; font-size: 15px; }
}
</style>
