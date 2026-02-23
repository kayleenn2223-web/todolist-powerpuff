document.addEventListener('DOMContentLoaded', function () {
    const addForm = document.getElementById('addForm');
    const tasksEl = document.getElementById('tasks');
    let currentFilter = 'all'; // Menyimpan status filter aktif

    // 1. Ambil data dari PHP
    function fetchTasks() {
        return fetch(window.location.pathname, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(r => r.json());
    }

    // 2. Fungsi untuk mengubah waktu timestamp ke format Jam:Menit
    function formatTime(timestamp) {
        const date = new Date(timestamp * 1000);
        return date.getHours().toString().padStart(2, '0') + ':' + 
               date.getMinutes().toString().padStart(2, '0');
    }

    // 3. Render HTML secara dinamis
    function render(tasks) {
        if (!Array.isArray(tasks)) tasks = [];
        
        const ul = document.createElement('ul'); 
        ul.className = 'tasks';

        if (tasks.length === 0) {
            const li = document.createElement('li'); 
            li.className = 'empty'; 
            li.textContent = 'Belum ada tugas. Semangat ya, Baby Zey!'; 
            ul.appendChild(li);
        } else {
            tasks.forEach(t => {
                const status = t.completed ? 'done' : 'pending';
                
                // Logika Filter: Jika tidak sesuai filter, jangan tampilkan
                if (currentFilter !== 'all' && currentFilter !== status) return;

                const li = document.createElement('li');
                li.className = 'task' + (t.completed ? ' done' : '');
                li.setAttribute('data-id', t.id);
                li.setAttribute('data-status', status);

                // Tombol Check
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'check';
                toggleBtn.textContent = t.completed ? '↺' : '✓';
                toggleBtn.onclick = () => action('toggle', { id: t.id });

                // Konten Teks & Waktu
                const contentDiv = document.createElement('div');
                contentDiv.className = 'task-content';
                contentDiv.style.flex = '1';
                contentDiv.style.marginLeft = '10px';
                
                const span = document.createElement('span');
                span.className = 'text';
                span.textContent = t.text; // Menggunakan textContent lebih aman dari XSS

                const small = document.createElement('small');
                small.style.display = 'block';
                small.style.fontSize = '10px';
                small.style.color = '#94a3b8';
                small.textContent = 'Dibuat: ' + formatTime(t.created_at);

                contentDiv.appendChild(span);
                contentDiv.appendChild(small);

                // Tombol Hapus
                const delBtn = document.createElement('button');
                delBtn.className = 'delete';
                delBtn.textContent = '✕';
                delBtn.onclick = () => {
                    li.style.opacity = '0';
                    li.style.transform = 'translateX(20px)';
                    setTimeout(() => action('delete', { id: t.id }), 200);
                };

                li.appendChild(toggleBtn);
                li.appendChild(contentDiv);
                li.appendChild(delBtn);
                ul.appendChild(li);
            });
        }
        
        tasksEl.innerHTML = ''; 
        tasksEl.appendChild(ul);
    }

    // 4. Kirim aksi ke PHP (Add/Toggle/Delete)
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
        .then(render)
        .catch(console.error);
    }

    // 5. Event Listener untuk Form Tambah
    addForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const text = (this.text.value || '').trim();
        if (!text) return;
        action('add', { text });
        this.text.value = '';
    });

    // 6. Fitur Filter (Logika Klik Tombol)
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Ubah tampilan tombol aktif
            document.querySelector('.filter-btn.active').classList.remove('active');
            this.classList.add('active');
            
            // Set filter dan render ulang
            currentFilter = this.dataset.filter;
            fetchTasks().then(render);
        });
    });

    // Load data pertama kali
    fetchTasks().then(render).catch(() => {});
});