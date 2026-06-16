<template>
  <aside class="tb-sidebar">

    <!-- Section heading -->
    <div class="tb-sidebar__head">
      <span class="tb-section-lbl">Milestones</span>
      <span class="tb-count-badge">{{ milestones.length }}</span>
    </div>

    <!-- Milestone list -->
    <nav class="tb-ms-list">
      <button
        v-for="m in milestones"
        :key="m.id"
        class="tb-ms-item"
        :class="{ active: m.id === selectedMilestoneId }"
        @click="$emit('select', m.id)"
      >
        <div class="tb-ms-item__top">
          <span class="tb-ms-item__num">{{ m.sort_order || '#' }}</span>
          <span class="tb-ms-item__name">{{ m.title }}</span>
          <span class="st-badge" :class="'st-badge--' + (m.current_status || 'upcoming')">
            {{ m.current_status || 'upcoming' }}
          </span>
        </div>

        <div class="tb-ms-item__meta">
          <span v-if="m.phase" class="tb-ms-item__phase">
            <i class="fas fa-tag"></i> {{ m.phase }}
          </span>
          <span v-if="m.target_date" class="tb-ms-item__date">
            <i class="fas fa-calendar-alt"></i> {{ formatDate(m.target_date) }}
          </span>
        </div>
        <div class="tb-ms-item__bottom">
          <span v-if="m.cost" class="tb-ms-cost">
            <i class="fas fa-coins"></i> ৳{{ formatCost(m.cost) }}
          </span>
          <span class="tb-ms-item__pct">{{ progresses[m.id] ?? 0 }}%</span>
        </div>

        <div class="tb-ms-bar">
          <div
            class="tb-ms-bar__fill"
            :style="{ width: (progresses[m.id] ?? 0) + '%' }"
          ></div>
        </div>
      </button>
    </nav>

    <!-- Footer stats -->
    <div class="tb-sidebar__footer">
      <div class="tb-footer-row">
        <div class="tb-f-stat">
          <span class="tb-f-stat__val" style="color:#6ee7b7">{{ overallStats.completed }}</span>
          <span class="tb-f-stat__lbl">Done</span>
        </div>
        <div class="tb-f-stat">
          <span class="tb-f-stat__val" style="color:#a5b4fc">{{ overallStats.inProgress }}</span>
          <span class="tb-f-stat__lbl">Active</span>
        </div>
        <div class="tb-f-stat">
          <span class="tb-f-stat__val" style="color:#fbbf24">{{ overallStats.pending }}</span>
          <span class="tb-f-stat__lbl">Pending</span>
        </div>
        <div class="tb-f-stat">
          <span class="tb-f-stat__val" style="color:#94a3b8">{{ overallStats.skipped }}</span>
          <span class="tb-f-stat__lbl">Skip</span>
        </div>
      </div>

      <div class="tb-overall-bar">
        <div class="tb-overall-bar__fill" :style="{ width: overallPct + '%' }"></div>
      </div>
      <p class="tb-overall-lbl">{{ overallPct }}% overall complete</p>
    </div>

  </aside>
</template>

<script>
export default {
  name: 'Sidebar',
  props: {
    milestones:          { type: Array,  default: () => [] },
    selectedMilestoneId: { type: Number, default: null },
    progresses:          { type: Object, default: () => ({}) },
    overallStats: {
      type: Object,
      default: () => ({ total: 0, completed: 0, inProgress: 0, pending: 0, skipped: 0 }),
    },
  },
  emits: ['select'],
  computed: {
    overallPct() {
      const { total, completed } = this.overallStats;
      return total ? Math.round((completed / total) * 100) : 0;
    },
  },
  methods: {
    formatDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }); }
      catch { return d; }
    },
    formatCost(n) {
      return Number(n).toLocaleString('en-US');
    },
  },
};
</script>

<style scoped>
.tb-sidebar {
  width: 288px; min-width: 288px;
  background: #050512;
  border-right: 1px solid rgba(255,255,255,.06);
  display: flex; flex-direction: column;
  overflow: hidden;
  flex-shrink: 0;
}

