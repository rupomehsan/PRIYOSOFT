<template>
  <div class="tb-app">

    <top-bar
      :stats="overallStats"
      :total-cost="totalCostSummary"
      :search="search"
      @update:search="search = $event"
    />

    <div class="tb-body">

      <sidebar
        :milestones="milestones"
        :selected-milestone-id="selectedMilestoneId"
        :progresses="milestoneProgresses"
        :overall-stats="overallStats"
        @select="onSelectMilestone"
      />

      <main class="tb-content">

        <!-- Loading -->
        <div v-if="loading" class="tb-state">
          <div class="tb-skeleton-grid">
            <div class="tb-skeleton" v-for="n in 3" :key="n"></div>
          </div>
        </div>

        <!-- Error -->
        <div v-else-if="error" class="tb-state tb-state--center">
          <div class="tb-state-icon tb-state-icon--warn">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <h3>Failed to load data</h3>
          <p>{{ error }}</p>
          <button class="tb-retry" @click="fetchAllData">
            <i class="fas fa-redo"></i> Retry
          </button>
        </div>

        <!-- No milestones -->
        <div v-else-if="!milestones.length" class="tb-state tb-state--center">
          <div class="tb-state-icon"><i class="fas fa-flag"></i></div>
          <h3>No milestones yet</h3>
          <p>Add milestones from the admin panel to get started.</p>
        </div>

        <!-- Main milestone view -->
        <div v-else class="tb-milestone-view">

          <!-- Milestone header card -->
          <div class="tb-mh" v-if="selectedMilestone">
            <div class="tb-mh__left">
              <span class="tb-mh__tag"><i class="fas fa-flag-checkered"></i> Milestone</span>
              <h2 class="tb-mh__title">{{ selectedMilestone.title }}</h2>
              <div class="tb-mh__badges">
                <span v-if="selectedMilestone.phase" class="tb-mh__phase">
                  <i class="fas fa-layer-group"></i> {{ selectedMilestone.phase }}
                </span>
                <span class="st-badge" :class="'st-badge--' + (selectedMilestone.current_status || 'upcoming')">
                  {{ selectedMilestone.current_status || 'upcoming' }}
                </span>
                <span v-if="selectedMilestone.target_date" class="tb-mh__date">
                  <i class="fas fa-calendar-alt"></i> Target: {{ formatDate(selectedMilestone.target_date) }}
                </span>
              </div>
              <p v-if="selectedMilestone.note" class="tb-mh__note">{{ selectedMilestone.note }}</p>
            </div>

            <div class="tb-mh__right">
              <div class="tb-mh__stats">
                <div class="tb-mh-stat">
                  <span>{{ groupsForSelected.length }}</span>
                  <label>Groups</label>
                </div>
                <div class="tb-mh-stat">
                  <span>{{ milestoneTaskCount }}</span>
                  <label>Tasks</label>
                </div>
                <div class="tb-mh-stat" style="color:#6ee7b7">
                  <span>{{ milestoneDoneCount }}</span>
                  <label>Done</label>
                </div>
                <div class="tb-mh-stat" style="color:#fbbf24">
                  <span>{{ milestonePendingCount }}</span>
                  <label>Pending</label>
                </div>
              </div>

              <!-- Cost breakdown row -->
              <div class="tb-mh__costs" v-if="milestoneBudget || milestoneGroupCost">
                <div class="tb-mh-cost tb-mh-cost--budget" v-if="milestoneBudget">
                  <i class="fas fa-bullseye"></i>
                  <div>
                    <span class="tb-mh-cost__val">{{ formatCost(milestoneBudget) }}</span>
                    <span class="tb-mh-cost__lbl">Milestone Budget</span>
                  </div>
                </div>
                <div class="tb-mh-cost__divider" v-if="milestoneBudget && milestoneGroupCost"></div>
                <div class="tb-mh-cost tb-mh-cost--allocated" v-if="milestoneGroupCost">
                  <i class="fas fa-layer-group"></i>
                  <div>
                    <span class="tb-mh-cost__val">{{ formatCost(milestoneGroupCost) }}</span>
                    <span class="tb-mh-cost__lbl">Total Group Cost</span>
                  </div>
                </div>
              </div>

              <div class="tb-mh__prog">
                <div class="tb-mh__prog-track">
                  <div class="tb-mh__prog-fill" :style="{ width: milestoneProgressPct + '%' }"></div>
                </div>
                <span class="tb-mh__pct">{{ milestoneProgressPct }}%</span>
              </div>
            </div>
          </div>

          <!-- Groups label row -->
          <div class="tb-groups-head">
            <span class="tb-groups-head__label">
              <i class="fas fa-layer-group"></i>
              Groups ({{ visibleGroups.length }})
            </span>
            <button class="tb-toggle-all" @click="toggleAllGroups">
              {{ allOpen ? 'Collapse All' : 'Expand All' }}
            </button>
          </div>

          <!-- No groups -->
          <div v-if="!groupsForSelected.length" class="tb-state tb-state--center" style="min-height:200px">
            <div class="tb-state-icon"><i class="fas fa-folder-open"></i></div>
            <h3>No groups in this milestone</h3>
          </div>

          <!-- No match after search -->
          <div v-else-if="!visibleGroups.length" class="tb-state tb-state--center" style="min-height:200px">
            <div class="tb-state-icon"><i class="fas fa-search"></i></div>
            <h3>No tasks match "{{ search }}"</h3>
            <button class="tb-retry" @click="search = ''">
              <i class="fas fa-times"></i> Clear search
            </button>
          </div>

          <!-- Group cards -->
          <div v-else class="tb-groups-list">
            <group-card
              v-for="(group, idx) in visibleGroups"
              :key="group.id"
              :ref="'group-' + group.id"
              :group="group"
              :tasks="tasksForGroup(group.id)"
              :search="search"
              :index="idx"
            />
          </div>

        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { store as useTodoStore } from './Store';
