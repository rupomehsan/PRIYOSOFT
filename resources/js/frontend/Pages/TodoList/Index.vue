<template>
  <div class="todo-app">
    <!-- Sidebar -->
    <aside class="todo-sidebar">
      <div class="todo-brand">
        <div class="brand-icon">P</div>
        <span class="brand-name">Todo<em>Board</em></span>
      </div>

      <nav class="todo-nav">
        <button
          class="todo-nav__item"
          :class="{ active: activeGroup === null }"
          @click="activeGroup = null"
        >
          <span class="todo-nav__icon"><i class="fas fa-layer-group"></i></span>
          <span>All Tasks</span>
          <span class="todo-nav__count">{{ allTodos.length }}</span>
        </button>

        <div class="todo-nav__section">Groups</div>

        <button
          v-for="g in groups"
          :key="g.id"
          class="todo-nav__item"
          :class="{ active: activeGroup === g.id }"
          @click="activeGroup = g.id"
        >
          <span class="todo-nav__dot" :style="{ background: groupColor(g.id) }"></span>
          <span>{{ g.name }}</span>
          <span class="todo-nav__count">{{ todosForGroup(g.id).length }}</span>
        </button>
      </nav>

      <div class="todo-sidebar__footer">
        <div class="todo-stats">
          <div class="todo-stat">
            <span class="todo-stat__val">{{ completedCount }}</span>
            <span class="todo-stat__lbl">Done</span>
          </div>
          <div class="todo-stat">
            <span class="todo-stat__val">{{ pendingCount }}</span>
            <span class="todo-stat__lbl">Pending</span>
          </div>
          <div class="todo-stat">
            <span class="todo-stat__val">{{ inProgressCount }}</span>
            <span class="todo-stat__lbl">Active</span>
          </div>
        </div>
        <div class="todo-progress">
          <div class="todo-progress__bar" :style="{ width: progressPct + '%' }"></div>
        </div>
        <p class="todo-progress__label">{{ progressPct }}% complete</p>
      </div>
    </aside>

    <!-- Main content -->
    <main class="todo-main">
      <!-- Top bar -->
      <div class="todo-topbar">
        <div class="todo-topbar__left">
          <h1 class="todo-page-title">
            {{ activeGroupName }}
          </h1>
          <p class="todo-page-sub">{{ filteredTodos.length }} tasks total</p>
        </div>
        <div class="todo-topbar__right">
          <div class="todo-search">
            <i class="fas fa-search"></i>
            <input v-model="search" placeholder="Search tasks…" />
          </div>
          <div class="todo-filter-pills">
            <button
              v-for="s in STATUS_FILTERS"
              :key="s.value"
              class="filter-pill"
              :class="{ active: statusFilter === s.value }"
              @click="statusFilter = s.value"
            >{{ s.label }}</button>
          </div>
        </div>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="todo-loading">
        <div class="todo-skeleton" v-for="n in 6" :key="n"></div>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="todo-error">
        <div class="todo-error__icon"><i class="fas fa-exclamation-triangle"></i></div>
        <p>{{ error }}</p>
        <button class="btn-retry" @click="fetchData">Retry</button>
      </div>

      <!-- Empty -->
      <div v-else-if="displayTodos.length === 0" class="todo-empty">
        <div class="todo-empty__icon"><i class="fas fa-clipboard-list"></i></div>
        <h3>No tasks found</h3>
        <p>Try changing the filter or search query.</p>
      </div>

      <!-- Kanban columns -->
      <div v-else class="todo-kanban">
        <div
          v-for="col in kanbanCols"
          :key="col.status"
          class="kanban-col"
        >
          <div class="kanban-col__header">
            <span class="kanban-col__dot" :style="{ background: col.color }"></span>
            <span class="kanban-col__title">{{ col.label }}</span>
            <span class="kanban-col__badge">{{ col.items.length }}</span>
          </div>

          <div class="kanban-col__body">
            <div
              v-for="todo in col.items"
              :key="todo.id"
              class="todo-card"
              :class="'priority-' + todo.priority"
            >
              <div class="todo-card__top">
                <span class="priority-badge" :class="'priority-badge--' + todo.priority">
                  <i class="fas fa-circle me-1" style="font-size:.45rem;vertical-align:middle"></i>
                  {{ todo.priority }}
                </span>
                <span v-if="todo.todoGroupId" class="group-tag" :style="{ background: groupColorAlpha(todo.todo_group_id), color: groupColor(todo.todo_group_id) }">
                  {{ groupName(todo.todo_group_id) }}
                </span>
              </div>

              <h4 class="todo-card__title">{{ todo.title }}</h4>

              <p v-if="todo.note" class="todo-card__note">{{ truncate(todo.note, 90) }}</p>

              <div class="todo-card__meta">
                <span v-if="todo.assigned_to" class="todo-card__assignee">
                  <span class="assignee-avatar">{{ initial(todo.assigned_to) }}</span>
                  {{ todo.assigned_to }}
                </span>
                <span v-if="todo.estimated_days" class="todo-card__days">
                  <i class="fas fa-clock me-1"></i>{{ todo.estimated_days }}d
                </span>
                <span v-if="todo.is_recurring" class="todo-card__recurring">
                  <i class="fas fa-redo"></i>
                </span>
              </div>

              <div v-if="todo.completed_at" class="todo-card__completed">
                <i class="fas fa-check-circle me-1"></i>{{ formatDate(todo.completed_at) }}
              </div>
            </div>

            <div v-if="col.items.length === 0" class="kanban-col__empty">
              No tasks here
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>

