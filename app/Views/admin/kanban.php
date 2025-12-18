<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Pro - Persistent Storage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'primary': '#6366f1',
                        'todo': '#f59e0b',
                        'inprogress': '#3b82f6',
                        'done': '#10b981',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        .kanban-column { min-height: 400px; transition: all 0.3s ease; }
        .drag-over { background-color: #f1f5f9 !important; border: 2px dashed #6366f1 !important; }
        .task-card { cursor: grab; transition: transform 0.2s, box-shadow 0.2s; }
        .task-card:active { cursor: grabbing; transform: scale(0.98); }
        .task-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-900">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Kanban<span class="text-primary">Sync</span></span>
                </div>
                <div id="storage-status" class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-full border border-slate-200">
                    <div id="status-dot" class="w-2 h-2 rounded-full bg-yellow-500"></div>
                    <span id="status-text" class="text-xs font-semibold text-slate-600">Inisialisasi...</span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom To Do -->
            <div class="flex flex-col bg-slate-100 rounded-2xl p-4 min-h-[500px] border border-slate-200">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-todo"></span> To-Do
                    </h3>
                    <button onclick="openForm('todo')" class="p-2 hover:bg-green-200 rounded text-green-800">
                        <i class="fas fa-plus me-1"></i> Tambah Tugas
                    </button>
                </div>
                <div id="col-todo" class="kanban-column space-y-3 p-2 rounded-xl border-2 border-transparent" ondragover="event.preventDefault(); this.classList.add('drag-over')" ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event, 'todo')"></div>
            </div>

            <!-- Kolom In Progress -->
            <div class="flex flex-col bg-slate-100 rounded-2xl p-4 min-h-[500px] border border-slate-200">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-inprogress"></span> Sedang Dikerjakan
                    </h3>
                </div>
                <div id="col-inprogress" class="kanban-column space-y-3 p-2 rounded-xl border-2 border-transparent" ondragover="event.preventDefault(); this.classList.add('drag-over')" ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event, 'inprogress')"></div>
            </div>

            <!-- Kolom Done -->
            <div class="flex flex-col bg-slate-100 rounded-2xl p-4 min-h-[500px] border border-slate-200">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-done"></span> Selesai
                    </h3>
                </div>
                <div id="col-done" class="kanban-column space-y-3 p-2 rounded-xl border-2 border-transparent" ondragover="event.preventDefault(); this.classList.add('drag-over')" ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event, 'done')"></div>
            </div>
        </div>
    </main>

    <!-- Modal Form -->
    <div id="modal-form" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="p-6">
                <h2 id="modal-title" class="text-xl font-bold mb-4">Tambah Tugas</h2>
                <div class="space-y-4">
                    <input type="text" id="task-title" placeholder="Judul Tugas" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-primary">
                    <textarea id="task-desc" placeholder="Deskripsi (Opsional)" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-primary"></textarea>
                </div>
            </div>
            <div class="bg-slate-50 p-4 flex gap-3">
                <button onclick="closeForm()" class="flex-1 py-2 font-semibold text-slate-600">Batal</button>
                <button onclick="saveTask()" class="flex-1 py-2 bg-primary text-white rounded-lg font-bold">Simpan</button>
            </div>
        </div>
    </div>

    <script type="module">
        let tasks = [];
        let isCloudMode = false;
        
        // Data Handling
        const STORAGE_KEY = 'kanban_tasks_local';

        function init() {
            // Coba ambil dari LocalStorage dulu sebagai fallback instan
            const localData = localStorage.getItem(STORAGE_KEY);
            if (localData) {
                tasks = JSON.parse(localData);
                renderBoard();
            }

            // Cek apakah konfigurasi Firebase ada
            const firebaseConfig = typeof __firebase_config !== 'undefined' ? JSON.parse(__firebase_config) : null;
            
            if (firebaseConfig) {
                setupCloud(firebaseConfig);
            } else {
                updateStatus('offline');
                console.log("Menggunakan LocalStorage karena Cloud Config tidak ditemukan.");
            }
        }

        function updateStatus(mode) {
            const dot = document.getElementById('status-dot');
            const text = document.getElementById('status-text');
            if (mode === 'online') {
                dot.className = "w-2 h-2 rounded-full bg-green-500";
                text.textContent = "Cloud Tersinkron";
                isCloudMode = true;
            } else {
                dot.className = "w-2 h-2 rounded-full bg-blue-500";
                text.textContent = "Penyimpanan Lokal";
                isCloudMode = false;
            }
        }

        // Render UI
        function renderBoard() {
            const cols = { todo: 'col-todo', inprogress: 'col-inprogress', done: 'col-done' };
            Object.values(cols).forEach(id => document.getElementById(id).innerHTML = '');

            tasks.forEach(task => {
                const container = document.getElementById(`col-${task.status}`);
                if (!container) return;

                const card = document.createElement('div');
                card.className = 'task-card bg-white p-4 rounded-xl border border-slate-200 shadow-sm';
                card.draggable = true;
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-slate-800">${task.title}</h4>
                        <button onclick="deleteTask('${task.id}')" class="text-slate-300 hover:text-red-500">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-500">${task.description || ''}</p>
                `;
                card.ondragstart = (e) => e.dataTransfer.setData('taskId', task.id);
                container.appendChild(card);
            });

            // Simpan ke LocalStorage setiap ada perubahan
            localStorage.setItem(STORAGE_KEY, JSON.stringify(tasks));
        }

        // Action Functions
        window.saveTask = () => {
            const title = document.getElementById('task-title').value;
            const desc = document.getElementById('task-desc').value;
            if (!title) return;

            const newTask = {
                id: Date.now().toString(),
                title,
                description: desc,
                status: 'todo'
            };

            tasks.push(newTask);
            renderBoard();
            closeForm();
        };

        window.deleteTask = (id) => {
            tasks = tasks.filter(t => t.id !== id);
            renderBoard();
        };

        window.handleDrop = (e, newStatus) => {
            e.preventDefault();
            const id = e.dataTransfer.getData('taskId');
            const task = tasks.find(t => t.id === id);
            if (task) {
                task.status = newStatus;
                renderBoard();
            }
            e.currentTarget.classList.remove('drag-over');
        };

        window.openForm = (status) => {
            document.getElementById('modal-form').classList.remove('hidden');
            document.getElementById('task-title').value = '';
            document.getElementById('task-desc').value = '';
        };

        window.closeForm = () => {
            document.getElementById('modal-form').classList.add('hidden');
        };

        // Inisialisasi saat window dimuat
        window.onload = init;
    </script>
</body>
</html>