import { mapState, mapActions } from 'pinia';

import TopBar    from './Components/TopBar.vue';
import Sidebar   from './Components/Sidebar.vue';
import GroupCard from './Components/GroupCard.vue';

import './Css/Style.css';

export default {
  name: 'TodoBoardPage',
  layout: false,

  components: { TopBar, Sidebar, GroupCard },

  data() {
    return {
      search:  '',
      allOpen: true,
    };
  },

  computed: {
    ...mapState(useTodoStore, [
      'loading', 'error',
      'milestones', 'groups', 'tasks',
      'selectedMilestoneId',
      'selectedMilestone', 'groupsForSelected', 'tasksForGroup',
      'milestoneProgress', 'milestoneTotalCost', 'overallStats', 'totalCostSummary',
    ]),

    milestoneProgresses() {
      const map = {};
      this.milestones.forEach(m => {
        map[m.id] = this.milestoneProgress(m.id);
      });
      return map;
    },

    visibleGroups() {
      if (!this.search.trim()) return this.groupsForSelected;
      const q = this.search.toLowerCase();
      return this.groupsForSelected.filter(g =>
        this.tasksForGroup(g.id).some(t => (t.title || '').toLowerCase().includes(q))
      );
    },

    milestoneTaskCount() {
      return this.groupsForSelected.reduce((s, g) => s + this.tasksForGroup(g.id).length, 0);
    },
    milestoneDoneCount() {
      return this.groupsForSelected.reduce(
        (s, g) => s + this.tasksForGroup(g.id).filter(t => t.current_status === 'completed').length, 0
      );
    },
    milestonePendingCount() {
      return this.groupsForSelected.reduce(
        (s, g) => s + this.tasksForGroup(g.id).filter(t => t.current_status === 'pending').length, 0
      );
    },
    milestoneProgressPct() {
      if (!this.milestoneTaskCount) return 0;
      return Math.round((this.milestoneDoneCount / this.milestoneTaskCount) * 100);
    },
    milestoneBudget() {
      return this.selectedMilestone?.cost ? Number(this.selectedMilestone.cost) : 0;
    },
    milestoneGroupCost() {
      return this.selectedMilestoneId ? this.milestoneTotalCost(this.selectedMilestoneId) : 0;
    },
  },

  methods: {
    ...mapActions(useTodoStore, ['fetchAllData', 'selectMilestone']),

    onSelectMilestone(id) {
      this.selectMilestone(id);
      this.search = '';
    },

    toggleAllGroups() {
      this.allOpen = !this.allOpen;
      this.visibleGroups.forEach(g => {
        const ref = this.$refs['group-' + g.id];
        const comp = Array.isArray(ref) ? ref[0] : ref;
        if (comp && comp.$data) comp.$data.collapsed = !this.allOpen;
      });
    },

    formatDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }); }
      catch { return d; }
    },
    formatCost(n) {
      return '৳' + Number(n).toLocaleString('en-US');
    },
  },

  mounted() {
    this.fetchAllData();
  },
};
</script>

<style scoped>
/* ── Content area ───────────────────────────────────────────── */
.tb-content {
  flex: 1; overflow-y: auto; display: flex; flex-direction: column;
}

/* ── Milestone view ─────────────────────────────────────────── */
.tb-milestone-view {
  flex: 1; padding: 1.5rem 1.75rem;
  display: flex; flex-direction: column; gap: 1.25rem;
}

/* ── Milestone header card ──────────────────────────────────── */
.tb-mh {
  background: linear-gradient(135deg, rgba(99,102,241,.08) 0%, rgba(139,92,246,.06) 50%, rgba(6,182,212,.04) 100%);
  border: 1px solid rgba(99,102,241,.2);
  border-radius: 18px;
  padding: 1.5rem 1.75rem;
  display: flex; align-items: flex-start; justify-content: space-between; gap: 2rem;
  flex-wrap: wrap;
}