const STATUS_FILTERS = [
  { value: 'all',         label: 'All'         },
  { value: 'pending',     label: 'Pending'     },
  { value: 'in_progress', label: 'In Progress' },
  { value: 'completed',   label: 'Completed'   },
  { value: 'skipped',     label: 'Skipped'     },
];

const GROUP_COLORS = [
  '#6366f1','#8b5cf6','#06b6d4','#10b981','#f59e0b','#f43f5e','#3b82f6','#ec4899',
];

const KANBAN_COLS = [
  { status: 'pending',     label: 'Pending',     color: '#f59e0b' },
  { status: 'in_progress', label: 'In Progress', color: '#6366f1' },
  { status: 'completed',   label: 'Completed',   color: '#10b981' },
  { status: 'skipped',     label: 'Skipped',     color: '#64748b' },
];

export default {
  name: 'TodoListPage',
  layout: false,

  data: () => ({
    todos:        [],
    groups:       [],
    loading:      true,
    error:        null,
    activeGroup:  null,
    statusFilter: 'all',
    search:       '',
    STATUS_FILTERS,
  }),

  computed: {
    allTodos() { return this.todos; },

    filteredTodos() {
      let list = this.activeGroup !== null
        ? this.todos.filter(t => t.todo_group_id === this.activeGroup)
        : this.todos;

      if (this.statusFilter !== 'all')
        list = list.filter(t => t.status === this.statusFilter);

      if (this.search.trim())
        list = list.filter(t => t.title.toLowerCase().includes(this.search.toLowerCase()));

      return list;
    },

    displayTodos() { return this.filteredTodos; },

    kanbanCols() {
      return KANBAN_COLS.map(col => ({
        ...col,
        items: this.filteredTodos.filter(t => t.status === col.status)
          .sort((a, b) => (a.sort_order || 0) - (b.sort_order || 0)),
      }));
    },

    activeGroupName() {
      if (this.activeGroup === null) return 'All Tasks';
      const g = this.groups.find(g => g.id === this.activeGroup);
      return g ? g.name : 'Tasks';
    },

    completedCount()  { return this.todos.filter(t => t.status === 'completed').length; },
    pendingCount()    { return this.todos.filter(t => t.status === 'pending').length; },
    inProgressCount() { return this.todos.filter(t => t.status === 'in_progress').length; },

    progressPct() {
      if (!this.todos.length) return 0;
      return Math.round((this.completedCount / this.todos.length) * 100);
    },
  },

  async mounted() {
    await this.fetchData();
  },

  methods: {
    async fetchData() {
      this.loading = true;
      this.error   = null;
      try {
        const [todosRes, groupsRes] = await Promise.all([
          window.privateAxios('todo-lists?get_all=1'),
          window.privateAxios('todo-groups?get_all=1'),
        ]);
        this.todos  = todosRes?.data?.data  ?? todosRes?.data  ?? [];
        this.groups = groupsRes?.data?.data ?? groupsRes?.data ?? [];
        if (!Array.isArray(this.todos))  this.todos  = [];
        if (!Array.isArray(this.groups)) this.groups = [];
      } catch (e) {
        this.error = 'Failed to load tasks. Make sure you are logged in.';
      } finally {
        this.loading = false;
      }
    },

    todosForGroup(gid) { return this.todos.filter(t => t.todo_group_id === gid); },

    groupColor(gid) {
      const idx = this.groups.findIndex(g => g.id === gid);
      return GROUP_COLORS[idx % GROUP_COLORS.length] ?? '#6366f1';
    },
    groupColorAlpha(gid) {
      const c = this.groupColor(gid);
      return c + '22';
    },
    groupName(gid) {
      const g = this.groups.find(g => g.id === gid);
      return g ? g.name : '';
    },

    initial(name) { return name ? name[0].toUpperCase() : '?'; },
    truncate(str, n) {
      if (!str) return '';
      return str.length > n ? str.slice(0, n) + '…' : str;
    },
    formatDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }); }
      catch { return d; }
    },
  },
};
</script>

