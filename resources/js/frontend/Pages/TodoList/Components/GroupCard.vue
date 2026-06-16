<template>
  <div class="tb-group" :class="{ 'tb-group--open': !collapsed }">

    <!-- ── Header ───────────────────────────────────────────── -->
    <div class="tb-group__header" @click="collapsed = !collapsed">

      <div class="tb-group__header-left">
        <div class="tb-group__icon" :style="{ background: accentColor }">
          <i :class="phaseIcon"></i>
        </div>
        <div class="tb-group__info">
          <h3 class="tb-group__name">{{ group.name }}</h3>
          <div class="tb-group__meta">
            <span v-if="group.phase" class="tb-group__phase">
              <i class="fas fa-layer-group"></i> {{ group.phase }}
            </span>
            <span class="st-badge" :class="'st-badge--' + (group.current_status || 'pending')">
              {{ statusLabel(group.current_status) }}
            </span>
          </div>
        </div>
      </div>

      <div class="tb-group__header-right">
        <div class="tb-group__counters">
          <span class="tb-group__counter tb-group__counter--done">
            <i class="fas fa-check"></i> {{ doneTasks }}
          </span>
          <span class="tb-group__counter-sep">/</span>
          <span class="tb-group__counter">{{ tasks.length }}</span>
          <span class="tb-group__counter-lbl">tasks</span>
        </div>

        <div v-if="group.cost" class="tb-group__cost">
          <i class="fas fa-coins"></i>
          <span>৳{{ formatCost(group.cost) }}</span>
        </div>

        <div class="tb-group__prog-wrap">
          <div class="tb-group__prog-bar">
            <div class="tb-group__prog-fill" :style="{ width: progress + '%', background: progressColor }"></div>
          </div>
          <span class="tb-group__pct" :style="{ color: progressColor }">{{ progress }}%</span>
        </div>

        <button class="tb-group__chevron" :class="{ open: !collapsed }">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>

    </div>

    <!-- ── Status strip ──────────────────────────────────────── -->
    <div class="tb-group__strip">
      <div class="strip--pending"     :style="{ flex: Math.max(statusCounts.pending, 0) }"></div>
      <div class="strip--in_progress" :style="{ flex: Math.max(statusCounts.in_progress, 0) }"></div>
      <div class="strip--completed"   :style="{ flex: Math.max(statusCounts.completed, 0) }"></div>
      <div class="strip--skipped"     :style="{ flex: Math.max(statusCounts.skipped, 0) }"></div>
    </div>

    <!-- ── Task list ─────────────────────────────────────────── -->
    <transition name="tb-slide">
      <div v-if="!collapsed" class="tb-group__body">

        <!-- Summary chips -->
        <div class="tb-group__summary">
          <span class="tb-sum-chip tb-sum-chip--pending">
            <i class="fas fa-circle"></i> {{ statusCounts.pending }} Pending
          </span>
          <span class="tb-sum-chip tb-sum-chip--active">
            <i class="fas fa-circle"></i> {{ statusCounts.in_progress }} Active
          </span>
          <span class="tb-sum-chip tb-sum-chip--done">
            <i class="fas fa-circle"></i> {{ statusCounts.completed }} Done
          </span>
          <span v-if="statusCounts.skipped" class="tb-sum-chip tb-sum-chip--skip">
            <i class="fas fa-circle"></i> {{ statusCounts.skipped }} Skipped
          </span>
        </div>

        <!-- Tasks -->
        <div v-if="filteredTasks.length" class="tb-group__tasks">
          <task-item
            v-for="task in filteredTasks"
            :key="task.id"
            :task="task"
          />
        </div>
        <div v-else class="tb-group__empty">
          <i class="fas fa-inbox"></i>
          <span>No matching tasks</span>
        </div>

      </div>
    </transition>

  </div>
</template>

<script>
import TaskItem from './TaskItem.vue';

const GROUP_COLORS = [
  '#6366f1','#8b5cf6','#06b6d4','#10b981',
  '#f59e0b','#f43f5e','#3b82f6','#ec4899',
  '#14b8a6','#a855f7',
];

const PHASE_ICONS = {
  Research:     'fas fa-search',
  Planning:     'fas fa-drafting-compass',
  Branding:     'fas fa-palette',
  Marketing:    'fas fa-bullhorn',
  SEO:          'fas fa-chart-line',
  Content:      'fas fa-file-alt',
  'Sales Setup':'fas fa-handshake',
  Acquisition:  'fas fa-user-plus',
  'Paid Ads':   'fas fa-ad',
  Partnerships: 'fas fa-people-arrows',
  Growth:       'fas fa-rocket',
};

const STATUS_LABELS = {
  pending:     'Pending',
  in_progress: 'In Progress',
  completed:   'Done',
  skipped:     'Skipped',
};

export default {
  name: 'GroupCard',
  components: { TaskItem },
  props: {
    group:  { type: Object, required: true },
    tasks:  { type: Array,  default: () => [] },
    search: { type: String, default: '' },
    index:  { type: Number, default: 0 },
  },
  data() {
    return { collapsed: false };
  },
  computed: {
    accentColor() {
      return GROUP_COLORS[this.index % GROUP_COLORS.length];
    },
    phaseIcon() {
      return PHASE_ICONS[this.group.phase] ?? 'fas fa-folder';
    },
    filteredTasks() {
      const q = this.search.trim().toLowerCase();
      if (!q) return this.tasks;
      return this.tasks.filter(t => (t.title || '').toLowerCase().includes(q));
    },
    doneTasks() {
      return this.tasks.filter(t => t.current_status === 'completed').length;
    },
    progress() {
      if (!this.tasks.length) return 0;
      return Math.round((this.doneTasks / this.tasks.length) * 100);
    },
    progressColor() {
      if (this.progress >= 80) return '#10b981';
      if (this.progress >= 40) return '#6366f1';
      return '#f59e0b';
    },
    statusCounts() {
      const c = { pending: 0, in_progress: 0, completed: 0, skipped: 0 };
      this.tasks.forEach(t => {
        const s = t.current_status || 'pending';
        if (c[s] !== undefined) c[s]++;
      });
      return c;
    },
  },
  methods: {
    statusLabel(s) { return STATUS_LABELS[s] ?? (s || 'Pending'); },
    formatCost(n) { return Number(n).toLocaleString('en-US'); },
  },
};
</script>