.tb-mh__left { flex: 1; min-width: 220px; }

.tb-mh__tag {
  display: inline-flex; align-items: center; gap: .4rem;
  font-size: .65rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase;
  color: #818cf8; margin-bottom: .65rem;
}

.tb-mh__title {
  font-size: 1.4rem; font-weight: 900;
  background: linear-gradient(135deg, #c4b5fd 0%, #a5b4fc 50%, #67e8f9 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
  margin: 0 0 .65rem; line-height: 1.25;
}

.tb-mh__badges { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; margin-bottom: .6rem; }
.tb-mh__phase {
  font-size: .72rem; color: #64748b; display: flex; align-items: center; gap: .3rem;
}
.tb-mh__date {
  font-size: .72rem; color: #475569; display: flex; align-items: center; gap: .3rem;
}
.tb-mh__note { font-size: .82rem; color: #64748b; line-height: 1.6; margin: 0; }

.tb-mh__right { flex-shrink: 0; display: flex; flex-direction: column; gap: 1rem; align-items: flex-end; }

.tb-mh__stats { display: flex; gap: .85rem; }
.tb-mh-stat {
  text-align: center;
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 12px; padding: .75rem 1rem;
  min-width: 65px;
}
.tb-mh-stat span  { display: block; font-size: 1.5rem; font-weight: 900; color: #e2e8f0; line-height: 1; }
.tb-mh-stat label { display: block; font-size: .6rem; color: #475569; text-transform: uppercase; letter-spacing: .5px; margin-top: .25rem; }

/* Cost breakdown */
.tb-mh__costs {
  display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
  padding: .75rem 1rem;
  background: rgba(255,255,255,.03);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 12px;
  width: 100%;
}
.tb-mh-cost {
  display: flex; align-items: center; gap: .65rem;
}
.tb-mh-cost i { font-size: .9rem; opacity: .7; }
.tb-mh-cost--budget i  { color: #6366f1; }
.tb-mh-cost--allocated i { color: #f59e0b; }
.tb-mh-cost__val {
  display: block; font-size: 1rem; font-weight: 900; line-height: 1;
}
.tb-mh-cost--budget  .tb-mh-cost__val { color: #a5b4fc; }
.tb-mh-cost--allocated .tb-mh-cost__val { color: #fbbf24; }
.tb-mh-cost__lbl {
  display: block; font-size: .6rem; color: #475569; text-transform: uppercase;
  letter-spacing: .5px; margin-top: .2rem;
}
.tb-mh-cost__divider {
  width: 1px; height: 32px; background: rgba(255,255,255,.08); flex-shrink: 0;
}

.tb-mh__prog { display: flex; align-items: center; gap: .75rem; width: 100%; }
.tb-mh__prog-track {
  flex: 1; height: 8px; background: rgba(255,255,255,.07); border-radius: 50px; overflow: hidden;
}
.tb-mh__prog-fill {
  height: 100%;
  background: linear-gradient(90deg, #6366f1, #8b5cf6, #06b6d4);
  border-radius: 50px; transition: width .6s ease;
}
.tb-mh__pct { font-size: .85rem; font-weight: 900; color: #a5b4fc; min-width: 38px; text-align: right; }

/* ── Groups heading row ─────────────────────────────────────── */
.tb-groups-head {
  display: flex; align-items: center; justify-content: space-between;
}
.tb-groups-head__label {
  font-size: .72rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;
  color: #475569; display: flex; align-items: center; gap: .45rem;
}
.tb-toggle-all {
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.08);
  color: #64748b; font-size: .72rem; font-weight: 700;
  padding: .3rem .85rem; border-radius: 8px; cursor: pointer;
  transition: all .2s;
}
.tb-toggle-all:hover {
  background: rgba(255,255,255,.08); color: #94a3b8;
  border-color: rgba(255,255,255,.15);
}

/* ── Groups list ────────────────────────────────────────────── */
.tb-groups-list {
  display: flex; flex-direction: column; gap: .85rem;
  padding-bottom: 2rem;
}

/* ── Responsive ─────────────────────────────────────────────── */
@media (max-width: 900px) {
  .tb-milestone-view { padding: 1rem; }
  .tb-mh { flex-direction: column; gap: 1rem; }
  .tb-mh__right { align-items: flex-start; width: 100%; }
  .tb-mh__prog  { width: 100%; }
}
@media (max-width: 600px) {
  .tb-mh__stats { gap: .5rem; flex-wrap: wrap; }
  .tb-mh-stat   { min-width: 50px; padding: .5rem .65rem; }
}
</style>