<style>
*, *::before, *::after { box-sizing: border-box; }
html, body, #app { margin: 0; padding: 0; height: 100%; }
</style>

<style scoped>
/* ─── Layout ───────────────────────────────────────────── */
.todo-app {
  display: flex;
  height: 100vh;
  overflow: hidden;
  background: #07071a;
  font-family: 'Inter', 'Segoe UI', sans-serif;
  color: #e2e8f0;
}

/* ─── Sidebar ──────────────────────────────────────────── */
.todo-sidebar {
  width: 260px;
  flex-shrink: 0;
  background: #050512;
  border-right: 1px solid rgba(255,255,255,.06);
  display: flex;
  flex-direction: column;
  padding: 1.75rem 1.25rem;
  overflow-y: auto;
}

.todo-brand {
  display: flex;
  align-items: center;
  gap: .65rem;
  margin-bottom: 2.5rem;
}
.brand-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: flex; align-items: center; justify-content: center;
  font-weight: 900; font-size: 1.1rem; color: #fff;
}
.brand-name { font-size: 1.15rem; font-weight: 800; color: #fff; }
.brand-name em { font-style: normal; color: #a78bfa; }

/* Nav */
.todo-nav { flex: 1; display: flex; flex-direction: column; gap: .3rem; }

.todo-nav__section {
  font-size: .68rem; font-weight: 800; letter-spacing: 2px;
  text-transform: uppercase; color: #374151;
  padding: 1.25rem .5rem .5rem;
}

.todo-nav__item {
  display: flex; align-items: center; gap: .75rem;
  width: 100%; background: none; border: none;
  padding: .65rem .75rem; border-radius: 10px;
  color: #64748b; font-size: .875rem; font-weight: 600;
  cursor: pointer; text-align: left;
  transition: background .2s, color .2s;
}
.todo-nav__item:hover { background: rgba(255,255,255,.04); color: #94a3b8; }
.todo-nav__item.active {
  background: rgba(99,102,241,.15);
  color: #a5b4fc;
}

.todo-nav__icon { font-size: .85rem; width: 18px; text-align: center; }
.todo-nav__dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

.todo-nav__count {
  margin-left: auto;
  background: rgba(255,255,255,.07);
  color: #64748b; font-size: .7rem; font-weight: 700;
  padding: .15rem .5rem; border-radius: 50px;
}
.todo-nav__item.active .todo-nav__count {
  background: rgba(99,102,241,.2);
  color: #818cf8;
}

/* Sidebar footer */
.todo-sidebar__footer { margin-top: auto; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,.05); }

.todo-stats {
  display: flex; gap: .5rem; margin-bottom: 1rem;
}
.todo-stat {
  flex: 1; text-align: center;
  background: rgba(255,255,255,.03);
  border: 1px solid rgba(255,255,255,.06);
  border-radius: 10px; padding: .65rem .5rem;
}
.todo-stat__val { display: block; font-size: 1.25rem; font-weight: 800; color: #c4b5fd; }
.todo-stat__lbl { display: block; font-size: .65rem; color: #475569; text-transform: uppercase; letter-spacing: .5px; margin-top: .1rem; }

.todo-progress {
  height: 6px; background: rgba(255,255,255,.07); border-radius: 50px; overflow: hidden;
}
.todo-progress__bar {
  height: 100%;
  background: linear-gradient(90deg, #6366f1, #8b5cf6);
  border-radius: 50px;
  transition: width .5s ease;
}
.todo-progress__label { font-size: .72rem; color: #475569; margin: .5rem 0 0; text-align: right; }

/* ─── Main ─────────────────────────────────────────────── */
.todo-main {
  flex: 1; display: flex; flex-direction: column; overflow: hidden;
}

/* Topbar */
.todo-topbar {
  display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
  padding: 1.5rem 2rem;
  border-bottom: 1px solid rgba(255,255,255,.06);
  background: rgba(5,5,18,.7);
  backdrop-filter: blur(12px);
  flex-shrink: 0;
}
.todo-page-title { font-size: 1.35rem; font-weight: 900; color: #f1f5f9; margin: 0; }
.todo-page-sub   { font-size: .8rem; color: #475569; margin: .15rem 0 0; }

.todo-topbar__right { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }

.todo-search {
  display: flex; align-items: center; gap: .6rem;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.08);
  border-radius: 10px;
  padding: .5rem 1rem;
}
.todo-search i { color: #475569; font-size: .82rem; }
.todo-search input {
  background: none; border: none; outline: none;
  color: #e2e8f0; font-size: .875rem; width: 180px;
}
.todo-search input::placeholder { color: #374151; }

.todo-filter-pills { display: flex; gap: .4rem; }
.filter-pill {
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.07);
  color: #64748b; font-size: .75rem; font-weight: 700;
  padding: .35rem .9rem; border-radius: 50px;
  cursor: pointer; transition: all .2s;
}
.filter-pill:hover { color: #94a3b8; border-color: rgba(255,255,255,.15); }
.filter-pill.active {
  background: rgba(99,102,241,.2);
  border-color: rgba(99,102,241,.4);
  color: #a5b4fc;
}

/* ─── Kanban ───────────────────────────────────────────── */
.todo-kanban {
  flex: 1; display: flex; gap: 1.25rem;
  padding: 1.5rem 2rem; overflow-x: auto; overflow-y: hidden;
}

.kanban-col {
  width: 280px; min-width: 280px;
  display: flex; flex-direction: column;
  background: rgba(255,255,255,.02);
  border: 1px solid rgba(255,255,255,.05);
  border-radius: 16px; overflow: hidden;
}

.kanban-col__header {
  display: flex; align-items: center; gap: .65rem;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid rgba(255,255,255,.05);
  background: rgba(255,255,255,.02);
  flex-shrink: 0;
}
.kanban-col__dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.kanban-col__title { font-size: .8rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; flex: 1; }
.kanban-col__badge {
  background: rgba(255,255,255,.07);
  color: #475569; font-size: .7rem; font-weight: 800;
  padding: .1rem .5rem; border-radius: 50px;
}

.kanban-col__body { flex: 1; overflow-y: auto; padding: .875rem; display: flex; flex-direction: column; gap: .75rem; }
.kanban-col__empty { text-align: center; color: #374151; font-size: .8rem; padding: 1.5rem 0; }

/* ─── Todo Card ────────────────────────────────────────── */
.todo-card {
  background: rgba(255,255,255,.035);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 12px; padding: 1rem 1.1rem;
  cursor: default;
  transition: transform .2s, box-shadow .2s, border-color .2s;
  position: relative;
}
.todo-card::before {
  content: '';
  position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
  border-radius: 3px 0 0 3px;
  background: rgba(99,102,241,.4);
}
.todo-card.priority-critical::before { background: #f43f5e; }
.todo-card.priority-high::before     { background: #f97316; }
.todo-card.priority-medium::before   { background: #f59e0b; }
.todo-card.priority-low::before      { background: #06b6d4; }

.todo-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,0,0,.3);
  border-color: rgba(99,102,241,.25);
}

.todo-card__top {
  display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
  margin-bottom: .65rem;
}

/* Priority badge */
.priority-badge {
  font-size: .62rem; font-weight: 800; letter-spacing: .5px;
  text-transform: uppercase; padding: .2rem .65rem; border-radius: 50px;
}
.priority-badge--critical { background: rgba(244,63,94,.15);  color: #fb7185; border: 1px solid rgba(244,63,94,.3); }
.priority-badge--high     { background: rgba(249,115,22,.15); color: #fb923c; border: 1px solid rgba(249,115,22,.3); }
.priority-badge--medium   { background: rgba(245,158,11,.15); color: #fbbf24; border: 1px solid rgba(245,158,11,.3); }
.priority-badge--low      { background: rgba(6,182,212,.12);  color: #22d3ee; border: 1px solid rgba(6,182,212,.25); }

.group-tag {
  font-size: .62rem; font-weight: 700; padding: .2rem .65rem;
  border-radius: 50px; border: 1px solid transparent;
  text-transform: uppercase; letter-spacing: .3px;
}

.todo-card__title {
  font-size: .875rem; font-weight: 700; color: #e2e8f0;
  line-height: 1.45; margin: 0 0 .5rem;
}

.todo-card__note {
  font-size: .78rem; color: #64748b; line-height: 1.6; margin: 0 0 .65rem;
}

.todo-card__meta {
  display: flex; align-items: center; gap: .65rem; flex-wrap: wrap;
  font-size: .72rem; color: #475569;
}
.todo-card__assignee { display: flex; align-items: center; gap: .4rem; }
.assignee-avatar {
  width: 20px; height: 20px; border-radius: 50%;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: inline-flex; align-items: center; justify-content: center;
  font-size: .6rem; font-weight: 800; color: #fff; flex-shrink: 0;
}
.todo-card__recurring { color: #818cf8; }

.todo-card__completed {
  margin-top: .6rem;
  font-size: .7rem; color: #10b981;
  display: flex; align-items: center;
}

/* ─── States ───────────────────────────────────────────── */
.todo-loading { padding: 2rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }
.todo-skeleton {
  height: 140px; background: rgba(255,255,255,.04); border-radius: 12px;
  animation: shimmer 1.4s infinite;
}
@keyframes shimmer {
  0%   { opacity: .5; }
  50%  { opacity: 1; }
  100% { opacity: .5; }
}

.todo-error, .todo-empty {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  color: #374151; padding: 3rem;
}
.todo-error__icon, .todo-empty__icon {
  font-size: 3.5rem; margin-bottom: 1rem; opacity: .4;
}
.todo-error h3, .todo-empty h3 { color: #64748b; font-size: 1.1rem; margin: 0 0 .5rem; }
.todo-error p,  .todo-empty p  { color: #374151; font-size: .875rem; }
.btn-retry {
  margin-top: .75rem;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff; border: none; border-radius: 10px;
  padding: .6rem 1.5rem; font-weight: 700; cursor: pointer;
  transition: opacity .2s;
}
.btn-retry:hover { opacity: .85; }

/* ─── Scrollbar ────────────────────────────────────────── */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 10px; }

/* ─── Responsive ───────────────────────────────────────── */
@media (max-width: 900px) {
  .todo-sidebar { width: 220px; }
  .todo-search input { width: 130px; }
}
@media (max-width: 700px) {
  .todo-app { flex-direction: column; }
  .todo-sidebar { width: 100%; height: auto; flex-direction: row; flex-wrap: wrap; padding: 1rem; }
  .todo-brand { margin-bottom: 0; }
  .todo-nav { flex-direction: row; flex-wrap: wrap; gap: .25rem; }
  .todo-nav__section { display: none; }
  .todo-sidebar__footer { display: none; }
  .todo-topbar { padding: 1rem; }
  .todo-kanban { padding: 1rem; }
}
</style>
