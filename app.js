document.addEventListener('DOMContentLoaded', function () {
  const addForm = document.getElementById('addForm');
  const tasksEl = document.getElementById('tasks');

  function fetchTasks() {
    return fetch(window.location.pathname, {headers:{'X-Requested-With':'XMLHttpRequest'}})
      .then(r=>r.json())
      .catch(err => {
        console.error('Error fetching tasks:', err);
        return [];
      });
  }

  function render(tasks) {
    if (!Array.isArray(tasks)) tasks = [];
    const ul = document.createElement('ul'); 
    ul.className = 'tasks';
    
    if (tasks.length === 0) {
      const li = document.createElement('li'); 
      li.className='empty'; 
      li.textContent='Belum ada tugas. Tambah tugas di form di atas.'; 
      ul.appendChild(li);
    } else {
      tasks.forEach(t=>{
        const li = document.createElement('li'); 
        li.className='task'+(t.completed? ' done':''); 
        li.setAttribute('data-id', t.id);
        
        const toggle = document.createElement('button'); 
        toggle.className='check'; 
        toggle.textContent = t.completed? '↺':'✓';
        toggle.addEventListener('click', (e)=>{ 
          e.preventDefault(); 
          action('toggle',{id:t.id}); 
        });
        
        const span = document.createElement('span'); 
        span.className='text'; 
        span.textContent = t.text;
        
        const del = document.createElement('button'); 
        del.className='delete'; 
        del.textContent='✕'; 
        del.addEventListener('click', (e)=>{ 
          e.preventDefault(); 
          action('delete',{id:t.id}); 
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
      method:'POST', 
      body:fd, 
      headers:{'X-Requested-With':'XMLHttpRequest'}
    })
      .then(r=>r.json())
      .then(render)
      .catch(err => {
        console.error('Error during action:', err);
        alert('Terjadi kesalahan. Silakan coba lagi.');
      });
  }

  addForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const text = (this.text.value || '').trim();
    if (!text) {
      alert('Tugas tidak boleh kosong');
      return;
    }
    action('add', {text});
    this.text.value = '';
    this.text.focus();
  });

  // initial load
  fetchTasks().then(render).catch(()=>{});
});
