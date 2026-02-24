document.addEventListener('DOMContentLoaded', function () {

  const addForm = document.getElementById('addForm');
  const tasksEl = document.getElementById('tasks');

  let allTasks = [];
  let currentFilter = "Semua";

  function fetchTasks() {
    return fetch(window.location.pathname, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(r => r.json());
  }

  function applyFilter() {
    let filtered = allTasks;

    if (currentFilter === "Belum") {
      filtered = allTasks.filter(t => !t.completed);
    } 
    else if (currentFilter === "Selesai") {
      filtered = allTasks.filter(t => t.completed);
    }

    render(filtered);
  }

  function render(tasks) {
    if (!Array.isArray(tasks)) tasks = [];

    const ul = document.createElement('ul');
    ul.className = 'tasks';

    if (tasks.length === 0) {
      const li = document.createElement('li');
      li.className = 'empty';
      li.textContent = 'Belum ada tugas.';
      ul.appendChild(li);
    } else {
      tasks.forEach(t => {
        const li = document.createElement('li');
        li.className = 'task' + (t.completed ? ' done' : '');

        const toggle = document.createElement('button');
        toggle.className = 'check';
        toggle.textContent = t.completed ? '↺' : '✓';
        toggle.addEventListener('click', () => {
          action('toggle', { id: t.id });
        });

        const span = document.createElement('span');
        span.className = 'text';
        span.innerHTML = t.text;

        const del = document.createElement('button');
        del.className = 'delete';
        del.textContent = '✕';
        del.addEventListener('click', () => {
          action('delete', { id: t.id });
        });

        li.appendChild(toggle);
        li.appendChild(span);
        li.appendChild(del);
        ul.appendChild(li);
      });
    }

    tasksEl.innerHTML = '';
    tasksEl.appendChild(ul);
  }

  function action(act, data) {
    const fd = new FormData();
    fd.append('action', act);
    for (const k in data) fd.append(k, data[k]);

    fetch(window.location.pathname, {
      method: 'POST',
      body: fd,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(r => r.json())
      .then(tasks => {
        allTasks = tasks;
        applyFilter();
      })
      .catch(console.error);
  }

  // FILTER BUTTON
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {

      document.querySelectorAll('.filter-btn')
        .forEach(b => b.classList.remove('active'));

      this.classList.add('active');
      currentFilter = this.innerText;

      applyFilter();
    });
  });

  // ADD FORM
  addForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const text = (this.text.value || '').trim();
    if (!text) return;

    action('add', { text });
    this.text.value = '';
  });

  // INITIAL LOAD
  fetchTasks().then(tasks => {
    allTasks = tasks;
    applyFilter();
  }).catch(() => {});

});