<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Board Real-time</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'primary': '#4f46e5',
                        'todo': '#f97316',
                        'inprogress': '#0ea5e9',
                        'done': '#10b981',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        .kanban-column::-webkit-scrollbar { width: 5px; }
        .kanban-column::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .task-card { cursor: grab; transition: all 0.2s ease; }
        .task-card:active { cursor: grabbing; transform: translateY(-2px); }
        .drag-over { border: 2px dashed #4f46e5 !important; background-color: #eef2ff !important; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-900">

    <!-- Status Overlay -->
    <div id="status-overlay" class="fixed inset-0 bg-white z-[60] flex items-center justify-center p-6 text-center transition-opacity duration-500">
        <div class="max-w-sm">
            <div id="status-spinner" class="animate-spin rounded-full h-10 w-10 border-t-2 border-primary mx-auto mb-4"></div>
            <h2 id="status-title" class="text-lg font-bold">Menghubungkan...</h2>
            <p id="status-message" class="text-slate-500 text-sm mt-2">Menyiapkan lingkungan kerja Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-4 md:p-8">
        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Kanban <span class="text-primary">Proyek</span></h1>
                <p id="mode-display" class="text-slate-400 text-xs mt-1 font-mono uppercase tracking-wider">Menghubungkan ke Cloud...</p>
            </div>
            <div class="flex gap-2">
                <div id="connection-badge" class="bg-white shadow-sm border border-slate-200 px-4 py-2 rounded-xl flex items-center gap-2">
                    <div id="status-dot" class="h-2 w-2 rounded-full bg-slate-300"></div>
                    <span id="status-text" class="text-xs font-bold text-slate-600">Checking...</span>
                </div>
            </div>
        </header>

        <div id="board" class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            <!-- Kolom Persiapan -->
            <div class="flex flex-col bg-slate-100 rounded-2xl p-4 min-h-[500px] border border-slate-200" 
                 ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'todo')">
                <div class="flex justify-between items-center mb-4 px-2">
                    <h2 class="font-extrabold text-slate-700 flex items-center gap-2 text-sm uppercase">
                        <span class="w-2 h-5 bg-todo rounded-full"></span> Persiapan
                    </h2>
                    <span id="count-todo" class="bg-white text-slate-500 text-[10px] px-2 py-0.5 rounded-full border border-slate-200 font-bold">0</span>
                </div>
                <div id="list-todo" class="space-y-3 flex-grow"></div>
                <button onclick="openModal('todo')" class="mt-4 w-full py-3 bg-white border border-slate-200 rounded-xl text-slate-500 text-sm font-bold hover:border-primary hover:text-primary transition-all shadow-sm">
                    + Tambah Kartu
                </button>
            </div>

            <!-- Kolom Berjalan -->
            <div class="flex flex-col bg-slate-100 rounded-2xl p-4 min-h-[500px] border border-slate-200"
                 ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'inprogress')">
                <div class="flex justify-between items-center mb-4 px-2">
                    <h2 class="font-extrabold text-slate-700 flex items-center gap-2 text-sm uppercase">
                        <span class="w-2 h-5 bg-inprogress rounded-full"></span> Berjalan
                    </h2>
                    <span id="count-inprogress" class="bg-white text-slate-500 text-[10px] px-2 py-0.5 rounded-full border border-slate-200 font-bold">0</span>
                </div>
                <div id="list-inprogress" class="space-y-3 flex-grow"></div>
                <button onclick="openModal('inprogress')" class="mt-4 w-full py-3 bg-white border border-slate-200 rounded-xl text-slate-500 text-sm font-bold hover:border-primary hover:text-primary transition-all shadow-sm">
                    + Tambah Kartu
                </button>
            </div>

            <!-- Kolom Selesai -->
            <div class="flex flex-col bg-slate-100 rounded-2xl p-4 min-h-[500px] border border-slate-200"
                 ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'done')">
                <div class="flex justify-between items-center mb-4 px-2">
                    <h2 class="font-extrabold text-slate-700 flex items-center gap-2 text-sm uppercase">
                        <span class="w-2 h-5 bg-done rounded-full"></span> Selesai
                    </h2>
                    <span id="count-done" class="bg-white text-slate-500 text-[10px] px-2 py-0.5 rounded-full border border-slate-200 font-bold">0</span>
                </div>
                <div id="list-done" class="space-y-3 flex-grow"></div>
                <button onclick="openModal('done')" class="mt-4 w-full py-3 bg-white border border-slate-200 rounded-xl text-slate-500 text-sm font-bold hover:border-primary hover:text-primary transition-all shadow-sm">
                    + Tambah Kartu
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8">
            <h2 id="modal-title" class="text-xl font-black mb-6">Edit Kegiatan</h2>
            <div class="space-y-4">
                <input type="text" id="inp-title" placeholder="Judul Tugas" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <textarea id="inp-desc" rows="3" placeholder="Keterangan tambahan..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                <input type="url" id="inp-img" placeholder="URL Gambar (Opsional)" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <input type="hidden" id="active-id">
            <input type="hidden" id="active-status">
            <div class="flex gap-3 mt-8">
                <button onclick="closeModal()" class="flex-1 py-4 text-slate-500 font-bold">Batal</button>
                <button onclick="saveTask()" class="flex-1 py-4 bg-primary text-white rounded-2xl font-black shadow-lg shadow-primary/20">Simpan</button>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, collection, doc, onSnapshot, setDoc, deleteDoc, updateDoc, serverTimestamp, query, orderBy } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // Global state
        let db, auth, currentUserId;
        let isLocalMode = false;
        let localTasks = [];

        const appId = typeof __app_id !== 'undefined' ? __app_id : 'kanban-default';
        const publicPath = `artifacts/${appId}/public/data/tasks`;

        async function startApp() {
            try {
                // Mencoba memparsing config
                if (typeof __firebase_config === 'undefined') throw new Error("No Config");
                
                const firebaseConfig = JSON.parse(__firebase_config);
                if (!firebaseConfig.projectId) throw new Error("Invalid Config");

                const app = initializeApp(firebaseConfig);
                db = getFirestore(app);
                auth = getAuth(app);

                const token = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;
                if (token) {
                    await signInWithCustomToken(auth, token);
                } else {
                    await signInAnonymously(auth);
                }

                onAuthStateChanged(auth, (user) => {
                    if (user) {
                        currentUserId = user.uid;
                        setConnectionStatus(true, `Sesi: ${user.uid.substring(0,8)}...`);
                        hideOverlay();
                        initFirestore();
                    }
                });

            } catch (err) {
                console.warn("Firebase gagal dimuat, beralih ke mode lokal:", err.message);
                switchToLocalMode();
            }
        }

        function switchToLocalMode() {
            isLocalMode = true;
            currentUserId = 'local-user';
            setConnectionStatus(false, "Mode Demo Lokal (Tanpa Cloud)");
            hideOverlay();
            renderTasks();
        }

        function setConnectionStatus(online, text) {
            const dot = document.getElementById('status-dot');
            const badgeText = document.getElementById('status-text');
            const modeDisplay = document.getElementById('mode-display');
            
            dot.className = `h-2 w-2 rounded-full ${online ? 'bg-green-500 animate-pulse' : 'bg-amber-500'}`;
            badgeText.textContent = online ? "Terhubung Cloud" : "Lokal";
            modeDisplay.textContent = text;
        }

        function hideOverlay() {
            const overlay = document.getElementById('status-overlay');
            overlay.style.opacity = '0';
            setTimeout(() => overlay.classList.add('hidden'), 500);
        }

        function initFirestore() {
            const q = query(collection(db, publicPath), orderBy("updatedAt", "desc"));
            onSnapshot(q, (snapshot) => {
                localTasks = [];
                snapshot.forEach(d => localTasks.push({ id: d.id, ...d.data() }));
                renderTasks();
            }, (err) => {
                console.error("Firestore Listen Error:", err);
                switchToLocalMode();
            });
        }

        function renderTasks() {
            const groups = { todo: [], inprogress: [], done: [] };
            localTasks.forEach(t => {
                if (groups[t.status]) groups[t.status].push(t);
            });

            ['todo', 'inprogress', 'done'].forEach(status => {
                const list = document.getElementById(`list-${status}`);
                const count = document.getElementById(`count-${status}`);
                list.innerHTML = '';
                count.textContent = groups[status].length;

                groups[status].forEach(task => {
                    const card = document.createElement('div');
                    card.className = 'task-card bg-white p-4 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md';
                    card.draggable = true;
                    card.dataset.id = task.id;
                    
                    card.ondragstart = (e) => {
                        e.dataTransfer.setData('taskId', task.id);
                        card.style.opacity = '0.5';
                    };
                    card.ondragend = () => card.style.opacity = '1';

                    const imgHtml = task.imageUrl ? `<img src="${task.imageUrl}" class="w-full h-24 object-cover rounded-xl mb-3 bg-slate-100" onerror="this.style.display='none'">` : '';

                    card.innerHTML = `
                        ${imgHtml}
                        <h3 class="font-bold text-slate-800 text-sm leading-tight">${task.title}</h3>
                        ${task.description ? `<p class="text-xs text-slate-400 mt-1 line-clamp-2">${task.description}</p>` : ''}
                        <div class="flex justify-end gap-3 mt-4 pt-3 border-t border-slate-50">
                            <button onclick="window.openModal('${task.status}', ${JSON.stringify(task).replace(/"/g, '&quot;')})" class="text-[10px] font-black uppercase text-primary tracking-tighter">Edit</button>
                            <button onclick="window.deleteTask('${task.id}')" class="text-[10px] font-black uppercase text-red-400 tracking-tighter">Hapus</button>
                        </div>
                    `;
                    list.appendChild(card);
                });
            });
        }

        // Window exposed functions
        window.openModal = (status, task = null) => {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('active-status').value = status;
            document.getElementById('active-id').value = task ? task.id : '';
            document.getElementById('inp-title').value = task ? task.title : '';
            document.getElementById('inp-desc').value = task ? task.description : '';
            document.getElementById('inp-img').value = task ? task.imageUrl : '';
            document.getElementById('modal-title').textContent = task ? 'Ubah Tugas' : 'Tugas Baru';
        };

        window.closeModal = () => document.getElementById('modal').classList.add('hidden');

        window.saveTask = async () => {
            const title = document.getElementById('inp-title').value.trim();
            if (!title) return;

            const id = document.getElementById('active-id').value || 'id-' + Date.now();
            const status = document.getElementById('active-status').value;
            const data = {
                id,
                title,
                description: document.getElementById('inp-desc').value,
                imageUrl: document.getElementById('inp-img').value,
                status,
                updatedAt: new Date().toISOString(),
                userId: currentUserId
            };

            if (isLocalMode) {
                const idx = localTasks.findIndex(t => t.id === id);
                if (idx > -1) localTasks[idx] = data;
                else localTasks.unshift(data);
                renderTasks();
            } else {
                await setDoc(doc(db, publicPath, id), { ...data, updatedAt: serverTimestamp() }, { merge: true });
            }
            closeModal();
        };

        window.deleteTask = async (id) => {
            if (isLocalMode) {
                localTasks = localTasks.filter(t => t.id !== id);
                renderTasks();
            } else {
                await deleteDoc(doc(db, publicPath, id));
            }
        };

        window.handleDragOver = (e) => {
            e.preventDefault();
            e.currentTarget.classList.add('drag-over');
        };

        window.handleDragLeave = (e) => {
            e.currentTarget.classList.remove('drag-over');
        };

        window.handleDrop = async (e, newStatus) => {
            e.preventDefault();
            e.currentTarget.classList.remove('drag-over');
            const id = e.dataTransfer.getData('taskId');
            
            if (isLocalMode) {
                const task = localTasks.find(t => t.id === id);
                if (task) {
                    task.status = newStatus;
                    renderTasks();
                }
            } else {
                await updateDoc(doc(db, publicPath, id), { 
                    status: newStatus,
                    updatedAt: serverTimestamp() 
                });
            }
        };

        startApp();
    </script>
</body>
</html>