<style scoped>
/* ── Card shell ─────────────────────────────────────────────── */
.tb-group {
  background: rgba(255,255,255,.025);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 16px;
  overflow: hidden;
  transition: border-color .2s, box-shadow .2s;
}
.tb-group:hover {
  border-color: rgba(255,255,255,.13);
  box-shadow: 0 4px 24px rgba(0,0,0,.25);
}

/* ── Header ─────────────────────────────────────────────────── */
.tb-group__header {
  display: flex; align-items: center; justify-content: space-between; gap: 1rem;
  padding: 1.1rem 1.25rem;
  cursor: pointer; user-select: none;
  transition: background .2s;
}
.tb-group__header:hover { background: rgba(255,255,255,.03); }

.tb-group__header-left {
  display: flex; align-items: center; gap: .9rem; flex: 1; min-width: 0;
}

.tb-group__icon {
  width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; color: #fff; opacity: .9;
}

.tb-group__info { min-width: 0; flex: 1; }
.tb-group__name {
  font-size: .95rem; font-weight: 800; color: #e2e8f0;
  margin: 0 0 .3rem; line-height: 1.3;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.tb-group__meta { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
.tb-group__phase {
  font-size: .65rem; color: #64748b;
  display: flex; align-items: center; gap: .3rem;
}

/* Header right */
.tb-group__header-right {
  display: flex; align-items: center; gap: 1.1rem; flex-shrink: 0;
}

.tb-group__counters {
  display: flex; align-items: center; gap: .25rem;
  font-size: .78rem; font-weight: 700; color: #64748b;
}
.tb-group__counter--done { color: #6ee7b7; display: flex; align-items: center; gap: .25rem; }
.tb-group__counter-sep   { color: #374151; }
.tb-group__counter-lbl   { font-size: .65rem; color: #374151; margin-left: .1rem; }

.tb-group__cost {
  display: flex; align-items: center; gap: .35rem;
  font-size: .72rem; font-weight: 800; color: #fbbf24;
  background: rgba(245,158,11,.08);
  border: 1px solid rgba(245,158,11,.2);
  border-radius: 8px; padding: .25rem .7rem;
  flex-shrink: 0;
}
.tb-group__cost i { font-size: .65rem; }

.tb-group__prog-wrap {
  display: flex; align-items: center; gap: .65rem;
}
.tb-group__prog-bar {
  width: 90px; height: 5px;
  background: rgba(255,255,255,.07); border-radius: 50px; overflow: hidden;
}
.tb-group__prog-fill {
  height: 100%; border-radius: 50px; transition: width .5s ease, background .5s;
}
.tb-group__pct { font-size: .72rem; font-weight: 900; min-width: 34px; text-align: right; }

.tb-group__chevron {
  background: none; border: none; color: #374151; cursor: pointer;
  width: 28px; height: 28px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  transition: transform .3s, color .2s, background .2s;
}
.tb-group__chevron.open { transform: rotate(90deg); }
.tb-group__chevron:hover { color: #94a3b8; background: rgba(255,255,255,.06); }

/* ── Status colour strip ─────────────────────────────────────── */
.tb-group__strip {
  display: flex; height: 3px;
}
.tb-group__strip > div { transition: flex .4s ease; min-width: 0; }
.strip--pending     { background: #f59e0b; }
.strip--in_progress { background: #6366f1; }
.strip--completed   { background: #10b981; }
.strip--skipped     { background: #475569; }

/* ── Body ───────────────────────────────────────────────────── */
.tb-group__body {
  padding: .75rem 1.1rem 1.1rem;
}

/* Summary chips */
.tb-group__summary {
  display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: .85rem;
}
.tb-sum-chip {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .62rem; font-weight: 800; letter-spacing: .3px;
  padding: .2rem .65rem; border-radius: 50px;
}
.tb-sum-chip i { font-size: .42rem; }
.tb-sum-chip--pending { background: rgba(245,158,11,.1); color: #fbbf24; }
.tb-sum-chip--active  { background: rgba(99,102,241,.1); color: #a5b4fc; }
.tb-sum-chip--done    { background: rgba(16,185,129,.1); color: #6ee7b7; }
.tb-sum-chip--skip    { background: rgba(100,116,139,.1); color: #94a3b8; }

/* Tasks */
.tb-group__tasks {
  display: flex; flex-direction: column; gap: .5rem;
}
.tb-group__empty {
  display: flex; align-items: center; justify-content: center; gap: .6rem;
  padding: 1.75rem; color: #374151; font-size: .82rem;
}

/* ── Slide transition ───────────────────────────────────────── */
.tb-slide-enter-active, .tb-slide-leave-active {
  transition: opacity .25s ease, max-height .35s ease;
  max-height: 2000px; overflow: hidden;
}
.tb-slide-enter-from, .tb-slide-leave-to {
  opacity: 0; max-height: 0;
}
</style>