/* Head */
.tb-sidebar__head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.1rem 1.25rem .7rem;
  border-bottom: 1px solid rgba(255,255,255,.05);
  flex-shrink: 0;
}
.tb-section-lbl {
  font-size: .65rem; font-weight: 800; letter-spacing: 2.5px;
  text-transform: uppercase; color: #374151;
}
.tb-count-badge {
  background: rgba(99,102,241,.15); color: #818cf8;
  font-size: .7rem; font-weight: 800;
  padding: .15rem .55rem; border-radius: 50px;
}

/* Milestone list */
.tb-ms-list {
  flex: 1; overflow-y: auto; padding: .5rem .65rem;
  display: flex; flex-direction: column; gap: .3rem;
}

.tb-ms-item {
  width: 100%; text-align: left;
  background: none; border: 1px solid transparent;
  padding: .85rem .9rem; border-radius: 12px;
  cursor: pointer;
  transition: background .2s, border-color .2s;
}
.tb-ms-item:hover {
  background: rgba(255,255,255,.04);
  border-color: rgba(255,255,255,.07);
}
.tb-ms-item.active {
  background: rgba(99,102,241,.1);
  border-color: rgba(99,102,241,.3);
}

.tb-ms-item__top {
  display: flex; align-items: flex-start; gap: .5rem; margin-bottom: .4rem;
}
.tb-ms-item__num {
  width: 20px; height: 20px; border-radius: 6px; flex-shrink: 0;
  background: rgba(255,255,255,.06);
  display: inline-flex; align-items: center; justify-content: center;
  font-size: .6rem; font-weight: 900; color: #475569;
  margin-top: .05rem;
}
.tb-ms-item.active .tb-ms-item__num {
  background: rgba(99,102,241,.2); color: #818cf8;
}
.tb-ms-item__name {
  flex: 1; font-size: .8rem; font-weight: 700; color: #64748b; line-height: 1.35;
}
.tb-ms-item.active .tb-ms-item__name { color: #c4b5fd; }

.tb-ms-item__meta {
  display: flex; align-items: center; gap: .6rem; flex-wrap: wrap;
  margin-bottom: .5rem;
}
.tb-ms-item__phase {
  font-size: .63rem; color: #374151;
  display: flex; align-items: center; gap: .25rem;
}
.tb-ms-item__date {
  font-size: .63rem; color: #374151;
  display: flex; align-items: center; gap: .25rem;
}
.tb-ms-item__bottom {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: .5rem;
}
.tb-ms-cost {
  font-size: .65rem; font-weight: 700; color: #fbbf24;
  display: flex; align-items: center; gap: .3rem;
}
.tb-ms-item__pct {
  font-size: .7rem; font-weight: 900; color: #6366f1;
}

.tb-ms-bar {
  height: 3px; background: rgba(255,255,255,.05); border-radius: 50px; overflow: hidden;
}
.tb-ms-bar__fill {
  height: 100%;
  background: linear-gradient(90deg, #6366f1, #8b5cf6);
  border-radius: 50px;
  transition: width .5s ease;
}

/* Footer */
.tb-sidebar__footer {
  flex-shrink: 0;
  padding: .85rem 1.25rem;
  border-top: 1px solid rgba(255,255,255,.05);
}
.tb-footer-row {
  display: flex; gap: .35rem; margin-bottom: .75rem;
}
.tb-f-stat {
  flex: 1; text-align: center;
  background: rgba(255,255,255,.03);
  border: 1px solid rgba(255,255,255,.05);
  border-radius: 8px; padding: .45rem .25rem;
}
.tb-f-stat__val { display: block; font-size: 1rem; font-weight: 900; line-height: 1; }
.tb-f-stat__lbl { display: block; font-size: .55rem; color: #374151; text-transform: uppercase; letter-spacing: .5px; margin-top: .2rem; }

.tb-overall-bar {
  height: 5px; background: rgba(255,255,255,.07); border-radius: 50px; overflow: hidden;
}
.tb-overall-bar__fill {
  height: 100%; background: linear-gradient(90deg, #6366f1, #8b5cf6);
  border-radius: 50px; transition: width .6s ease;
}
.tb-overall-lbl { font-size: .65rem; color: #374151; margin: .4rem 0 0; text-align: right; }
</style>
