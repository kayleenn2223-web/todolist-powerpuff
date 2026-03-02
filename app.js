document.addEventListener('DOMContentLoaded', function () {

    const addForm = document.getElementById('addForm');
    const tasksEl = document.getElementById('tasks');
    let allTasks = [];
    let currentFilter = 'all';

    function fetchTasks() {
        return fetch(window.location.pathname, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(r => r.json());
    }

    function formatTime(timestamp) {
        const date = new Date(timestamp * 1000);
        return date.getHours().toString().padStart(2, '0') + ':' +
               date.getMinutes().toString().padStart(2, '0');
    }

    function applyFilter() {
        let filtered = allTasks;

        if (currentFilter === 'pending') {
            filtered = allTasks.filter(t => !t.completed);
        } else if (currentFilter === 'done') {
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

                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'check';
                toggleBtn.textContent = t.completed ? '↺' : '✓';
                toggleBtn.onclick = () => action('toggle', { id: t.id });

                const contentDiv = document.createElement('div');
                contentDiv.className = 'task-content';

                const span = document.createElement('span');
                span.className = 'text';
                span.textContent = t.text;

                const small = document.createElement('small');
                small.textContent = 'Dibuat: ' + formatTime(t.created_at);

                contentDiv.appendChild(span);
                contentDiv.appendChild(small);

                const delBtn = document.createElement('button');
                delBtn.className = 'delete';
                delBtn.textContent = '✕';
                delBtn.onclick = () => action('delete', { id: t.id });

                li.appendChild(toggleBtn);
                li.appendChild(contentDiv);
                li.appendChild(delBtn);
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

    addForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const text = (this.text.value || '').trim();
        if (!text) return;

        action('add', { text });
        this.text.value = '';
    });

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            document.querySelectorAll('.filter-btn')
                .forEach(b => b.classList.remove('active'));

            this.classList.add('active');
            currentFilter = this.dataset.filter;

            applyFilter();
        });
    });

    fetchTasks().then(tasks => {
        allTasks = tasks;
        applyFilter();
    });

});